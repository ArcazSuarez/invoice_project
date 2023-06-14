<div class="py-10">
    <div x-data="{ open: false, itemKey: null }" @remove-item.window="open = true; itemKey = $event.detail;">
        <!-- Modal Backdrop -->
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
            <!-- Modal -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200 transform"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                class="w-full px-6 py-4 bg-white dark:bg-gray-800 overflow-hidden sm:w-10/12 md:w-1/2 lg:w-1/3">
                <h2 class="text-xl font-semibold text-gray-700">Confirm Remove</h2>
                <p class="mt-1 text-gray-600">Are you sure you want to remove this item?</p>

                <div class="flex items-center mt-4">
                    <button @click="open = false"
                        class="px-4 py-2 text-gray-600 border border-gray-200 rounded-md hover:bg-gray-200">Cancel</button>
                    <button @click="$wire.emit('confirm-remove', itemKey); open = false"
                        class="ml-2 px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-500">Remove</button>
                </div>
            </div>
        </div>
    </div>

    <header>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white">Invoices</h1>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl ">
            <div class="dark:bg-gray-900">
                <div class="mx-auto max-w-7xl">
                    <div class="dark:bg-gray-800 rounded-md shadow-lg py-10">
                        <div class="px-4 sm:px-6 lg:px-8">
                            <div class="px-4 sm:px-6 lg:px-8">
                                <div class="sm:flex sm:items-center">
                                    <div class="sm:flex-auto">
                                        <h1 class="text-base font-semibold leading-6 text-gray-90 dark:text-white">
                                            Invoice</h1>
                                    </div>
                                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                                        <button wire:click="save" type="button"
                                            class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                            Save
                                        </button>
                                    </div>
                                </div>
                                <div class="flex justify-between mt-5 dark:text-slate-200">
                                    <div class="order-last">
                                        <h1>{{now()}}</h1>
                                        <div class="mt-2">
                                            {{-- <x-input-label for="name" :value="__('Customer Name')" /> --}}
                                           <x-text-input wire:model.defer='name' id="name"
                                               class="block mt-1 w-full" type="text" placeholder="Customer Name" />
                                           <div class="h-8">
                                               <x-input-error :messages="$errors->get('name')"
                                                   class="text-xs my-2" />
                                           </div>
                                       </div>
                                    </div>

                                    <div>
                                        <h4 class="dark:text-white">
                                            #{{$invoice_code}}
                                        </h4>
                                    </div>
                                    <div>

                                    </div>
                                  </div>
                                <div class="-mx-4 mt-8 flow-root sm:mx-0">
                                    <table class="min-w-full">
                                        <colgroup>
                                            <col class="w-full sm:w-1/2">
                                            <col class="sm:w-1/6">
                                            <col class="sm:w-1/6">
                                            <col class="sm:w-1/6">
                                            <col class="sm:w-1/6">
                                        </colgroup>
                                        <thead class="border-gray-300 text-gray-900 border-b border-white/10">
                                            <tr>
                                                <th scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-slate-400 sm:pl-0">
                                                    Product Name</th>
                                                <th scope="col"
                                                    class="hidden px-3 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-slate-400 sm:table-cell">
                                                    Quantity</th>
                                                <th scope="col"
                                                    class="hidden px-3 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-slate-400 sm:table-cell">
                                                    Price</th>
                                                <th scope="col"
                                                    class="py-3.5 pl-3 pr-4 text-right text-sm font-semibold text-gray-900 dark:text-slate-400 sm:pr-0">
                                                    Sub Total</th>
                                                <th scope="col"
                                                    class="py-3.5 pl-3 pr-4 text-right text-sm font-semibold text-gray-900 dark:text-slate-400 sm:pr-0">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr wire:key='add-product-form'
                                                class="border-b border-gray-200 dark:border-white/10">
                                                <form wire:submit.prevent="addItems">
                                                    <td class="max-w-0 py-5 pl-4 pr-3 text-sm sm:pl-0">
                                                        <x-text-input wire:model.defer='product_name' id="product_name"
                                                            class="block mt-1 w-full" type="text"
                                                            placeholder="Product Name" />
                                                        <div class="h-8">
                                                            <x-input-error :messages="$errors->get('product_name')"
                                                                class="text-xs my-2" />
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="hidden px-3 py-5 text-right text-sm text-gray-500 dark:text-slate-400 sm:table-cell">
                                                        <x-text-input wire:model.defer='quantity' id="quantity"
                                                            class="block mt-1 w-full" type="number" placeholder="0" />
                                                        <div class="h-8">
                                                            <x-input-error :messages="$errors->get('quantity')"
                                                                class="text-xs my-2" />
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="hidden px-3 py-5 text-right text-sm text-gray-500 dark:text-slate-400 sm:table-cell">
                                                        <x-text-input wire:model.defer='price' id="price"
                                                            class="block mt-1 w-full" type="number" placeholder="0" />
                                                        <div class="h-8">
                                                            <x-input-error :messages="$errors->get('price')"
                                                                class="text-xs my-2" />
                                                        </div>
                                                    </td>
                                                    <td colspan="2"
                                                        class="py-5 pl-3 pr-4 text-right text-sm text-gray-500 dark:text-slate-400 sm:pr-0">
                                                        <button type="submit"
                                                            class="inline-flex items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                            <svg class="-ml-0.5 h-5 w-5"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                                            </svg>

                                                            Add Product
                                                        </button>
                                                        <div class="h-8">
                                                        </div>
                                                    </td>
                                                </form>
                                            </tr>
                                            @foreach ($invoice_items as $key => $item)
                                            <tr wire:key='{{$key+1}}'
                                                class="border-b border-gray-200 dark:border-white/10">
                                                <td class="max-w-0 py-5 pl-4 pr-3 text-sm sm:pl-0">
                                                    <div class="font-medium text-gray-900 dark:text-white">
                                                        {{$item['name']}}
                                                    </div>
                                                    <div class="mt-1 truncate text-gray-500 dark:text-slate-400">New
                                                        logo and digital asset playbook.</div>
                                                </td>
                                                <td
                                                    class="hidden px-3 py-5 text-right text-sm text-gray-500 dark:text-slate-400 sm:table-cell">
                                                    {{$item['quantity']}}</td>
                                                <td
                                                    class="hidden px-3 py-5 text-right text-sm text-gray-500 dark:text-slate-400 sm:table-cell">
                                                    {{$item['price']}}</td>
                                                <td
                                                    class="py-5 pl-3 pr-4 text-right text-sm text-gray-500 dark:text-slate-400 sm:pr-0">
                                                    {{$item['subtotal']}}</td>
                                                <td
                                                    class="py-5 pl-3 pr-4 text-right text-sm text-gray-500 dark:text-slate-400 sm:pr-0">
                                                    <button type="button" x-data="{}"
                                                        @click="$dispatch('remove-item', {{ $key }})"
                                                        class="inline-flex items-center gap-x-2 rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="-ml-0.5 h-5 w-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                        <em class="sr-only">Remove Item</em>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th scope="row" colspan="3"
                                                    class="hidden pl-4 pr-3 pt-4 text-right text-sm font-semibold text-gray-900 dark:text-slate-100 sm:table-cell sm:pl-0">
                                                    Total</th>
                                                <th scope="row"
                                                    class="pl-6 pr-3 pt-4 text-left text-sm font-semibold text-gray-900 dark:text-slate-100 sm:hidden">
                                                    Total</th>
                                                <td
                                                    class="pl-3 pr-4 pt-4 text-right text-sm font-semibold text-gray-900 dark:text-slate-100 sm:pr-0">
                                                    $ {{$total}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
