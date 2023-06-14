<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Validator;

trait ValidatesInvoice
{

    public function validateInput(array $input, array $rules)
    {
        Validator::make($input, $rules)->validate();
    }

    public function checkInvoiceItems()
    {
        if (empty($this->invoice_items)) {
            throw new \Exception('Invoice items cannot be empty.');
        }
    }
}
