<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InventoryHistory;
use Carbon\Carbon;

class MyRecordController extends Controller
{
    public function top()
    {
        // 今日の日付を取得
        $today = Carbon::today();
        // 当日の直近3件の棚卸実績データを取得
        $last_inventory_histories = InventoryHistory::where('operator_id', Auth::user()->id)
                                    ->whereDate('created_at', $today)
                                    ->orderBy('created_at', 'desc')
                                    ->limit(3)
                                    ->get();
        // 当日の合計棚卸数を取得
        $inventory_quantity_sum = InventoryHistory::where('operator_id', Auth::user()->id)
                                    ->whereDate('created_at', $today)
                                    ->sum('inventory_quantity');
        return view('myrecord.top')->with([
            'last_inventory_histories' => $last_inventory_histories,
            'inventory_quantity_sum' => $inventory_quantity_sum,
        ]);
    }

    // チャートで表示する情報を取得
    public function chart_ajax()
    {
        // 今日の日付を取得
        $today = Carbon::today();
        // 棚卸結果=OKの件数を取得
        $inventory_result_ok_count = InventoryHistory::where('operator_id', Auth::user()->id)
                                    ->whereDate('created_at', $today)
                                    ->where('inventory_result', 'OK')
                                    ->count();
        // 棚卸結果=NGの件数を取得
        $inventory_result_ng_count = InventoryHistory::where('operator_id', Auth::user()->id)
                                    ->whereDate('created_at', $today)
                                    ->where('inventory_result', 'NG')
                                    ->count();
        // 結果を返す
        return response()->json(['inventory_result_ok_count' => $inventory_result_ok_count, 'inventory_result_ng_count' => $inventory_result_ng_count]);
    }
}
