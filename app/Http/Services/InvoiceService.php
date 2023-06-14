<?php

namespace App\Http\Services;

use App\Http\Traits\CodeGenerator;
use App\Http\Traits\ValidatesInvoice;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    use ValidatesInvoice;
    use CodeGenerator;

    public $product_name;
    public $quantity;
    public $price;
    public $total = 0;
    public $invoice_items = [];
    public $name;

    protected $addItemRules = [
        'product_name' => 'required',
        'quantity' => 'required|numeric|min:1|max:100',
        'price' => 'required|numeric|min:1|max: 1000',
    ];

    public function save($name,$invoice_items,$invoice_code = null)
    {
        $this->invoice_items = $invoice_items;
        $this->validateInput(['name' => $name,], ['name' => ['required','string']]);
        $this->total = $this->updateTotalInvoiceValue($this->invoice_items);
        $this->checkInvoiceItems();
        DB::beginTransaction();
        try {
            $invoice_code = ($invoice_code) ? $invoice_code : $this->generateCodeWithPrefix('invoices', 'INV-', 'code');
            $invoice = Invoice::updateOrCreate(['code' => $invoice_code],[
                'code' => $invoice_code ,
                'user_id' => Auth::User()->id,
                'customer_name' => $name,
                'total' => $this->total,
            ]);
            InvoiceItem::where('invoice_code',$invoice->code)->ForceDelete();
            foreach ($this->invoice_items as $key => $value) {
                InvoiceItem::create([
                    'invoice_code' => $invoice['code'],
                    'name' => $value['name'],
                    'qty' => $value['quantity'],
                    'price' => $value['price'],
                    'subtotal' => $value['subtotal'],
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function addItems($product_name,$quantity,$price,$invoice_items)
    {
        $this->invoice_items = $invoice_items;
        $this->validateInput(['product_name' =>$product_name,
        'quantity' => $quantity,
        'price' => $price], $this->addItemRules);
        $productExists = $this->findAndUpdateMatchingProduct($product_name,$quantity);
        if (!$productExists) {
            $this->invoice_items = $this->addNewProductToInvoiceItems($product_name,$quantity,$price,$this->invoice_items);
        }

        $this->total = $this->updateTotalInvoiceValue($this->invoice_items);
        return ['invoice_items' => $this->invoice_items, 'total' => $this->total];
    }

    public function removeItem($key, $invoice_items)
    {
        $this->invoice_items = $invoice_items;
        array_splice($this->invoice_items, $key, 1);
        $this->invoice_items = array_values($this->invoice_items);
        $this->total = $this->updateTotalInvoiceValue($this->invoice_items);
        return ['invoice_items' => $this->invoice_items, 'total' => $this->total];
    }

    public function updateTotalInvoiceValue($invoice_items)
    {
        return array_reduce($invoice_items, function ($carry, $item) {
            return $carry + $item['subtotal'];
        }, 0);
    }

    public function addNewProductToInvoiceItems($product_name,$quantity,$price,$invoice_items)
    {
        array_push($invoice_items, [
            "name" => $product_name,
            "quantity" => $quantity,
            "price" => $price,
            "subtotal" => $price * $quantity,
        ]);
        return $invoice_items;
    }

    private function findAndUpdateMatchingProduct($product_name,$quantity)
    {
        $searchString = trim($product_name);

        $matchingProducts = collect($this->invoice_items)->filter(function ($item) use ($searchString) {
            return strcasecmp($item['name'], $searchString) === 0;
        });

        if ($matchingProducts->isNotEmpty()) {
            $this->updateExistingProductQuantity($searchString,$quantity);

            return true;
        }

        return false;
    }

    private function updateExistingProductQuantity($searchString,$quantity)
    {
        $this->invoice_items = array_map(function ($product) use ($searchString,$quantity) {
            if ($product['name'] == $searchString) {
                $product['quantity'] += $quantity;
                $product['subtotal'] = $product['quantity'] * $product['price'];
            }
            return $product;
        }, $this->invoice_items);
    }
}
