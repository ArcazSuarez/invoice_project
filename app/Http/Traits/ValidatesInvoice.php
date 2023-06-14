<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait ValidatesInvoice
{

    public function validateInput(array $input, array $rules)
    {
        Validator::make($input, $rules)->validate();
    }

    public function checkInvoiceItems()
    {
        if (empty($this->invoice_items)) {
            throw ValidationException::withMessages(['product_name' => "Invoice cannot be empty"]);
        }
    }
}
