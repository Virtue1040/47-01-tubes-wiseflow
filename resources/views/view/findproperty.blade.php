<x-app-layout>
    <script>
        
    </script>
    <script>

    </script>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Find Property') }}
        </h2>
    </x-slot>

    <div class="flex flex-row justify-between">
        {{-- kiri --}}
        <div>
            <div class="flex flex-row py-8">
            <x-icon.search p="20" l="20" />Bandung,jawabarat
            </div>
            
            <hr class="border-black">
            <br>
            <div class="flex flex-row gap-8">
                <div class="rounded p-[5px] px-[25px] bg-white w-[140px] border border-black ">
                    <p>show filter </p>
                </div>
                
                <div class="w-[200px] bg-transparant">
                  {{-- container kosong   --}}
                </div>
                
                <div class="rounded p-[5px] px-[25px] bg-white w-[140px] border border-black ">
                    <p>Rp.5jt - 10jt </p>
                </div>

                <div class="rounded p-[5px] px-[25px] bg-white w-[140px] border border-black ">
                    <p> Rent hause </p>
                </div>
            </div>
            
            <br>
            
            <hr class="border-black">
            
            <div class="flex flex-row justify-between py-10" >
                <div>
                    <p>Showing</p>
                    <p class="font-bold">126 Result</p>
                </div>
                
                <div class="rounded p-[5px] px-[25px] bg-white w-[110px] h-8 border border-black ">
                    <p> Sort by </p>
                </div>
                
            </div>

            <div>
                <div>
                    <img src="{{ asset('img/hause-japan.jpg') }}" class="w-[300px]"></img>
                    <div>
                        <p>Rp.1000.000 / night</p>
                    </div>
                </div>
                
                <div>
                    <div></div>
                    <div></div>
                </div>
                
            </div>
            
            
        </div>
        
        {{-- kanan --}}
        <div class="">
            <div class="w-[550px] h-[700px] bg-red-400">
                
            </div>
            
            
        </div>
        
    </div>
    
</x-app-layout>

