<?php

namespace App\Http\Livewire\Invoice;

use App\Http\Traits\CodeGenerator;
use App\Http\Traits\ValidatesInvoice;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $product_name;
    public $quantity;
    public $price;
    public $total = 0;
    public $invoice_items = [];
    public $name;

    protected $rules = [
        'product_name' => 'required',
        'quantity' => 'required|numeric|min:1|max:100',
        'price' => 'required|numeric|min:1|max: 1000',
    ];

    use ValidatesInvoice;
    use CodeGenerator;

    protected $listeners = ['confirm-remove' => 'removeItem'];

    public function render()
    {
        return view('livewire.invoice.create');
    }

    public function save()
    {
        $this->validateInput($this->getSpecificProperties([
            'name',
        ]), [
            'name' => 'required',
        ]);
        $this->updateTotalInvoiceValue();
        $this->checkInvoiceItems();
        DB::beginTransaction();
        try {
            $customer = Customer::firstOrCreate([
                'name' => $this->name,
            ],['code' => $this->generateCodeWithPrefix('customers', '', 'code')]);
            $invoice = Invoice::create([
                'code' => $this->generateCodeWithPrefix('invoices', 'INV-', 'code'),
                'user_id' => Auth::User()->id,
                'customer_code' => $customer->code,
                'total' => $this->total,
            ]);

            foreach ($this->invoice_items as $key => $value) {
                InvoiceItem::create([
                    'invoice_code' => $invoice['code'],
                    'name' => $value['name'],
                    'qty' => $value['quantity'],
                    'price' => $value['price'],
                    'subtotal' => $value['subtotal'],
                ]);
            }
            $this->reset();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function addItems()
    {
        $this->validateInput($this->getSpecificProperties([
            'product_name',
            'quantity',
            'price'
        ]), $this->rules);
        $productExists = $this->findAndUpdateMatchingProduct();

        if (!$productExists) {
            $this->addNewProductToInvoiceItems();
        }

        $this->updateTotalInvoiceValue();
        $this->resetExcept('invoice_items', 'total');
        $this->resetValidation();
    }

    private function findAndUpdateMatchingProduct()
    {
        $searchString = trim($this->product_name);

        $matchingProducts = collect($this->invoice_items)->filter(function ($item) use ($searchString) {
            return strcasecmp($item['name'], $searchString) === 0;
        });

        if ($matchingProducts->isNotEmpty()) {
            $this->updateExistingProductQuantity($searchString);

            return true;
        }

        return false;
    }

    private function updateExistingProductQuantity($searchString)
    {
        $this->invoice_items = array_map(function ($product) use ($searchString) {
            if ($product['name'] == $searchString) {
                $product['quantity'] += $this->quantity;
                $product['subtotal'] = $product['quantity'] * $product['price'];
            }
            return $product;
        }, $this->invoice_items);
    }

    private function addNewProductToInvoiceItems()
    {
        array_push($this->invoice_items, [
            "name" => $this->product_name,
            "quantity" => $this->quantity,
            "price" => $this->price,
            "subtotal" => $this->price * $this->quantity,
        ]);
    }

    private function updateTotalInvoiceValue()
    {
        $this->total = number_format(array_reduce($this->invoice_items, function ($carry, $item) {
            return $carry + $item['subtotal'];
        }, 0), 2);
    }

    public function removeItem($key)
    {
        array_splice($this->invoice_items, $key, 1);
        $this->invoice_items = array_values($this->invoice_items);
        $this->updateTotalInvoiceValue($this->invoice_items);
    }

    private function getSpecificProperties($properties = [])
    {
        $allProperties = get_object_vars($this);
        $specificProperties = [];

        foreach ($properties as $property) {
            if (array_key_exists($property, $allProperties)) {
                $specificProperties[$property] = $this->$property;
            }
        }

        return $specificProperties;
    }
}
