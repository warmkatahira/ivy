<x-app-layout>
    <x-slot name="header">
        <span class="font-semibold text-lg text-gray-800">
            <i class="las la-home la-lg"></i>
            ホーム
        </span>
    </x-slot>
    <div class="py-2">
        <div class="mx-5">
            <div class="grid grid-cols-12">
                <!-- My記録 -->
                <a href="{{ route('myrecord.top') }}" class="col-span-12 xl:col-span-3 text-center px-2 py-1 uppercase transition-colors duration-200 transform focus:outline-none">
                    <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
                        <div class="px-4 py-2 bg-teal-500 text-white text-base xl:text-xl capitalize">
                            My記録
                        </div>
                        <div class="px-4 py-2">
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">自分の当日の棚卸実績を閲覧できます。<br><br></p>
                        </div>
                        <img class="object-cover mx-auto" src="{{ asset('image/My記録.svg') }}">
                    </div>
                </a>
                <!-- 棚卸 -->
                <a href="{{ route('inventory.top') }}" class="col-span-12 xl:col-span-3 text-center px-2 py-1 uppercase transition-colors duration-200 transform focus:outline-none">
                    <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
                        <div class="px-4 py-2 bg-teal-500 text-white text-base xl:text-xl">
                            棚卸
                        </div>
                        <div class="px-4 py-2">
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">商品を読み取り、棚卸を行います。<br><br></p>
                        </div>
                        <img class="object-cover mx-auto" src="{{ asset('image/棚卸.svg') }}">
                    </div>
                </a>
                <!-- データ -->
                <a href="{{ route('data.top') }}" class="col-span-12 xl:col-span-3 text-center px-2 py-1 uppercase transition-colors duration-200 transform focus:outline-none">
                    <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
                        <div class="px-4 py-2 bg-teal-500 text-white text-base xl:text-xl">
                            データ
                        </div>
                        <div class="px-4 py-2">
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">商品や棚卸履歴の確認を行います。<br><br></p>
                        </div>
                        <img class="object-cover mx-auto" src="{{ asset('image/データ.svg') }}">
                    </div>
                </a>
                <!-- メンテナンス -->
                <a href="{{ route('maintenance.top') }}" class="col-span-12 xl:col-span-3 text-center px-2 py-1 uppercase transition-colors duration-200 transform focus:outline-none">
                    <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
                        <div class="px-4 py-2 bg-teal-500 text-white text-base xl:text-xl">
                            メンテナンス
                        </div>
                        <div class="px-4 py-2">
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">商品の追加や変更を行います。<br><br></p>
                        </div>
                        <img class="object-cover mx-auto" src="{{ asset('image/メンテナンス.svg') }}">
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
