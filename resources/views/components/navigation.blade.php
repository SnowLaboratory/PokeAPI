
<nav class="bg-white border-gray-200 px-2 sm:px-4 py-2.5 rounded">
    <div class="container flex flex-wrap justify-between items-center mx-auto">
        <a href="/" class="flex">
            <span class="self-center text-lg font-semibold whitespace-nowrap text-black">Pokevo</span>
        </a>
        <div class="flex md:order-2">
            <div class="hidden relative mr-3 md:mr-0 md:block">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <i class="fal fa-search absolute pr-2 text-neutral-500"></i>
                </div>
                <input type="text" class="block p-2 pl-8 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:text-sm shadow-orange-500/50 border border-orange-500 focus:ring-orange-500 focus:border-orange-600 placeholder:text-neutral-500" placeholder="Search for Pokemon...">
            </div>
            <button data-collapse-toggle="mobile" type="button" class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white hover:bg-white dark:focus:ring-gray-600" aria-controls="mobile-menu-3" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
        <div class="hidden justify-between items-center w-full md:flex md:w-auto md:order-1" id="mobile">
            <ul class="flex flex-col mt-4 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium">
                <li>
                    <a href="/gen" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:dark:hover:text-black dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-black md:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">Generations</a>
                </li>
                <li>
                    <a href="/national-dex" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:dark:hover:text-black dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-black md:dark:hover:bg-transparent dark:border-gray-700">National Dex</a>
                </li>
{{--                <li>--}}
{{--                    <a href="#" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-black dark:hover:bg-gray-700 dark:hover:text-black md:dark:hover:bg-transparent dark:border-gray-700">Items</a>--}}
{{--                </li>--}}
                <li>
                    <a href="/about" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-black dark:hover:bg-gray-700 dark:hover:text-black md:dark:hover:bg-transparent dark:border-gray-700">About</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
