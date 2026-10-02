<form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="relative flex items-center w-full md:w-auto">
    <input type="text" name="s" placeholder="Caută..." class="rounded pl-4 pr-8 py-1 md:w-[200px] w-full text-black" value="<?php echo get_search_query(); ?>">
    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-600 hover:text-gray-800 focus:outline-none" aria-label="Search">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
    </button>
</form>