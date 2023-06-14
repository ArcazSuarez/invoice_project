<?php

namespace App\Http\Livewire\Invoice;

use App\Http\Services\InvoiceService;
use App\Models\Invoice;
use Livewire\Component;

class Create extends Component
{
    public $product_name;
    public $quantity;
    public $price;
    public $total = 0;
    public $invoice_items = [];
    public $invoice_code;
    public $name;

    protected $invoiceService;

    protected $listeners = ['confirm-remove' => 'removeItem'];

    public function __construct() {
        $this->invoiceService = new InvoiceService();
    }
    public function mount($id)
    {
        $this->setProperties($id);
    }

    public function render()
    {
        return view('livewire.invoice.create');
    }

    public function save()
    {
        $this->invoiceService->save($this->name,$this->invoice_items,$this->invoice_code);
        $this->reset();
        $this->resetValidation();
    }

    public function addItems()
    {
        $invoice = $this->invoiceService->addItems($this->product_name,$this->quantity,$this->price,$this->invoice_items);
        $this->invoice_items = $invoice['invoice_items'];
        $this->total = $invoice['total'];
        $this->resetExcept('invoice_items','total','name','invoice_code');
        $this->resetValidation();
    }

    public function removeItem($key)
    {
        $invoice = $this->invoiceService->removeItem($key, $this->invoice_items);
        $this->invoice_items = $invoice['invoice_items'];
        $this->total = $invoice['total'];
        $this->resetExcept('invoice_items','total','name','invoice_code');
        $this->resetValidation();
    }

    private function setProperties($id){
        $invoice = Invoice::where('code',$id)->with('items')->first();
        if(!$invoice){
            return redirect()->route('dashboard');
        }
        $this->invoice_code = $invoice->code;
        $this->name = $invoice->customer_name;
        foreach ($invoice->items as $key => $value) {
            $this->invoice_items = $this->invoiceService->addNewProductToInvoiceItems($value->name,$value->qty,$value->price,$this->invoice_items);
        }
        $this->total = $this->invoiceService->updateTotalInvoiceValue($this->invoice_items);
    }
}
