<script src="{{ asset('js/item_maintenance.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <span class="font-semibold text-lg text-gray-800">
            <i class="las la-tools la-lg align-middle"></i>
            商品メンテナンス
        </span>
    </x-slot>
    <div class="py-2">
        <div class="mx-5">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                <a href="{{ route('item_maintenance.individual_top') }}" class="rounded-lg bg-teal-200 text-center p-8 transition duration-300 ease-in-out hover:bg-lime-200">
                    個別メンテナンス
                </a>
                <form method="post" action="{{ route('item_maintenance.data_import') }}" id="item_data_import_form" enctype="multipart/form-data" class="m-0">
                    @csrf
                    <label for="item_data_import" class="cursor-pointer block rounded-lg bg-teal-200 text-center p-8 transition duration-300 ease-in-out hover:bg-lime-200">
                        商品一括取込
                        <input type="file" id="item_data_import" name="item_data_import" accept=".csv" class="hidden">
                    </label>
                    <input type="submit" class="hidden">
                </form>
            </div>
            <!-- 新規マスタ一括取込のバリデーションエラーがあればボタンを表示 -->
            @if(session('validator_errors'))
                <a href="{{ route('item_maintenance.validator_error_export') }}" class="mt-5 block rounded-lg bg-red-600 text-white text-center p-8 transition duration-300 ease-in-out hover:bg-lime-200 hover:text-black">
                    <i class="las la-file-download la-2x"></i>新規マスタ一括取込エラー出力
                    <p>エラー日時：{{ session('error_date') }}</p>
                </a>
            @endif
        </div>
    </div>
</x-app-layout>