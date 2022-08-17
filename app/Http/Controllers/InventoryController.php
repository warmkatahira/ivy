<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\InventoryHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function top()
    {
        // セッションの中身を削除
        session()->forget(['inventory_item_code', 'inventory_quantity', 'difference_item_code']);
        return view('inventory.top');
    }

    public function ajax_process($scan_info)
    {
        // 変数を初期化
        $item_searched_flg = false;
        $item_difference_flg = false;
        $item = '';
        $logical_stock ='';
        $error_msg = '商品マスタに存在しない商品です';
        // JANコードの場合
        if(strlen($scan_info) == 13){
            // itemsテーブルから情報を取得
            $item = Item::where('individual_jan_code', $scan_info)->first();
            // 取得できていればフラグをtrueに設定し、商品コードを取得
            if(!empty($item)){
                $item_searched_flg = true;
                $item_code = $item->item_code;
            }
        }
        // QRコードの場合
        if(strlen($scan_info) != 13){
            $items = Item::all();
            // 代表JANの商品であるか確認
            foreach($items as $item){
                if($item->integrate_jan_code == substr($scan_info, 0, 13) && $item->s_power_code == substr($scan_info, $item->s_power_code_start_position - 1, 3)){
                    $item_searched_flg = true;
                    // 商品コードを取得する
                    $item_code = $item->item_code;
                    break;
                }
            }
            // 個別JANの商品であるか確認
            $item = Item::where('individual_jan_code', substr($scan_info, 0, 13))->first();
            // 取得できていればフラグをtrueに設定し、商品コードを取得
            if(!empty($item)){
                $item_searched_flg = true;
                $item_code = $item->item_code;
            }
        }
        // 商品が検索できていたら情報を取得
        if($item_searched_flg == true){
            // itemsテーブルから情報を取得
            $item = Item::where('item_code', $item_code)->first();
            session(['item' => $item]);
            // セッションが空でなければ2つ目以降の商品なので、商品コードがセッションの中の情報と一致するか確認
            if(session()->has('inventory_item_code')){
                // 商品コードが一致した場合
                if(session('inventory_item_code') == $item_code){
                    session(['inventory_quantity' => session('inventory_quantity') + 1]);
                }
                // 商品コードが不一致の場合
                if(session('inventory_item_code') != $item_code){
                    session(['difference_item_code' => $item_code]);
                    $item_difference_flg = true;
                }
            }
            // セッションが空の場合、1つ目の商品なので情報を格納
            if(!session()->has('inventory_item_code')){
                session(['inventory_item_code' => $item_code, 'inventory_quantity' => 1]);
                // 今日の日付を取得
                $today = Carbon::today();
                // 累計棚卸数を取得
                $today_inventory_quantity = InventoryHistory::where('item_code', $item_code)
                                            ->whereDate('created_at', $today)
                                            ->sum('inventory_quantity');
                session(['today_inventory_quantity' => $today_inventory_quantity]);
            }
        }
        // 結果を返す
        return response()->json([
            'inventory_quantity' => session('inventory_quantity'),
            'item' => session('item'),
            'item_searched_flg' => $item_searched_flg,
            'error_msg' => $error_msg,
            'today_inventory_quantity' => session('today_inventory_quantity'),
            'item_difference_flg' => $item_difference_flg,
        ]);
    }

    // 対象外の商品の棚卸確定を実施する
    public function inventory_difference_confirm_ajax()
    {
        // 商品情報を取得
        $item = Item::where('item_code', session('difference_item_code'))->first();
        // 棚卸履歴を追加
        $nowDate = new Carbon('now');
        $param = [
            'inventory_date' => $nowDate->format('Y/m/d'),
            'inventory_time' => $nowDate->format('H:i:s'),
            'operator_id' => Auth::user()->id,
            'operator_name' => Auth::user()->name,
            'item_code' => $item->item_code,
            'individual_jan_code' => $item->individual_jan_code,
            'brand_name' => $item->brand_name,
            'item_name_1' => $item->item_name_1,
            'item_name_2' => $item->item_name_2,
            'inventory_quantity' => 1,
            'logical_stock' => $item->logical_stock,
            'inventory_result' => 1 == $item->logical_stock ? 'OK' : 'NG',
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ];
        InventoryHistory::insert($param);
        // 結果を返す
        return response()->json();
    }

    // 棚卸確定
    public function inventory_confirm()
    {
        // 商品情報を取得
        $item = Item::where('item_code', session('inventory_item_code'))->first();
        // 棚卸履歴を追加
        $nowDate = new Carbon('now');
        $param = [
            'inventory_date' => $nowDate->format('Y/m/d'),
            'inventory_time' => $nowDate->format('H:i:s'),
            'operator_id' => Auth::user()->id,
            'operator_name' => Auth::user()->name,
            'item_code' => $item->item_code,
            'individual_jan_code' => $item->individual_jan_code,
            'brand_name' => $item->brand_name,
            'item_name_1' => $item->item_name_1,
            'item_name_2' => $item->item_name_2,
            'inventory_quantity' => session('inventory_quantity'),
            'logical_stock' => $item->logical_stock,
            'inventory_result' => session('inventory_quantity') == $item->logical_stock ? 'OK' : 'NG',
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ];
        InventoryHistory::insert($param);
        // セッションの中身を削除
        session()->forget(['inventory_item_code', 'inventory_quantity', 'difference_item_code']);
        // 完了メッセージを表示
        session()->flash('alert_success', '棚卸確定を実行しました。');
        return redirect()->route('inventory.top');
    }

    // 取り消し処理
    public function inventory_cancel()
    {
        // 棚卸画面を再読み込み
        return back();
    }

    // 訂正処理
    public function inventory_modify($modify_quantity)
    {
        // 訂正後の棚卸数がマイナスにならないか確認
        if(session('inventory_quantity') + (int)$modify_quantity < 0){
            return response()->json(['modify_ng' => '1']);
        }

        // セッションの中身を訂正後の数量に変更
        session(['inventory_quantity' => session('inventory_quantity') + (int)$modify_quantity]);
        // 結果を返す
        return response()->json(['inventory_quantity' => session('inventory_quantity'), 'item' => session('item'), 'today_inventory_quantity' => session('today_inventory_quantity')]);
    }
}
