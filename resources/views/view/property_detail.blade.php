<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gallant Kost</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="text-gray-800 bg-gray-100">

    <x-app-layout>
        <x-slot name="header">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Gallant Kost') }}
            </h2>
        </x-slot>

        <div class="flex gap-20 justify-center items-center p-4 mx-auto mt-8 w-full max-w-lg bg-white rounded-lg border border-gray-300">
            <a href="#" class="inline-block text-gray-800 transition duration-200 transform hover:text-blue-500 hover:scale-110" onclick="setActive(this, 'homeContent')">
                <x-svg.homeprop p="48" l="48"></x-svg.homeprop>
            </a>
            <a href="#" class="inline-block text-gray-800 transition duration-200 transform hover:text-blue-500 hover:scale-110" onclick="setActive(this, 'penghuniContent')">
                <x-svg.penghuni p="48" l="48"></x-svg.penghuni>
            </a>
            <a href="#" class="inline-block text-gray-800 transition duration-200 transform hover:text-blue-500 hover:scale-110" onclick="setActive(this, 'tagihanContent')">
                <x-svg.tagihan p="48" l="48"></x-svg.tagihan>
            </a>
        </div>        

        <div id="content" class="mt-8 text-center">
        </div>

    </x-app-layout>

    <script>
        function setActive(element, contentId) {
            document.querySelectorAll('a').forEach((el) => {
                el.classList.remove('border-b-2', 'border-black');
            });
            element.classList.add('border-b-2', 'border-black');
            displayContent(contentId);
        }

        function displayContent(contentId) {
            const contentDiv = document.getElementById('content');
            let content = '';

            if (contentId === 'homeContent') {
                content = `
                    <div class="flex gap-4 justify-center">
                        <div class="flex flex-col items-center p-4 w-60 bg-white rounded border-gray-300 shadow-md">
                            <h1 class="mb-2 text-xl font-bold">Jumlah Kamar</h1>
                            <x-icon.bedroom class="mb-2 w-8 h-8"></x-icon.bedroom>
                            <h2 class="text-lg">20 Kamar</h2>
                        </div>
                        <div class="flex flex-col items-center p-4 w-60 bg-white rounded border border-gray-300 shadow-md">
                            <h1 class="mb-2 text-xl font-bold">Fasilitas</h1>
                            <x-icon.facility class="mb-2 w-8 h-8"></x-icon.facility>
                            <h2 class="text-lg text-center">Wi-Fi, AC, Kamar Mandi Dalam</h2>
                        </div>
                    </div>
                `;
            } else if (contentId === 'penghuniContent') {
                content = `
                    <h3 class="mb-4 text-xl font-bold text-gray-800">Daftar Penghuni</h3>
                    <div class="flex gap-8 justify-center">
                        <div class="flex flex-col items-center">
                            <img src="https://via.placeholder.com/80" alt="Alip Lizal" class="mb-2 w-20 h-20 rounded-full">
                            <p class="text-gray-800">Alip Lizal</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <img src="https://via.placeholder.com/80" alt="Rafi Hidayat" class="mb-2 w-20 h-20 rounded-full">
                            <p class="text-gray-800">Rafi Hidayat</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <img src="https://via.placeholder.com/80" alt="Evan Pratama" class="mb-2 w-20 h-20 rounded-full">
                            <p class="text-gray-800">Evan Pratama</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <img src="https://via.placeholder.com/80" alt="Hasnan Alif" class="mb-2 w-20 h-20 rounded-full">
                            <p class="text-gray-800">Hasnan Alif</p>
                        </div>
                    </div>
                `;
            } else if (contentId === 'tagihanContent') {
                content = `
                    <div class="flex gap-4 justify-center">
                        <div class="flex flex-col items-center p-4 w-60 bg-white rounded border border-gray-300 shadow-md">
                            <h1 class="mb-2 text-xl font-bold">Paid Amount</h1>
                            <h2 class="p-4 text-3xl font-bold text-center text-green-500">Rp5.5M</h2>
                        </div>

                        <div class="flex flex-col items-center p-4 w-60 bg-white rounded border border-gray-300 shadow-md">
                            <h1 class="mb-2 text-xl font-bold">Unpaid Amount</h1>
                            <h2 class="p-4 text-3xl font-bold text-center text-red-500">Rp5.3M</h2>

                        </div>
                    </div>
                `;
            }

            contentDiv.innerHTML = content;
        }
    </script>
</body>
</html>
