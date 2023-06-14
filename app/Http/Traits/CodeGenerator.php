<?php

namespace App\Http\Traits;

use App\Messages;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Twilio\Rest\Client;

trait CodeGenerator
{

    protected function generateCodeWithPrefix($table, $prefix, $column ,$connection = 'mysql')
    {
        try {
            $permitted_chars = '0123456789ABCDEFGHIKLMNOPQRSTUVWXYZ';
            $code = $prefix . substr(str_shuffle($permitted_chars), 1, 10);
            $validate = DB::connection($connection)->table($table)->where($column, $code)->first();
            if ($validate) {
                $this->generateCodeWithPrefix($table, $prefix,$column);
            }
            return $code;
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
