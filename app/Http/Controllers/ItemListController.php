<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Services\ItemListExportService;
use App\Services\ItemSearchSortService;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;

class ItemListController extends Controller
{
    public function item_list()
    {
        $ItemSearchSortService = new ItemSearchSortService();
        $items = $ItemSearchSortService->open_process();
        return view('data.item_list')->with([
            'items' => $items,
            'search_mode' => session('search_mode'),
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    public function item_list_search(Request $request)
    {
        $ItemSearchSortService = new ItemSearchSortService();
        $items = $ItemSearchSortService->search_enter($request);
        return view('data.item_list')->with([
            'items' => $items,
            'search_item_code' => session('search_item_code'),
            'search_individual_jan_code' => session('search_individual_jan_code'),
            'search_brand_name' => session('search_brand_name'),
            'search_item_name_1' => session('search_item_name_1'),
            'search_item_name_2' => session('search_item_name_2'),
            'search_mode' => session('search_mode'),
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    public function item_list_sort(Request $request)
    {
        $ItemSearchSortService = new ItemSearchSortService();
        $items = $ItemSearchSortService->sort_enter($request);
        return view('data.item_list')->with([
            'items' => $items,
            'search_item_code' => session('search_item_code'),
            'search_individual_jan_code' => session('search_individual_jan_code'),
            'search_brand_name' => session('search_brand_name'),
            'search_item_name_1' => session('search_item_name_1'),
            'search_item_name_2' => session('search_item_name_2'),
            'search_mode' => session('search_mode'),
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    public function item_list_export()
    {
        // 出力対象があれば出力
        if(count(session('item_list_export'))){
            // 出力する情報を整理
            $ItemListExportService = new ItemListExportService();
            $export = $ItemListExportService->export(session('item_list_export'));
            // CSVで出力
            return (new FastExcel($export))->download('【Ivy】商品一覧出力_' . new Carbon('now') . '.csv');
        }
        // 出力対象がなければ戻る
        if(!count(session('item_list_export'))){
            session()->flash('alert_danger', '出力できる情報がありません。');
            return back();
        }
    }
}
