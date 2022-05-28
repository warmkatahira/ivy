<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Stock;

class ItemSearchSortService
{
    public function open_process()
    {
        // セッションをクリア
        session()->forget(
            [
                'search_item_code',
                'search_individual_jan_code', 
                'search_brand_name', 
                'search_item_name_1', 
                'search_item_name_2', 
                'sort_column', 
                'direction'
            ]
        );
        // 検索モードを「Off」に設定
        session(['search_mode' => 'Off']);
        // CSV出力する情報を格納
        session(['item_list_export' => Item::all()]);
        // 処理後に戻るURLをセッションに格納
        session(['previous_url' => url()->full()]);
        // ページネーションの設定
        $items = Item::paginate(80);
        return $items;
    }

    public function search_enter($request)
    {
        // 検索ワードをセッションに格納
        session(['search_item_code' => $request->search_item_code]);
        session(['search_individual_jan_code' => $request->search_individual_jan_code]);
        session(['search_brand_name' => $request->search_brand_name]);
        session(['search_item_name_1' => $request->search_item_name_1]);
        session(['search_item_name_2' => $request->search_item_name_2]);
        // 検索モードを「On」に設定（検索中であることを分かるようにしている）
        session(['search_mode' => 'On']);
        // 検索+ソート処理を実施
        $items = $this->search_and_sort_process();
        return $items;
    }

    public function sort_enter($request)
    {
        // ソート内容をセッションに格納
        session(['sort_column' => $request->sort_column]);
        session(['direction' => $request->direction]);
        // 検索+ソート処理を実施
        $items = $this->search_and_sort_process();
        return $items;
    }

    public function search_and_sort_process()
    {
        // 検索処理
        $query = $this->search_process(session('search_item_code'), session('search_individual_jan_code'), session('search_brand_name'), session('search_item_name_1'), session('search_item_name_2'));
        // ソート処理
        $query = $this->sort_process($query, session('sort_column'), session('direction'));
        // CSV出力する情報を格納
        session(['item_list_export' => $query->get()]);
        // 処理後に戻るURLをセッションに格納
        session(['previous_url' => url()->full()]);
        // ページネーションの設定
        $query = $query->paginate(30);
        return $query;
    }

    public function search_process($search_item_code, $search_individual_jan_code, $search_brand_name, $search_item_name_1, $search_item_name_2)
    {
        // 検索ワードがあれば、検索条件を追加
        $query = Item::query();
        if (isset($search_item_code)) {
            $query->where('items.item_code', 'like', '%' . $search_item_code . '%');
        }
        if (isset($search_individual_jan_code)) {
            $query->where('items.individual_jan_code', 'like', '%' . $search_individual_jan_code . '%');
        }
        if (isset($search_brand_name)) {
            $query->where('items.brand_name', 'like', '%' . $search_brand_name . '%');
        }
        if (isset($search_item_name_1)) {
            $query->where('items.item_name_1', 'like', '%' . $search_item_name_1 . '%');
        }
        if (isset($search_item_name_2)) {
            $query->where('items.item_name_2', 'like', '%' . $search_item_name_2 . '%');
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