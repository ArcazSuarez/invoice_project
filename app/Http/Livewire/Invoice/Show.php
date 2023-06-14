<?php

namespace App\Http\Livewire\Invoice;

use App\Http\Services\InvoiceService;
use App\Models\Invoice;
use Illuminate\Routing\Route;
use Livewire\Component;

class Show extends Component
{
    public $product_name;
    public $quantity;
    public $price;
    public $total = 0;
    public $invoice_items = [];
    public $invoice_code;
    public $invoice_date;
    public $invoice_updated_date;
    public $name;

    protected $invoiceService;

    public function mount($id = null)
    {
        $this->invoiceService = new InvoiceService;
        $this->setProperties($id);
    }

    public function render()
    {
        return view('livewire.invoice.show');
    }

    private function setProperties($id){
        $invoice = Invoice::where('code',$id)->with('items')->first();
        if(!$invoice){
            return redirect()->route('dashboard');
        }
        $this->invoice_code = $invoice->code;
        $this->name = $invoice->customer_name;
        $this->invoice_date = $invoice->created_at;
        $this->invoice_updated_date = $invoice->updated_at;
        foreach ($invoice->items as $key => $value) {
            $this->invoice_items = $this->invoiceService->addNewProductToInvoiceItems($value->name,$value->qty,$value->price,$this->invoice_items);
        }
        $this->total = $this->invoiceService->updateTotalInvoiceValue($this->invoice_items);

    }
}
