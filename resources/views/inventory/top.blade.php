<script src="{{ asset('js/inventory.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <span class="font-semibold text-lg text-gray-800">
            <i class="las la-tasks la-lg align-middle"></i>
            棚卸
        </span>
        <a id="inventory_confirm" href="{{ route('inventory.confirm') }}" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-lime-200 ml-10">
            確定
        </a>
    </x-slot>
    <div class="mx-5">
        <div class="grid grid-cols-12 xl:gap-4">
            <label for="logical_stock" class="pb-2 xl:pb-0 text-base xl:text-xl col-span-12 xl:col-span-1"><i class="las la-warehouse la-lg"></i>在庫数</label>
            <div id="logical_stock" class="bg-pink-200 xl:h-40 text-base xl:text-7xl text-center h-8 py-1 xl:p-10 col-span-12 xl:col-span-2"></div>
            <label for="inventory_quantity" class="py-2 xl:py-0 text-base xl:text-xl col-span-12 xl:col-span-1"><i class="las la-boxes la-lg"></i>棚卸数</label>
            <div id="inventory_quantity" class="bg-orange-200 xl:h-40 text-base xl:text-7xl text-center h-8 py-1 xl:p-10 col-span-12 xl:col-span-2"></div>
            <label for="message" class="py-2 xl:py-0 text-base xl:text-xl col-span-12 xl:col-span-1"><i class="las la-comment la-lg"></i>メッセージ</label>
            <div id="message" class="bg-sky-200 h-20 xl:h-40 text-base xl:text-2xl text-align-top col-span-12 xl:col-span-5 break-words"></div>
        </div>
        <div class="mt-3">
            <div class="grid grid-cols-12 xl:gap-4 mb-5">
                <label for="individual_jan_code" class="py-1 text-base xl:text-xl col-span-12 xl:col-span-1"><i class="las la-info-circle la-lg"></i>JANコード</label>
                <div id="individual_jan_code" class="text-base xl:text-xl bg-indigo-200 h-8 py-1 xl:h-10 xl:py-2 col-span-12 xl:col-span-2"></div>
                <label for="brand_name" class="py-1 text-base xl:text-xl col-span-12 xl:col-span-1"><i class="las la-info-circle la-lg"></i>ブランド名</label>
                <div id="brand_name" class="text-xs xl:text-xl bg-indigo-200 h-8 py-2 xl:h-10 xl:py-2 col-span-12 xl:col-span-8"></div>
                <label for="item_name_1" class="py-1 text-base xl:text-xl col-span-12 xl:col-span-1"><i class="las la-info-circle la-lg"></i>商品名1</label>
                <div id="item_name_1" class="text-xs xl:text-xl bg-indigo-200 h-8 py-2 xl:h-10 xl:py-2 col-span-12 xl:col-span-11 whitespace-nowrap overflow-x-scroll"></div>
                <label for="item_name_2" class="py-1 text-base xl:text-xl col-span-12 xl:col-span-1"><i class="las la-info-circle la-lg"></i>商品名2</label>
                <div id="item_name_2" class="text-xs xl:text-xl bg-indigo-200 h-8 py-2 xl:h-10 xl:py-2 col-span-12 xl:col-span-11 whitespace-nowrap overflow-x-scroll"></div>
            </div>
        </div>
        <label for="scan_info" class="text-base xl:text-xl"><i class="las la-qrcode la-lg"></i>商品スキャン</label>
        <input type="text" id="scan_info" class="text-base xl:text-2xl w-full mt-3 xl:mt-3">
        <!-- 商品の詳細情報を非表示で持っておく -->
        <input type="hidden" id="jan_start_position">
        <input type="hidden" id="s_power_code">
        <input type="hidden" id="s_power_code_start_position">
        <input type="hidden" id="item_code">
        </form>
    </div>
</x-app-layout>