<?php

namespace App\Services;

use App\Models\InventoryHistory;

class InventoryHistoryListExportService
{
    public function export($inventory_history_list_export)
    {
        // 出力用の変数を初期化
        $export = [];
        // 日本語のカラム名を定義
        $jp_key = ['棚卸日', '棚卸時間', '実施者', '商品コード', '個別JAN', 'ブランド名', '商品名1', '商品名2', '棚卸数', '在庫数', '棚卸結果'];
        // 出力対象の分だけループ
        foreach($inventory_history_list_export as $inventory_history)
        {
            // 出力する値を抽出
            $value = $inventory_history->only(
                [
                    'inventory_date', 
                    'inventory_time', 
                    'operator_name', 
                    'item_code', 
                    'individual_jan_code', 
                    'brand_name', 
                    'item_name_1', 
                    'item_name_2', 
                    'inventory_quantity', 
                    'logical_stock',
                    'inventory_result', 
                ]
            );
            // キーを英語から日本語に変更して連想配列に追加
            $export[] = array_combine($jp_key, $value);
        }
        return $export;
    }
}