@props(['disabled' => false, "title"])

<div class="relative w-auto h-[30px] rounded-md dark:bg-white dark:bg-opacity-10 dark:text-gray-300">
  <div class="flex items-center h-full">
    <div class=" border-[1px] dark:border-[#464649] rounded-l-md border-r-0 h-full flex items-center">
      <x-a-label class="mx-2 text-sm">{{ $title }}</x-a-label>
    </div>
    <div class=" border-[1px] dark:border-[#464649] rounded-r-md h-full">
      <select autocomplete="off" @disabled($disabled) {{ $attributes->merge(['class' => 'text-black dark:text-white pr-[30px] pl-[10px] bg-transparent appearance-none bg-[#FAFAFA] h-full focus:outline-none focus:outline focus:outline-2 ']) }}>{{ $slot }}</select>
      <!-- Custom Arrow positioned on the right with margin-right -->
      <div class="absolute right-[7px] top-1/2 text-gray-400 transform -translate-y-1/2 pointer-events-none">
        <!-- Example of a simple SVG for the down arrow -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
        </svg>
      </div>
    </div>
  </div>
</div>