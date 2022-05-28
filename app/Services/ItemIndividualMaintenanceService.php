<?php

namespace App\Services;

use App\Models\Item;
use Validator;
use Carbon\Carbon;

class ItemIndividualMaintenanceService
{
    public function update_validator($req_param)
    {
        // バリデーションエラー情報を格納する変数をセット
        $validator_errors = [];
        // バリデーションルール
        $rulus = [
            'item_code' => 'exists:items',
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
            'logical_stock' => 'nullable | integer',
        ];
        // バリデーションエラーメッセージ
        $message = [
            'item_code.exists' => 'システムに存在しない商品コードです。',
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
            'qr_inspection_enabled.boolean' => 'QR検品有効フラグは0 or 1で入力して下さい。',
            'logical_stock' => '在庫数は数値で入力して下さい。',
        ];
        // バリデーション
        $validator = Validator::make($req_param, $rulus, $message);
        // バリデーションエラーの有無をチェック
        if ($validator->fails()) {
            // エラー情報を取得
            $errors = $validator->errors()->messages();
            foreach ($errors as $error) {
                foreach ($error as $key => $val) {
                    $validator_error[] = 
                    [
                        'error_message' => $val,
                    ];
                }
            }
            // 行数をキーに情報を追加（+1しているのは、foreachが0から始まっているため）
            $validator_errors[] = $validator_error;
        }
        return $validator_errors;
    }

    public function update($req_param)
    {
        // 更新
        Item::where('item_code', $req_param['item_code'])->update($req_param);
        return;
    }
}