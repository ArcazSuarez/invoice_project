<?php

namespace App\Jobs;

use App\Actions\CreateUpdateInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessInvoiceUpdateCreate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $user_id;
    protected $invoice_code;
    protected $invoice_items;
    protected $total;
    /**
     * Create a new job instance.
     */
    public function __construct($name, $user_id ,$invoice_code,$invoice_items,$total)
    {
        $this->name = $name;
        $this->user_id = $user_id;
        $this->invoice_code = $invoice_code;
        $this->invoice_items = $invoice_items;
        $this->total = $total;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new CreateUpdateInvoice)->execute(
            $this->name,
            $this->user_id,
            $this->invoice_code,
            $this->invoice_items,
            $this->total,
        );
    }
}
