<script src="{{ asset('js/item_maintenance.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12">
            <span class="font-semibold text-lg text-gray-800 col-span-8 py-3">
                商品一括取込
            </span>
        </div>
    </x-slot>
    <div class="mx-5 mb-5">
        <div class="grid grid-cols-12 gap-4">
            <form method="post" action="{{ route('item_maintenance.data_import') }}" id="item_data_import_form" enctype="multipart/form-data" class="col-span-12 xl:col-span-2 m-0">
                @csrf
                <label for="item_data_import" class="cursor-pointer block rounded-lg bg-teal-200 text-center p-8 transition duration-300 ease-in-out hover:bg-lime-200">
                    取込
                    <input type="file" id="item_data_import" name="item_data_import" accept=".csv" class="hidden">
                </label>
                <input type="submit" class="hidden">
            </form>
            <!-- 新規マスタ一括取込のバリデーションエラーがあればボタンを表示 -->
            @if(session('validator_errors'))
                <a href="{{ route('item_maintenance.validator_error_export') }}" class="col-span-12 xl:col-span-4 rounded-lg bg-red-600 text-white text-center p-4 transition duration-300 ease-in-out hover:bg-lime-200 hover:text-black">
                    商品一括取込エラー出力<br>
                    エラー日時：{{ session('error_date') }}
                </a>
            @endif
        </div>
    </div>
</x-app-layout>