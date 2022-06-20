<x-app-layout>
    <x-slot name="header">
        <span class="font-semibold text-lg text-gray-800">
            データ
        </span>
    </x-slot>
    <div class="py-2">
        <div class="mx-5">
            <div class="grid grid-cols-12">
                <!-- 商品一覧 -->
                <a href="{{ route('item_list.index') }}" class="col-span-12 xl:col-span-3 text-center px-2 py-1 uppercase transition-colors duration-200 transform focus:outline-none">
                    <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
                        <div class="px-4 py-2 bg-teal-500 text-white text-base xl:text-xl">
                            商品一覧
                        </div>
                        <div class="px-4 py-2">
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">商品が閲覧できます。<br><br></p>
                        </div>
                        <img class="object-cover mx-auto" src="{{ asset('image/商品一覧.svg') }}">
                    </div>
                </a>
                <!-- 棚卸履歴一覧 -->
                <a href="{{ route('inventory_history_list.index') }}" class="col-span-12 xl:col-span-3 text-center px-2 py-1 uppercase transition-colors duration-200 transform focus:outline-none">
                    <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
                        <div class="px-4 py-2 bg-teal-500 text-white text-base xl:text-xl">
                            棚卸履歴一覧
                        </div>
                        <div class="px-4 py-2">
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">棚卸履歴が閲覧できます。<br><br></p>
                        </div>
                        <img class="object-cover mx-auto" src="{{ asset('image/棚卸履歴一覧.svg') }}">
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>