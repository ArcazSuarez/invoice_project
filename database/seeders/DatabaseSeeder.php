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

        $daysAgo = 0;

        Invoice::factory()
            ->count(50)
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
