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
                    <div class="dark:bg-gray-900 py-10">
                        <div class="px-4 sm:px-6 lg:px-8">
                            <div class="sm:flex sm:items-center">
                                <div class="sm:flex-auto">
                                    <h1 class="text-base font-semibold leading-6 dark:text-white">Search</h1>
                                        <input wire:model='searchTerm' type="text" name="" id="">
                                </div>
                                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                                    <a href="{{route('invoice.create')}}" type="button"
                                        class="block rounded-md bg-indigo-400 dark:bg-indigo-500 px-3 py-2 text-center text-sm font-semibold dark:text-white hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                                        Create Invoice
                                    </a>
                                </div>
                            </div>
                            <div class="mt-8 flow-root">
                                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                        <table class="min-w-full divide-y divide-gray-700">
                                            <thead>
                                                <tr>
                                                    <th scope="col"
                                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold dark:text-white sm:pl-0">
                                                        Invoice #</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold dark:text-white">
                                                        Customer</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold dark:text-white">
                                                        Item Count</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold dark:text-white">
                                                        Total</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-right text-sm font-semibold dark:text-white">
                                                        Date</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                        <span class="sr-only">Edit</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-800">
                                                @foreach ($invoices as $item)
                                                    <tr wire:key='{{$item->code}}'>
                                                        <td
                                                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium dark:text-white sm:pl-0">
                                                            {{$item->code}}
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm dark:text-gray-300">
                                                            {{$item->customer_name}}
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm dark:text-gray-300">
                                                            {{$item->items->count()}}
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm dark:text-gray-300">
                                                            $ {{$item->total}}
                                                        </td>
                                                        <td class="text-right whitespace-nowrap px-3 py-4 text-sm dark:text-gray-300">
                                                            {{$item->created_at->toDayDateTimeString()}}
                                                        </td>
                                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                            <a href="{{route('invoice.update',['id' => $item->code])}}" class="text-indigo-400 hover:text-indigo-300">
                                                                Edit
                                                            </a>
                                                            <a href="#" class="text-blue-400 hover:text-indigo-300">
                                                                View
                                                            </a>
                                                            <a x-data="{}" @click="$dispatch('remove-item', '{{ $item->code }}')" href="#" class="text-red-400 hover:text-indigo-300">
                                                                Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $invoices->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
