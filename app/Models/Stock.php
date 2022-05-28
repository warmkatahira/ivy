<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Stock extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'item_code';
    // オートインクリメント無効化
    public $incrementing = false;
    // Laravel 6.0+以降なら指定
    protected $keyType = 'string';
    // ソート用
    use Sortable;

    Public function item()
    {
        // stockモデルのデータを引っ張てくる
        return $this->hasOne('App\Models\Item', 'item_code');
    }
}
