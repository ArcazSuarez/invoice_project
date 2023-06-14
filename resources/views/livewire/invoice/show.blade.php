<div class="py-10">
    <div x-cloak x-data="{ open: false, itemKey: null }" @remove-item.window="open = true; itemKey = $event.detail;">
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
            <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white">#{{$invoice_code}}</h1>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl mt-5">
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
                                    <div>
                                        <a href="{{route('dashboard')}}" type="button"
                                            class="block rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                            Return
                                        </a>
                                    </div>
                                    <div class="mx-2">
                                        <a href="{{route('invoice.update',['id' => $invoice_code])}}" type="button"
                                            class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                            Edit
                                        </a>
                                    </div>
                                </div>
                                <div class="flex justify-between mt-5 dark:text-slate-200">
                                    <div class="order-last">
                                        <h1>Created At: <strong>{{$invoice_date}}</strong> </h1>
                                        <div class="mt-2">
                                            <h4 class="text-right">{{$name}}</h4>
                                       </div>
                                    </div>

                                    <div>
                                        <h4 class="dark:text-white">
                                            #{{$invoice_code}}
                                        </h4>
                                    </div>
                                    <div>
                                        @if ($invoice_updated_date != $invoice_date)
                                            Last Updated: <strong>{{$invoice_updated_date}}</strong>
                                        @endif
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoice_items as $key => $item)
                                            <tr wire:key='{{$key+1}}'
                                                class="border-b border-gray-200 dark:border-white/10">
                                                <td class="max-w-0 py-5 pl-4 pr-3 text-sm sm:pl-0">
                                                    <div class="font-medium text-gray-900 dark:text-white">
                                                        {{$item['name']}}
                                                    </div>
                                                </td>
                                                <td
                                                    class="hidden px-3 py-5 text-right text-sm text-gray-500 dark:text-slate-400 sm:table-cell">
                                                    {{$item['quantity']}}</td>
                                                <td
                                                    class="hidden px-3 py-5 text-right text-sm text-gray-500 dark:text-slate-400 sm:table-cell">
                                                    {{$item['price']}}</td>
                                                <td
                                                    class="py-5 pl-3 pr-4 text-right text-sm text-gray-500 dark:text-slate-400 sm:pr-0">
                                                    $ {{number_format($item['subtotal'],2)}}</td>
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
                                                    $ {{number_format($total,2)}}</td>
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
