<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        \App\Models\Customer::factory()->create([
            'name' => 'Walk-in Customer',
            'email' => 'walkin@example.com',
        ]);


        // Invoice::factory()
        //     ->count(10)
        //     ->create()
        //     ->each(function ($invoice) {
        //         InvoiceItem::factory()
        //             ->count(3)
        //             ->state(['invoice_code' => $invoice->code])
        //             ->create();
        //     });


        // Invoice::factory()
        //     ->count(100)
        //     ->create()
        //     ->each(function ($invoice) {
        //         $items = InvoiceItem::factory()
        //             ->count(3)
        //             ->state(['invoice_code' => $invoice->code])
        //             ->create();

        //         $total = $items->sum('subtotal');
        //         $invoice->update(['total' => $total]);
        //     });
        $daysAgo = 0;

        Invoice::factory()
            ->count(100)
            ->create()
            ->each(function ($invoice) use (&$daysAgo) {
                $items = InvoiceItem::factory()
                    ->count(3)
                    ->state(['invoice_code' => $invoice->code])
                    ->create();

                $total = $items->sum('subtotal');
                $invoice->update([
                    'total' => $total,
                    'created_at' => Carbon::now()->subDays($daysAgo)
                ]);

                $daysAgo++;
            });
    }
}
