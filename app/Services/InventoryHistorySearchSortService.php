<?php

namespace App\Services;

use App\Models\InventoryHistory;
use App\Consts\PaginateConsts;

class InventoryHistorySearchSortService
{
    public function open_process()
    {
        // セッションをクリア
        session()->forget(
            ['search_item_code',
             'search_individual_jan_code', 
             'search_item_name_1', 
             'search_item_name_2', 
             'search_inventory_date_start', 
             'search_inventory_date_end', 
             'search_inventory_result',
             'sort_column', 
             'direction'
            ]
        );
        // 検索モードを「Off」に設定
        session(['search_mode' => 'Off']);
        // CSV出力する情報を格納
        session(['inventory_history_list_export' => InventoryHistory::all()]);
        // ページネーションの設定
        $inventory_histories = InventoryHistory::paginate(PaginateConsts::PAGINATE_50);
        return $inventory_histories;
    }

    public function search_enter($request)
    {
        // 検索ワードをセッションに格納
        session(['search_item_code' => $request->search_item_code]);
        session(['search_individual_jan_code' => $request->search_individual_jan_code]);
        session(['search_item_name_1' => $request->search_item_name_1]);
        session(['search_item_name_2' => $request->search_item_name_2]);
        session(['search_inventory_date_start' => $request->search_inventory_date_start]);
        session(['search_inventory_date_end' => $request->search_inventory_date_end]);
        session(['search_inventory_result' => $request->search_inventory_result]);
        // 検索モードを「On」に設定（検索中であることを分かるようにしている）
        session(['search_mode' => 'On']);
        // 検索+ソート処理を実施
        $inventory_histories = $this->search_and_sort_process();
        return $inventory_histories;
    }

    public function sort_enter($request)
    {
        // ソート内容をセッションに格納
        session(['sort_column' => $request->sort_column]);
        session(['direction' => $request->direction]);
        // 検索+ソート処理を実施
        $inventory_histories = $this->search_and_sort_process();
        return $inventory_histories;
    }

    public function search_and_sort_process()
    {
        // 検索処理
        $query = $this->search_process(session('search_item_code'), session('search_individual_jan_code'), session('search_item_name_1'), session('search_item_name_2'), session('search_inventory_date_start'), session('search_inventory_date_end'), session('search_inventory_result'));
        // ソート処理
        $query = $this->sort_process($query, session('sort_column'), session('direction'));
        // CSV出力する情報を格納
        session(['inventory_history_list_export' => $query->get()]);
        // ページネーションの設定
        $query = $query->paginate(30);
        return $query;
    }

    public function search_process($search_item_code, $search_individual_jan_code, $search_item_name_1, $search_item_name_2, $search_inventory_date_start, $search_inventory_date_end, $search_inventory_result)
    {
        // 検索ワードがあれば、検索条件を追加
        $query = InventoryHistory::query();
        if (isset($search_item_code)) {
            $query->where('item_code', 'like', '%' . $search_item_code . '%');
        }
        if (isset($search_individual_jan_code)) {
            $query->where('individual_jan_code', 'like', '%' . $search_individual_jan_code . '%');
        }
        if (isset($search_item_name_1)) {
            $query->where('item_name_1', 'like', '%' . $search_item_name_1 . '%');
        }
        if (isset($search_item_name_2)) {
            $query->where('item_name_2', 'like', '%' . $search_item_name_2 . '%');
        }
        if (isset($search_inventory_result)) {
            $query->where('inventory_result', 'like', '%' . $search_inventory_result . '%');
        }
        if (isset($search_inventory_date_start) || isset($search_inventory_date_end)) {
            // 開始日だけの場合
            if (isset($search_inventory_date_start) && !isset($search_inventory_date_end)) {
                $query->where('inventory_date', '>=', $search_inventory_date_start);
            }
            // 終了日だけの場合
            if (!isset($search_inventory_date_start) && isset($search_inventory_date_end)) {
                $query->where('inventory_date', '<=', $search_inventory_date_end);
            }
            // 開始日と終了日の場合
            if (isset($search_inventory_date_start) && isset($search_inventory_date_end)) {
                $query->whereBetween('inventory_date', [$search_inventory_date_start, $search_inventory_date_end]);
            }
        }
        
        return $query;
    }

    // ソート条件があれば設定
    public function sort_process($query, $sort_column, $direction)
    {
        if (!empty($sort_column)) {
            $query = $query->orderBy($sort_column, $direction);
        }
        return $query;
    }
}