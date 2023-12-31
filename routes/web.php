<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Invoice\Create as InvoiceCreate;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Invoice\Index as InvoiceIndex;
use App\Http\Livewire\Invoice\Show as InvoiceShow;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('dashboard', InvoiceIndex::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/invoice/create', InvoiceCreate::class)->name('invoice.create');
    Route::get('/invoice/update/{id}', InvoiceCreate::class)->name('invoice.update');
    Route::get('/invoice/show/{id}', InvoiceShow::class)->name('invoice.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
