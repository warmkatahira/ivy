<script src="{{ asset('js/item_maintenance.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <span class="font-semibold text-lg text-gray-800">
            <i class="las la-tools la-lg align-middle"></i>
            商品個別メンテナンス変更画面
        </span>
    </x-slot>
    <div class="mx-5 mb-5">
        <form method="post" action="{{ route('item_maintenance.individual_modify') }}" class="m-0">
            @csrf
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="item_code" class="col-span-5 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>商品コード<span class="text-red-500">*</span></label>
                <input type="text" id="item_code" name="item_code" value="{{ $item->item_code }}" class="col-span-7 xl:col-span-10 border-none outline-none bg-transparent" readonly>
            </div>
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="integrate_jan_code" class="col-span-5 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>代表JAN</label>
                <input type="text" id="integrate_jan_code" name="integrate_jan_code" value="{{ old('integrate_jan_code', $item->integrate_jan_code) }}" class="col-span-7 xl:col-span-2" autocomplete="off">
            </div>
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="individual_jan_code" class="col-span-5 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>個別JAN<span class="text-red-500">*</span></label>
                <input type="text" id="individual_jan_code" name="individual_jan_code" value="{{ old('individual_jan_code', $item->individual_jan_code) }}" class="col-span-7 xl:col-span-2" autocomplete="off">
            </div>
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="brand_name" class="col-span-5 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>ブランド名</label>
                <input type="text" id="brand_name" name="brand_name" value="{{ old('brand_name', $item->brand_name) }}" class="col-span-7 xl:col-span-10" autocomplete="off">
            </div>
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="item_name_1" class="col-span-5 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>商品名1<span class="text-red-500">*</span></label>
                <input type="text" id="item_name_1" name="item_name_1" value="{{ old('item_name_1', $item->item_name_1) }}" class="col-span-7 xl:col-span-10" autocomplete="off">
            </div>
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="item_name_2" class="col-span-5 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>商品名2</label>
                <input type="text" id="item_name_2" name="item_name_2" value="{{ old('item_name_2', $item->item_name_2) }}" class="col-span-7 xl:col-span-10" autocomplete="off">
            </div>
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="jan_start_position" class="col-span-9 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>JAN開始位置</label>
                <input type="text" id="jan_start_position" name="jan_start_position" class="col-span-3 xl:col-span-1" value="{{ old('jan_start_position', $item->jan_start_position) }}" autocomplete="off">
            </div>
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="exp_start_position" class="col-span-9 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>EXP開始位置</label>
                <input type="text" id="exp_start_position" name="exp_start_position" class="col-span-3 xl:col-span-1" value="{{ old('exp_start_position', $item->exp_start_position) }}" autocomplete="off">
            </div>
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="lot_start_position" class="col-span-9 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>LOT開始位置</label>
                <input type="text" id="lot_start_position" name="lot_start_position" class="col-span-3 xl:col-span-1" value="{{ old('lot_start_position', $item->lot_start_position) }}" autocomplete="off">
            </div>
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="lot_length" class="col-span-9 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>LOT桁数</label>
                <input type="text" id="lot_length" name="lot_length" class="col-span-3 xl:col-span-1" value="{{ old('lot_length', $item->lot_length) }}" autocomplete="off">
            </div>
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="s_power_code" class="col-span-9 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>S-POWERコード</label>
                <input type="text" id="s_power_code" name="s_power_code" class="col-span-3 xl:col-span-1" value="{{ old('s_power_code', $item->s_power_code) }}" autocomplete="off">
            </div>
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="s_power_code_start_position" class="col-span-9 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>S-POWERコード開始位置</label>
                <input type="text" id="s_power_code_start_position" name="s_power_code_start_position" class="col-span-3 xl:col-span-1" value="{{ old('s_power_code_start_position', $item->s_power_code_start_position) }}" autocomplete="off">
            </div>
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="location" class="col-span-6 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>ロケーション</label>
                <input type="text" id="location" name="location" class="col-span-6 xl:col-span-2" value="{{ old('location', $item->location) }}" autocomplete="off">
            </div>
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="qr_inspection_enabled" class="col-span-6 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>QR検品<span class="text-red-500">*</span></label>
                <select name="qr_inspection_enabled" class="col-span-6 xl:col-span-1">
                    <option value="0" {{ old('qr_inspection_enabled', $item->qr_inspection_enabled) == 0 ? 'selected' : '' }}>無効</option>
                    <option value="1" {{ old('qr_inspection_enabled', $item->qr_inspection_enabled) == 1 ? 'selected' : '' }}>有効</option>
                </select>
            </div>
            <div class="grid grid-cols-12 gap-4 mb-5 border-b-2 border-gray-400 p-5">
                <label for="logical_stock" class="col-span-6 xl:col-span-2 p-2"><i class="las la-pen la-lg"></i>在庫数</label>
                <input type="text" id="logical_stock" name="logical_stock" class="col-span-6 xl:col-span-1" value="{{ old('logical_stock', $item->logical_stock) }}" autocomplete="off">
            </div>
            <div class="grid grid-cols-12 gap-4">
                <input type="submit" name="update" class="col-span-6 xl:col-span-1 cursor-pointer rounded-lg bg-sky-200 text-center p-8 transition duration-300 ease-in-out hover:bg-lime-200" value="更新">
                <input type="submit" name="delete" class="col-span-6 xl:col-span-1 cursor-pointer rounded-lg bg-pink-200 text-center p-8 transition duration-300 ease-in-out hover:bg-lime-200" value="削除">
            </div>
        </form>
    </div>
</x-app-layout>