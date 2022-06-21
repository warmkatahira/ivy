<script src="{{ asset('js/myrecord.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12">
            <span class="font-semibold text-lg text-gray-800 col-span-8 py-3">
                My記録
            </span>
        </div>
    </x-slot>
    <div class="py-2">
        <div class="mx-5">
            <div class="grid grid-cols-12">
                <div class="col-span-12 xl:col-span-2 border-2 border-black  rounded-lg bg-gradient-to-r from-teal-100 to-sky-100">
                    <p class="text-2xl font-bold text-center pt-3">本日の棚卸数</p>
                    <p class="text-4xl text-center p-8">{{ number_format($inventory_quantity_sum) }}</p>
                </div>
                <div class="mt-3 xl:mt-0 col-span-12 xl:col-span-10 xl:col-start-4 border-2 border-black px-8 py-3 rounded-lg bg-gradient-to-r from-teal-100 to-sky-100">
                    <p class="text-2xl font-bold text-center">直近3件の棚卸実績</p>
                    <div class="overflow-x-auto">
                        <table class="text-xs min-w-full mt-3">
                            <thead>
                                <tr class="text-left bg-black text-white border-gray-600 sticky top-0 whitespace-nowrap">
                                    <th class="p-2 px-2 w-1/12">個別JAN</th>
                                    <th class="p-2 px-2 w-8/12">商品名1</th>
                                    <th class="p-2 px-2 w-1/12">商品名2</th>
                                    <th class="p-2 px-2 w-1/12 text-right">棚卸数</th>
                                    <th class="p-2 px-2 w-1/12 text-center">棚卸結果</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white whitespace-nowrap">
                                @foreach($last_inventory_histories as $last_inventory_history)
                                    <tr>
                                        <td class="p-1 px-2 border">{{ $last_inventory_history->individual_jan_code }}</td>
                                        <td class="p-1 px-2 border">{{ $last_inventory_history->item_name_1 }}</td>
                                        <td class="p-1 px-2 border">{{ $last_inventory_history->item_name_2 }}</td>
                                        <td class="p-1 px-2 border text-right">{{ $last_inventory_history->inventory_quantity }}</td>
                                        <td class="p-1 px-2 border text-center"><span class="inline-block px-2 rounded-full {{ $last_inventory_history->inventory_result == 'OK' ? "bg-sky-200": 'bg-pink-200' }}">{{ $last_inventory_history->inventory_result }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-5 col-span-12 xl:col-span-6 xl:col-start-4 border-2 border-black  rounded-lg bg-gradient-to-r from-teal-100 to-sky-100">
                    <p class="text-2xl font-bold text-center pt-3">棚卸結果割合チャート</p>
                    <div class="grid grid-cols-12 pt-3 text-sm xl:text-base" style="font-family:Kdam Thmor Pro;">
                        <p id="inventory_total_count" class="col-span-12 xl:col-span-4 text-center text-sm xl:text-xl"></p>
                        <p id="inventory_result_ok_count" class="col-span-6 xl:col-span-4 text-center text-sm xl:text-xl text-blue-600"></p>
                        <p id="inventory_result_ng_count" class="col-span-6 xl:col-span-4 text-center text-sm xl:text-xl text-red-600"></p>
                    </div>
                    <canvas id="today_inventory_result_ratio" class="min-w-full pb-3"></canvas>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>