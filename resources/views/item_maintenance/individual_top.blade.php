<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12">
            <span class="font-semibold text-lg text-gray-800 col-span-12 py-3">
                商品個別メンテナンス
            </span>
        </div>
    </x-slot>
    <!-- 検索ボックス -->
    <div class="mx-5">
        <form method="get" action="{{ route('item_maintenance.search') }}" class="m-0">
            <details class="bg-sky-100" {{ $search_mode == 'On' ? 'open' : Null }}>
                <summary class="font-bold block bg-sky-200 p-3 text-center cursor-pointer">検索オプション<i class="las la-filter la-lg"></i></summary>
                <div class="mx-5 py-5 grid grid-cols-12 xl:gap-4">
                    <p class="p-2 col-span-12 xl:col-span-1 text-sm">商品コード</p>
                    <input type="text" id="search_item_code" class="col-span-12 xl:col-span-2 text-sm" name="search_item_code" value="{{ empty($search_item_code) ? Null : $search_item_code }}" autocomplete="off" placeholder="商品コード">
                    <p class="p-2 col-span-12 xl:col-span-1 xl:col-start-5 text-sm">個別JAN</p>
                    <input type="text" id="search_individual_jan_code" class="col-span-12 xl:col-span-2 text-sm" name="search_individual_jan_code" value="{{ empty($search_individual_jan_code) ? Null : $search_individual_jan_code }}" autocomplete="off" placeholder="個別JAN">
                    <p class="p-2 col-span-12 xl:col-span-1 xl:col-start-10 text-sm">ブランド名</p>
                    <input type="text" id="search_brand_name" class="col-span-12 xl:col-span-2 text-sm" name="search_brand_name" value="{{ empty($search_brand_name) ? Null : $search_brand_name }}" autocomplete="off" placeholder="ブランド名">
                    <p class="p-2 col-span-12 xl:col-span-1 text-sm">商品名1</p>
                    <input type="text" id="search_item_name_1" class="col-span-12 xl:col-span-2 text-sm" name="search_item_name_1" value="{{ empty($search_item_name_1) ? Null : $search_item_name_1 }}" autocomplete="off" placeholder="商品名1">
                    <p class="p-2 col-span-12 xl:col-span-1 xl:col-start-5 text-sm">商品名2</p>
                    <input type="text" id="search_item_name_2" class="col-span-12 xl:col-span-2 text-sm" name="search_item_name_2" value="{{ empty($search_item_name_2) ? Null : $search_item_name_2 }}" autocomplete="off" placeholder="商品名2">
                    <button type="submit" class="xl:col-start-11 col-span-12 xl:col-span-1 rounded-lg font-bold  bg-gradient-to-r from-purple-200 to-red-200  hover:bg-gradient-to-r hover:from-lime-200 hover:to-green-200 hover:bg-lime-200 mt-5 xl:mt-0 py-2 text-center transition duration-300 ease-in-out">
                        <i class="las la-search la-lg"></i>
                    </button>
                    <a href="{{ route('item_maintenance.individual_top') }}" class="xl:col-start-12 col-span-12 xl:col-span-1 inline-block rounded-lg font-bold  bg-gradient-to-r from-purple-200 to-red-200  hover:bg-gradient-to-r hover:from-lime-200 hover:to-green-200 hover:bg-lime-200 mt-5 xl:mt-0 py-2 text-center transition duration-300 ease-in-out">
                        <i class="las la-trash la-lg"></i>
                    </a>
                </div>
            </details>
        </form>
        <!-- ページネーション -->
        <div class="my-5">
            {{ $items->appends(request()->input())->links() }}
        </div>
        <div class="overflow-x-auto">
            <!-- 商品一覧 -->
            <table class="text-xs mb-5 min-w-full">
                <thead>
                    <tr class="text-xs text-left bg-teal-200 border-gray-600 sticky top-0 whitespace-nowrap">
                        <th class="p-2 px-2"><a href="{{ route('item_maintenance.sort', ['sort_column' => 'item_code', 'direction' => ($sort_column != 'item_code' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">商品コード</a>{{ strpos(url()->full(), 'sort=item_code') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2"><a href="{{ route('item_maintenance.sort', ['sort_column' => 'integrate_jan_code', 'direction' => ($sort_column != 'integrate_jan_code' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">代表JAN</a>{{ strpos(url()->full(), 'sort=integrate_jan_code') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2"><a href="{{ route('item_maintenance.sort', ['sort_column' => 'individual_jan_code', 'direction' => ($sort_column != 'individual_jan_code' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">個別JAN</a>{{ strpos(url()->full(), 'sort=individual_jan_code') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2"><a href="{{ route('item_maintenance.sort', ['sort_column' => 'brand_name', 'direction' => ($sort_column != 'brand_name' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">ブランド名</a>{{ strpos(url()->full(), 'sort=brand_name') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2"><a href="{{ route('item_maintenance.sort', ['sort_column' => 'item_name_1', 'direction' => ($sort_column != 'item_name_1' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">商品名1</a>{{ strpos(url()->full(), 'sort=item_name_1') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2"><a href="{{ route('item_maintenance.sort', ['sort_column' => 'item_name_2', 'direction' => ($sort_column != 'item_name_2' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">商品名2</a>{{ strpos(url()->full(), 'sort=item_name_2') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2 text-right"><a href="{{ route('item_maintenance.sort', ['sort_column' => 'logical_stock', 'direction' => ($sort_column != 'logical_stock' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">在庫数</a>{{ strpos(url()->full(), 'sort=logical_stock') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($items as $item)
                            <tr class="whitespace-nowrap hover:bg-amber-200" id="tr_{{ $item->item_code }}">
                                <td class="p-1 px-2 border"><a href="{{ route('item_maintenance.individual_modify_index', $item->item_code) }}" class="cursor-pointer underline text-blue-700">{{ $item->item_code }}</a></td>
                                <td class="p-1 px-2 border">{{ $item->integrate_jan_code }}</td>
                                <td class="p-1 px-2 border">{{ $item->individual_jan_code }}</td>
                                <td class="p-1 px-2 border">{{ $item->brand_name }}</td>
                                <td class="p-1 px-2 border">{{ $item->item_name_1 }}</td>
                                <td class="p-1 px-2 border">{{ $item->item_name_2 }}</td>
                                <td class="p-1 px-2 border text-right">{{ $item->logical_stock }}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>