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
        // ??????????????????????????????
        if(count(session('item_list_export'))){
            // ???????????????????????????
            $ItemListExportService = new ItemListExportService();
            $export = $ItemListExportService->export(session('item_list_export'));
            // CSV?????????
            return (new FastExcel($export))->download('???Ivy?????????????????????_' . new Carbon('now') . '.csv');
        }
        // ?????????????????????????????????
        if(!count(session('item_list_export'))){
            session()->flash('alert_danger', '??????????????????????????????????????????');
            return back();
        }
    }
}
