<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Services\ItemDataImportService;
use App\Services\ItemSearchSortService;
use App\Services\ItemIndividualMaintenanceService;
use Carbon\Carbon;
use App\Models\Item;

class ItemMaintenanceController extends Controller
{
    public function top()
    {
        return view('item_maintenance.top');
    }

    public function data_import(Request $request)
    {
        // 選択したデータを保存
        $select_file = $request->file('item_data_import');
        $uploaded_file = $select_file->getClientOriginalName();
        $orgName = 'item_master.csv';
        $spath = storage_path('app/');
        $path = $spath.$select_file->storeAs('public/import',$orgName);
        // データの情報を取得
        $all_line = (new FastExcel)->import($path);
        // 取得したデータをインポート
        $ItemDataImportService = new ItemDataImportService();
        $validator_errors = $ItemDataImportService->item_data_import_validator($all_line);
        // バリデーションエラーがあったら処理を中段
        if (!empty($validator_errors)) {
            //セッションにエラー情報とエラー日時を格納
            session(['validator_errors' => $validator_errors, 'error_date' => new Carbon('now')]);
            session()->flash('alert_danger', count($validator_errors) . "件のエラーがあった為、商品一括取込を中断しました。\n詳細はエラー出力で確認して下さい。");
            return redirect()->route('item_maintenance.top');
        }
        // 更新 or 追加の処理を行う
        $ItemDataImportService->item_data_import_upsert();
        // バリデーションエラーのセッションを削除
        session()->forget('validator_errors');
        // 完了メッセージを表示
        session()->flash('alert_success', '商品一括取込が完了しました。');
        return redirect()->route('item_maintenance.top');
    }

    public function validator_error_export()
    {
        // セッションにあるエラー情報を変数にセット
        $validator_errors = session('validator_errors');
        // エラー情報を整理
        $ItemDataImportService = new ItemDataImportService();
        $export = $ItemDataImportService->item_data_import_validator_error_export($validator_errors);
        // エラー情報をエクスポート
        return (new FastExcel($export['export_data']))->download($export['fileName']);
    }

    public function individual_top()
    {
        $ItemSearchSortService = new ItemSearchSortService();
        $items = $ItemSearchSortService->open_process();
        return view('item_maintenance.individual_top')->with([
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
        return view('item_maintenance.individual_top')->with([
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
        return view('item_maintenance.individual_top')->with([
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

    public function individual_modify_index(Request $request)
    {
        // エラー時の遷移に使用するURLを取得
        session(['error_redirect_url' => url()->full()]);
        $item = Item::where('item_code', $request->item_code)->first();
        return view('item_maintenance.individual_modify_index', compact('item'));
    }

    public function individual_modify(Request $request)
    {
        // リクエストパラメータを取得
        $req_param = $request->only([
            'item_code', 
            'integrate_jan_code', 
            'individual_jan_code', 
            'brand_name', 'item_name_1', 
            'item_name_2', 
            'jan_start_position', 
            'exp_start_position', 
            'lot_start_position', 
            'lot_length', 
            's_power_code', 
            's_power_code_start_position', 
            'location', 
            'qr_inspection_enabled',
            'logical_stock'
        ]);
        $ItemIndividualMaintenanceService = new ItemIndividualMaintenanceService();
        // 更新ボタンが押下された場合
        if ($request->has('update')) {
            $validator_errors = $this->individual_item_update($req_param, $ItemIndividualMaintenanceService);
            // バリデーションエラーがあったら変更画面に戻すように遷移
            if (!empty($validator_errors)) {
                return redirect(session('error_redirect_url'))->withInput();
            }
        }
        // 削除ボタンが押下された場合
        if ($request->has('delete')) {
            // 削除処理
            Item::where('item_code', $request->item_code)->delete();
            // 完了メッセージを表示
            session()->flash('alert_success', '商品を削除しました。');
        }
        return redirect(session('previous_url'));
    }

    public function individual_item_update($req_param, $ItemIndividualMaintenanceService)
    {
        // バリデーションチェック
        $validator_errors = $ItemIndividualMaintenanceService->update_validator($req_param);
        // バリデーションエラーがあったら処理を中段
        if (!empty($validator_errors)) {
            // バリデーションエラーを整理
            $validator_error_msg = "変更内容に誤りがあります\n";
            foreach ($validator_errors as $index => $errors) {
                foreach ($errors as $error) {
                    $validator_error_msg = $validator_error_msg . "\n" . '■' . $error['error_message'];
                }
            }
            //dd($validator_error_msg);
            session()->flash('alert_danger', $validator_error_msg);
        }
        // バリデーションエラーがなかったら更新処理
        if (empty($validator_errors)) {
            $ItemIndividualMaintenanceService->update($req_param);
            // 完了メッセージを表示
            session()->flash('alert_success', '商品情報を更新しました。');
        }
        return $validator_errors;
    }
}
