<x-app-layout>
    <x-slot name="header">
        <span class="font-semibold text-lg text-gray-800">
            <i class="las la-home la-lg"></i>
            ホーム
        </span>
    </x-slot>
    <div class="mx-5">
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- 棚卸 -->
            <div class="max-w-xs mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
                <div class="px-4 py-2">
                    <h1 class="text-xl xl:text-3xl font-bold text-gray-800 uppercase"><i class="las la-tasks la-lg"></i>棚卸</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">商品を読み取り、棚卸を行います。<br><br></p>
                </div>
                <img class="object-cover w-full h-30 xl:h-48 mt-2" src="{{ asset('image/棚卸.svg') }}">
                <div class="flex items-center justify-between px-4 py-2 bg-gray-900">
                    <a href="{{ route('inventory.top') }}" class="w-full text-center px-2 py-1 text-white uppercase transition-colors duration-200 transform bg-gray-900 rounded focus:outline-none">移動する<i class="las la-hand-pointer la-lg"></i></a>
                </div>
            </div>
            <!-- データ -->
            <div class="max-w-xs mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
                <div class="px-4 py-2">
                    <h1 class="text-xl xl:text-3xl font-bold text-gray-800"><i class="las la-database la-lg"></i>データ</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">商品情報や棚卸履歴の確認を行います。<br><br></p>
                </div>
                <img class="object-cover w-full h-30 xl:h-48 mt-2" src="{{ asset('image/データ.svg') }}">
                <div class="flex items-center justify-between px-4 py-2 bg-gray-900">
                    <a href="{{ route('data.top') }}" class="w-full text-center px-2 py-1 text-white uppercase transition-colors duration-200 transform bg-gray-900 rounded focus:outline-none">移動する<i class="las la-hand-pointer la-lg"></i></a>
                </div>
            </div>
            <!-- メンテナンス -->
            <div class="max-w-xs mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
                <div class="px-4 py-2">
                    <h1 class="text-xl xl:text-3xl font-bold text-gray-800 uppercase"><i class="las la-tools la-lg"></i>メンテナンス</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">商品情報の追加や変更を行います。<br><br></p>
                </div>
                <img class="object-cover w-full h-30 xl:h-48 mt-2" src="{{ asset('image/メンテナンス.svg') }}">
                <div class="flex items-center justify-between px-4 py-2 bg-gray-900">
                    <a href="{{ route('maintenance.top') }}" class="w-full text-center px-2 py-1 text-white uppercase transition-colors duration-200 transform bg-gray-900 rounded focus:outline-none">移動する<i class="las la-hand-pointer la-lg"></i></a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
