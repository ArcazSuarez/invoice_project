<?php

namespace App\Actions;

use App\Http\Traits\CodeGenerator;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CreateUpdateInvoice
{
    use CodeGenerator;

    public function execute(
        $name,
        $user_id,
        $invoice_code,
        $invoice_items,
        $total
    ): void {

            $invoice_code = ($invoice_code) ? $invoice_code : $this->generateCodeWithPrefix('invoices', 'INV-', 'code');
            $invoice = Invoice::updateOrCreate(['code' => $invoice_code],[
                'code' => $invoice_code ,
                'user_id' => $user_id,
                'customer_name' => $name,
                'total' => $total,
            ]);
            InvoiceItem::where('invoice_code',$invoice->code)->ForceDelete();
            foreach ($invoice_items as $key => $value) {
                InvoiceItem::create([
                    'invoice_code' => $invoice['code'],
                    'name' => $value['name'],
                    'qty' => $value['quantity'],
                    'price' => $value['price'],
                    'subtotal' => $value['subtotal'],
                ]);
            }
    }
}
