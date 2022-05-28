<x-app-layout>
    <x-slot name="header">
        <span class="font-semibold text-lg text-gray-800">
            <i class="las la-database la-lg align-middle"></i>
            データ
        </span>
    </x-slot>
    <div class="py-2">
        <div class="mx-5">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                <a href="{{ route('item_list.index') }}" class="rounded-lg bg-teal-200 text-center p-8 transition duration-300 ease-in-out hover:bg-lime-200">
                    商品一覧
                </a>
                <a href="{{ route('inventory_history_list.index') }}" class="rounded-lg bg-teal-200 text-center p-8 transition duration-300 ease-in-out hover:bg-lime-200">
                    棚卸履歴一覧
                </a>
            </div>
        </div>
    </div>
</x-app-layout>