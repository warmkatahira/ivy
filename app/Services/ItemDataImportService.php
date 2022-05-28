<?php

namespace App\Services;

use App\Models\ItemImport;
use App\Models\Item;
use Validator;
use Carbon\Carbon;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\DB;

class ItemDataImportService
{
    // インポートテーブルにデータを格納する
    public function item_data_import_validator($all_line)
    {
        // バリデーションエラー情報を格納する変数をセット
        $validator_errors = [];
        // テーブルをクリア(連番である「ID」もリセットされる「truncate」を使用)
        ItemImport::truncate();
        // 取得したデータの分だけループ
        foreach ($all_line as $index => $line) {
            // UTF-8形式に変換
            $line = mb_convert_encoding($line, 'UTF-8', 'ASCII, JIS, UTF-8, SJIS-win');
            // 追加する情報を変数に格納
            $param = [
                'item_code' => $line['商品コード'],
                'integrate_jan_code' => str_replace(' ', '', $line['代表JAN']),
                'individual_jan_code' => str_replace(' ', '', $line['個別JAN']),
                'brand_name' => $line['ブランド名'],
                'item_name_1' => $line['商品名1'],
                'item_name_2' => $line['商品名2'],
                'jan_start_position' => $line['JAN開始位置'],
                'exp_start_position' => $line['EXP開始位置'],
                'lot_start_position' => $line['LOT開始位置'],
                'lot_length' => $line['LOT桁数'],
                's_power_code' => $line['S-POWERコード'],
                's_power_code_start_position' => $line['S-POWERコード開始位置'],
                'location' => $line['ロケーション'],
                'qr_inspection_enabled' => $line['QR検品有効フラグ'],
                'logical_stock' => $line['在庫数'],
            ];
            // バリデーションルール
            $rulus = [
                'item_code' => 'required',
                'integrate_jan_code' => 'nullable | digits:13',
                'individual_jan_code' => 'required | digits:13',
                'item_name_1' => 'required',
                'jan_start_position' => 'required | integer',
                'exp_start_position' => 'nullable | integer',
                'lot_start_position' => 'nullable | integer',
                'lot_length' => 'nullable | integer',
                's_power_code' => 'nullable | integer',
                's_power_code_start_position' => 'nullable | integer',
                'qr_inspection_enabled' => 'required | boolean',
                'logical_stock' => 'nullable || integer',
            ];
            // バリデーションエラーメッセージ
            $message = [
                'item_code.required' => '商品コードは必須です。',
                'integrate_jan_code.digits' => '代表JANは数値13桁で入力して下さい。',
                'individual_jan_code.required' => '個別JANは必須です。',
                'individual_jan_code.digits' => '個別JANは数値13桁で入力して下さい。',
                'item_name_1.required' => '商品名1は必須です。',
                'jan_start_position.required' => 'JAN開始位置は必須です。',
                'jan_start_position.integer' => 'JAN開始位置は数値で入力して下さい。',
                'exp_start_position.integer' => 'EXP開始位置は数値で入力して下さい。',
                'lot_start_position.integer' => 'LOT開始位置は数値で入力して下さい。',
                'lot_length.integer' => 'LOT桁数は数値で入力して下さい。',
                's_power_code.integer' => 'S-POWERコードは数値で入力して下さい。',
                's_power_code_start_position.integer' => 'S-POWERコード開始位置は数値で入力して下さい。',
                'qr_inspection_enabled.required' => 'QR検品有効フラグは必須です。',
                'qr_inspection_enabled.boolean' => 'QR検品有効フラグは0 or 1で入力して下さい。',
                'logical_stock' => '在庫数は数値で入力して下さい。',
            ];
            // バリデーション
            $validator = Validator::make($param, $rulus, $message);
            // バリデーションエラーの有無をチェック
            if ($validator->fails()) {
                // エラー情報を取得
                $validator_error = [];
                $errors = $validator->errors()->messages();
                foreach ($errors as $error) {
                    foreach ($error as $key => $val) {
                        $validator_error[] = 
                        [
                            'error_message' => $val,
                        ];
                    }
                }
                // 行数をキーに情報を追加（+2しているのは、実際の行数に合わせるため）
                $validator_errors[$index + 2] = $validator_error;
            } else {
                // バリデーションエラーがなかった場合、レコード追加
                ItemImport::insert($param);
            }
        }
        return $validator_errors;
    }

    // 更新 or 追加の処理を行う
    public function item_data_import_upsert()
    {
        $items = ItemImport::all();
        $item_param = [];
        foreach ($items as $item) {
            $item_param[] = [
                'item_code' => $item['item_code'],
                'integrate_jan_code' => $item['integrate_jan_code'],
                'individual_jan_code' => $item['individual_jan_code'],
                'brand_name' => $item['brand_name'],
                'item_name_1' => $item['item_name_1'],
                'item_name_2' => $item['item_name_2'],
                'jan_start_position' => $item['jan_start_position'],
                'exp_start_position' => $item['exp_start_position'],
                'lot_start_position' => $item['lot_start_position'],
                'lot_length' => $item['lot_length'],
                's_power_code' => $item['s_power_code'],
                's_power_code_start_position' => $item['s_power_code_start_position'],
                'location' => $item['location'],
                'qr_inspection_enabled' => $item['qr_inspection_enabled'],
                'logical_stock' => $item['logical_stock'],
            ];
        }
        // トランザクションとして処理
        DB::beginTransaction();
        try {
            Item::upsert($item_param, ['item_code']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return;
    }

    // バリデーションエラーを出力
    public function item_data_import_validator_error_export($validator_errors)
    {
        // 出力するデータを整理
        $export_data = [];
        foreach ($validator_errors as $index => $errors) {
            $error_message = '';
            // 同一行のエラーメッセージを結合
            foreach ($errors as $error) {
                $error_message = empty($error_message) ? $error['error_message'] : $error_message . '/' . $error['error_message'];
            }
            $param = [
                'エラー行数' => $index . '行目',
                'エラー内容' => $error_message,
            ];
            $export_data[] = $param;
        }
        // エクスポートファイルのファイル名を指定
        $fileName = '【Ivy】商品一括取込エラー情報_' . new Carbon('now') . '.csv';
        // エクスポート処理
        return compact('export_data', 'fileName');
    }
}