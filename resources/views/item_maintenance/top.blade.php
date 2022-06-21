<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12">
            <span class="font-semibold text-lg text-gray-800 col-span-8 py-3">
                商品メンテナンス
            </span>
        </div>
    </x-slot>
    <div class="py-2">
        <div class="mx-5">
            <div class="grid grid-cols-12">
                <!-- 個別メンテナンス -->
                <a href="{{ route('item_maintenance.individual_top') }}" class="col-span-12 xl:col-span-3 text-center px-2 py-1 uppercase transition-colors duration-200 transform focus:outline-none">
                    <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
                        <div class="px-4 py-2 bg-teal-500 text-white text-base xl:text-xl">
                            個別メンテナンス
                        </div>
                        <div class="px-4 py-2">
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">商品を個別に更新します。<br><br></p>
                        </div>
                        <img class="object-cover mx-auto" src="{{ asset('image/個別メンテナンス.svg') }}">
                    </div>
                </a>
                <!-- 商品一括取込 -->
                <a href="{{ route('item_maintenance.data_import_top') }}" class="col-span-12 xl:col-span-3 text-center px-2 py-1 uppercase transition-colors duration-200 transform focus:outline-none">
                    <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
                        <div class="px-4 py-2 bg-teal-500 text-white text-base xl:text-xl">
                            商品一括取込
                        </div>
                        <div class="px-4 py-2">
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">CSVを取り込み、商品を更新します。<br><br></p>
                        </div>
                        <img class="object-cover mx-auto" src="{{ asset('image/商品一括取込.svg') }}">
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>