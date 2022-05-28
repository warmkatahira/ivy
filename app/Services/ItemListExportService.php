<?php

namespace App\Services;

use App\Models\Item;


class ItemListExportService
{
    public function export($item_list_export)
    {
        // 出力用の変数を初期化
        $export = [];
        // 日本語のカラム名を定義
        $jp_key = ['商品コード', '代表JAN', '個別JAN', 'ブランド名', '商品名1', '商品名2', 'JAN開始位置', 'EXP開始位置', 'LOT開始位置', 'LOT桁数', 'S-POWERコード', 'S-POWERコード開始位置', 'ロケーション', 'QR検品有効フラグ', '在庫数'];
        // 出力対象の分だけループ
        foreach($item_list_export as $item)
        {
            // 出力する値を抽出
            $value = $item->only(['item_code', 'integrate_jan_code', 'individual_jan_code', 'brand_name', 'item_name_1', 'item_name_2', 'jan_start_position', 'exp_start_position', 'lot_start_position', 'lot_length', 's_power_code', 's_power_code_start_position', 'location', 'qr_inspection_enabled', 'logical_stock']);
            // キーを英語から日本語に変更して連想配列に追加
            $export[] = array_combine($jp_key, $value);
        }
        return $export;
    }
}