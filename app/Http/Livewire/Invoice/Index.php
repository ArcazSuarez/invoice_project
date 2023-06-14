<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $searchTerm;

    protected $listeners = ['confirm-remove' => 'removeInvoice'];

    public function render()
    {

        return view('livewire.invoice.index')->with([
            'invoices' => $this->getInvoices()
        ]);
    }

    private function getInvoices(){
        return Invoice::with('items')
        ->where('user_id', Auth::User()->id)
        ->when($this->searchTerm, function($query, $search){
            if (strlen($search) >= 3) {
                $query->selectRaw('*, match(code,customer_name) against(? in boolean mode) as score',[$search])
                ->whereRaw('match(code,customer_name) against(? in boolean mode)', [$search]);
            } else {
                $query->where('code', 'like', '%' . $search . '%')
                      ->orWhere('customer_name', 'like', '%' . $search . '%');
            }
        }, function ($query){
            $query->latest('created_at');
        })
        ->paginate(15);

    }

    public function removeInvoice($key){
        InvoiceItem::where('invoice_code',$key)->delete();
        Invoice::where('code',$key)->delete();
    }
}
