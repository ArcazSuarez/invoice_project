<div class="py-10">
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
                                    <h1 class="text-base font-semibold leading-6 dark:text-white">Invoices</h1>
                                    <p class="mt-2 text-sm dark:text-gray-300">A list of all the invoices created using your
                                        account.</p>
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
                                                        Name</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold dark:text-white">
                                                        Title</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold dark:text-white">
                                                        Email</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold dark:text-white">
                                                        Role</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                        <span class="sr-only">Edit</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-800">
                                                <tr>
                                                    <td
                                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium dark:text-white sm:pl-0">
                                                        Lindsay Walton</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm dark:text-gray-300">
                                                        Front-end Developer</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm dark:text-gray-300">
                                                        lindsay.walton@example.com</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm dark:text-gray-300">Member
                                                    </td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                        <a href="#" class="text-indigo-400 hover:text-indigo-300">
                                                            Edit
                                                            <span class="sr-only">, Lindsay Walton
                                                            </span>
                                                        </a>
                                                        <a href="#" class="text-indigo-400 hover:text-indigo-300">
                                                            View
                                                            <span class="sr-only">, Lindsay Walton
                                                            </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
