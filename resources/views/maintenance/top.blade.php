<x-app-layout>
    <x-slot name="header">
        <span class="font-semibold text-lg text-gray-800">
            <i class="las la-tools la-lg align-middle"></i>
            メンテナンス
        </span>
    </x-slot>
    <div class="py-2">
        <div class="mx-5">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                <a href="{{ route('item_maintenance.top') }}" class="rounded-lg bg-teal-200 text-center p-8 transition duration-300 ease-in-out hover:bg-lime-200">
                    商品メンテナンス
                </a>
            </div>
        </div>
    </div>
</x-app-layout>