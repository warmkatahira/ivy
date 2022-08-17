<script src="{{ asset('js/modal.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12">
            <span class="font-semibold text-lg text-gray-800 col-span-5 py-3">
                棚卸履歴一覧
            </span>
            <a id="openModal" class="col-span-7 xl:col-span-2 col-start-6 xl:col-start-11 cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-lime-200 ml-10">
                <i class="las la-file-download la-lg"></i>CSV出力
            </a>
        </div>
    </x-slot>
    <!-- 検索ボックス -->
    <div class="mx-5">
        <form method="get" action="{{ route('inventory_history_list.search') }}" class="m-0">
            <details class="bg-sky-100" {{ $search_mode == 'On' ? 'open' : Null }}>
                <summary class="font-bold block bg-sky-200 p-3 text-center cursor-pointer">検索オプション<i class="las la-filter la-lg"></i></summary>
                <div class="mx-5 py-5 grid grid-cols-12 xl:gap-4">
                    <p class="p-2 col-span-12 xl:col-span-1 text-sm">商品コード</p>
                    <input type="text" id="search_item_code" class="col-span-12 xl:col-span-1 text-sm" name="search_item_code" value="{{ empty($search_item_code) ? Null : $search_item_code }}" autocomplete="off" placeholder="商品コード">
                    <p class="p-2 col-span-12 xl:col-span-1 xl:col-start-4 text-sm">個別JAN</p>
                    <input type="text" id="search_individual_jan_code" class="col-span-12 xl:col-span-1 text-sm" name="search_individual_jan_code" value="{{ empty($search_individual_jan_code) ? Null : $search_individual_jan_code }}" autocomplete="off" placeholder="個別JAN">
                    <p class="p-2 col-span-12 xl:col-span-1 xl:col-start-7 text-sm">商品名1</p>
                    <input type="text" id="search_item_name_1" class="col-span-12 xl:col-span-2 text-sm" name="search_item_name_1" value="{{ empty($search_item_name_1) ? Null : $search_item_name_1 }}" autocomplete="off" placeholder="商品名1">
                    <p class="p-2 col-span-12 xl:col-span-1 xl:col-start-10 text-sm">商品名2</p>
                    <input type="text" id="search_item_name_2" class="col-span-12 xl:col-span-2 text-sm" name="search_item_name_2" value="{{ empty($search_item_name_2) ? Null : $search_item_name_2 }}" autocomplete="off" placeholder="商品名2">
                    <p class="p-2 col-span-12 xl:col-span-1 text-sm">棚卸日</p>
                    <input type="date" id="search_inventory_date_start" class="col-span-12 xl:col-span-2 text-sm" name="search_inventory_date_start" value="{{ empty($search_inventory_date_start) ? Null : $search_inventory_date_start }}" autocomplete="off">
                    <p class="p-2 col-span-12 xl:col-span-1 text-sm text-center">～</p>
                    <input type="date" id="search_inventory_date_end" class="col-span-12 xl:col-span-2 text-sm" name="search_inventory_date_end" value="{{ empty($search_inventory_date_end) ? Null : $search_inventory_date_end }}" autocomplete="off">    
                    <p class="p-2 col-span-12 xl:col-span-1 xl:col-start-7 text-sm">棚卸結果</p>
                    <input type="text" id="search_inventory_result" class="col-span-12 xl:col-span-1 text-sm" name="search_inventory_result" value="{{ empty($search_inventory_result) ? Null : $search_inventory_result }}" autocomplete="off" placeholder="棚卸結果">
                    <p class="p-2 col-span-12 xl:col-span-1 text-sm">表示単位</p>
                    <select id="search_disp" name="search_disp" class="col-span-12 xl:col-span-1 text-sm">
                        <option value="処理" {{ session('search_disp') == '処理' ? 'selected' : '' }}>処理</option>
                        <option value="日付" {{ session('search_disp') == '日付' ? 'selected' : '' }}>日付</option>
                    </select>
                    <button type="submit" class="xl:col-start-11 col-span-12 xl:col-span-1 rounded-lg font-bold  bg-gradient-to-r from-purple-200 to-red-200  hover:bg-gradient-to-r hover:from-lime-200 hover:to-green-200 hover:bg-lime-200 mt-5 xl:mt-0 py-2 text-center transition duration-300 ease-in-out">
                        <i class="las la-search la-lg"></i>
                    </button>
                    <a href="{{ route('inventory_history_list.index') }}" class="xl:col-start-12 col-span-12 xl:col-span-1 inline-block rounded-lg font-bold  bg-gradient-to-r from-purple-200 to-red-200  hover:bg-gradient-to-r hover:from-lime-200 hover:to-green-200 hover:bg-lime-200 mt-5 xl:mt-0 py-2 text-center transition duration-300 ease-in-out">
                        <i class="las la-trash la-lg"></i>
                    </a>
                </div>
            </details>
        </form>
         <!-- ページネーション -->
        <div class="my-5">
            {{ $inventory_histories->appends(request()->input())->links() }}
        </div>
        <div class="overflow-x-auto">
            <!-- 棚卸履歴一覧 -->
            <table class="text-xs mb-5 min-w-full">
                <thead>
                    <tr class="text-left bg-teal-200 border-gray-600 sticky top-0 whitespace-nowrap">
                        <th class="p-2 px-2"><a href="{{ route('inventory_history_list.sort', ['sort_column' => 'inventory_date', 'direction' => ($sort_column != 'inventory_date' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">棚卸日</a>{{ strpos(url()->full(), 'sort/inventory_date') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        @if(session('search_disp') == '処理')
                            <th class="p-2 px-2"><a href="{{ route('inventory_history_list.sort', ['sort_column' => 'inventory_time', 'direction' => ($sort_column != 'inventory_time' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">棚卸時間</a>{{ strpos(url()->full(), 'sort/inventory_time') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        @endif
                        <th class="p-2 px-2"><a href="{{ route('inventory_history_list.sort', ['sort_column' => 'operator_name', 'direction' => ($sort_column != 'operator_name' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">実施者</a>{{ strpos(url()->full(), 'sort/operator_name') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2"><a href="{{ route('inventory_history_list.sort', ['sort_column' => 'item_code', 'direction' => ($sort_column != 'item_code' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">商品コード</a>{{ strpos(url()->full(), 'sort/item_code') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2"><a href="{{ route('inventory_history_list.sort', ['sort_column' => 'individual_jan_code', 'direction' => ($sort_column != 'individual_jan_code' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">個別JAN</a>{{ strpos(url()->full(), 'sort/individual_jan_code') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2"><a href="{{ route('inventory_history_list.sort', ['sort_column' => 'brand_name', 'direction' => ($sort_column != 'brand_name' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">ブランド名</a>{{ strpos(url()->full(), 'sort/brand_name') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2"><a href="{{ route('inventory_history_list.sort', ['sort_column' => 'item_name_1', 'direction' => ($sort_column != 'item_name_1' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">商品名1</a>{{ strpos(url()->full(), 'sort/item_name_1') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2"><a href="{{ route('inventory_history_list.sort', ['sort_column' => 'item_name_2', 'direction' => ($sort_column != 'item_name_2' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">商品名2</a>{{ strpos(url()->full(), 'sort/item_name_2') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2 text-right"><a href="{{ route('inventory_history_list.sort', ['sort_column' => 'inventory_quantity', 'direction' => ($sort_column != 'inventory_quantity' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">棚卸数</a>{{ strpos(url()->full(), 'sort/inventory_quantity') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2 text-right"><a href="{{ route('inventory_history_list.sort', ['sort_column' => 'logical_stock', 'direction' => ($sort_column != 'logical_stock' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">在庫数</a>{{ strpos(url()->full(), 'sort/logical_stock') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2 text-center"><a href="{{ route('inventory_history_list.sort', ['sort_column' => 'inventory_result', 'direction' => ($sort_column != 'inventory_result' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">棚卸結果</a>{{ strpos(url()->full(), 'sort/inventory_result') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($inventory_histories as $inventory_history)
                        <tr id="tr_{{ $inventory_history->item_code }}" class="whitespace-nowrap">
                            <td class="p-1 px-2 border">{{ $inventory_history->inventory_date }}</td>
                            @if(session('search_disp') == '処理')
                                <td class="p-1 px-2 border">{{ $inventory_history->inventory_time }}</td>
                            @endif
                            <td class="p-1 px-2 border">{{ $inventory_history->operator_name }}</td>
                            <td class="p-1 px-2 border">{{ $inventory_history->item_code }}</td>
                            <td class="p-1 px-2 border">{{ $inventory_history->individual_jan_code }}</td>
                            <td class="p-1 px-2 border">{{ $inventory_history->brand_name }}</td>
                            <td class="p-1 px-2 border">{{ $inventory_history->item_name_1 }}</td>
                            <td class="p-1 px-2 border">{{ $inventory_history->item_name_2 }}</td>
                            <td class="p-1 px-2 border text-right">{{ $inventory_history->inventory_quantity }}</td>
                            <td class="p-1 px-2 border text-right">{{ $inventory_history->logical_stock }}</td>
                            <td class="p-1 px-2 border text-center"><span class="inline-block px-2 rounded-full {{ $inventory_history->inventory_result == 'OK' ? "bg-sky-200": 'bg-pink-200' }}">{{ $inventory_history->inventory_result }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div id="modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-lg rounded-md bg-white max-w-md">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-green-500 text-white text-xl rounded-t-md px-4 py-2">
                <h3><i class="las la-file-download la-lg"></i>CSV出力</h3>
                <button class="closeModal">x</button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                出力件数：{{ session('inventory_history_list_export')->count() }}件
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <a id="item_data_export" href="{{ route('inventory_history_list.export') }}" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-lime-200">
                    出力
                </a>
                <a class="closeModal cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-lime-200">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>