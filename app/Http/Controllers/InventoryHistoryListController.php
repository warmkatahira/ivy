<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryHistory;
use App\Services\InventoryHistorySearchSortService;
use App\Services\InventoryHistoryListExportService;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;

class InventoryHistoryListController extends Controller
{
    public function inventory_history_list()
    {
        $InventoryHistorySearchSortService = new InventoryHistorySearchSortService();
        $inventory_histories = $InventoryHistorySearchSortService->open_process();
        return view('data.inventory_history_list')->with([
            'inventory_histories' => $inventory_histories,
            'search_mode' => session('search_mode'),
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    public function inventory_history_list_search(Request $request)
    {
        $InventoryHistorySearchSortService = new InventoryHistorySearchSortService();
        $inventory_histories = $InventoryHistorySearchSortService->search_enter($request);
        return view('data.inventory_history_list')->with([
            'inventory_histories' => $inventory_histories,
            'search_item_code' => session('search_item_code'),
            'search_individual_jan_code' => session('search_individual_jan_code'),
            'search_item_name_1' => session('search_item_name_1'),
            'search_item_name_2' => session('search_item_name_2'),
            'search_inventory_date_start' => session('search_inventory_date_start'),
            'search_inventory_date_end' => session('search_inventory_date_end'),
            'search_inventory_result' => session('search_inventory_result'),
            'search_mode' => session('search_mode'),
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    public function inventory_history_list_sort(Request $request)
    {
        $InventoryHistorySearchSortService = new InventoryHistorySearchSortService();
        $inventory_histories = $InventoryHistorySearchSortService->sort_enter($request);
        return view('data.inventory_history_list')->with([
            'inventory_histories' => $inventory_histories,
            'search_item_code' => session('search_item_code'),
            'search_individual_jan_code' => session('search_individual_jan_code'),
            'search_item_name_1' => session('search_item_name_1'),
            'search_item_name_2' => session('search_item_name_2'),
            'search_inventory_date_start' => session('search_inventory_date_start'),
            'search_inventory_date_end' => session('search_inventory_date_end'),
            'search_inventory_result' => session('search_inventory_result'),
            'search_mode' => session('search_mode'),
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    public function inventory_history_list_export()
    {
        // 出力対象があれば出力
        if(count(session('inventory_history_list_export'))){
            // 出力する情報を整理
            $InventoryHistoryListExportService = new InventoryHistoryListExportService();
            $export = $InventoryHistoryListExportService->export(session('inventory_history_list_export'));
            // CSVで出力
            return (new FastExcel($export))->download('【Ivy】棚卸履歴一覧出力_' . new Carbon('now') . '.csv');
        }
        // 出力対象がなければ戻る
        if(!count(session('inventory_history_list_export'))){
            session()->flash('alert_danger', '出力できる情報がありません。');
            return back();
        }
    }
}
