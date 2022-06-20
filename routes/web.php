<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ItemMaintenanceController;
use App\Http\Controllers\ItemListController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryHistoryListController;
use App\Http\Controllers\MyRecordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::group(['middleware' => 'auth'], function(){
    // 棚卸
    Route::get('/inventory', [InventoryController::class, 'top'])->name('inventory.top');
    Route::get('/inventory/{iten_info}', [InventoryController::class, 'ajax_process'])->name('inventory.ajax_process');
    Route::get('/inventory_confirm', [InventoryController::class, 'inventory_confirm'])->name('inventory.confirm');
    Route::get('/inventory_cancel', [InventoryController::class, 'inventory_cancel'])->name('inventory.cancel');


    // データ
    Route::get('/data', [DataController::class, 'top'])->name('data.top');
    Route::get('/item_list', [ItemListController::class, 'item_list'])->name('item_list.index');
    Route::get('/item_list/search', [ItemListController::class, 'item_list_search'])->name('item_list.search');
    Route::get('/item_list/sort/{sort_column}/{direction}', [ItemListController::class, 'item_list_sort'])->name('item_list.sort');
    Route::get('/item_list_export', [ItemListController::class, 'item_list_export'])->name('item_list.export');
    
    Route::get('/inventory_history_list', [InventoryHistoryListController::class, 'inventory_history_list'])->name('inventory_history_list.index');
    Route::get('/inventory_history_list/search', [InventoryHistoryListController::class, 'inventory_history_list_search'])->name('inventory_history_list.search');
    Route::get('/inventory_history_list/sort/{sort_column}/{direction}', [InventoryHistoryListController::class, 'inventory_history_list_sort'])->name('inventory_history_list.sort');
    Route::get('/inventory_history_list_export', [InventoryHistoryListController::class, 'inventory_history_list_export'])->name('inventory_history_list.export');


    // メンテナンス
    Route::get('/maintenance', [MaintenanceController::class, 'top'])->name('maintenance.top');
    Route::get('/item_maintenance', [ItemMaintenanceController::class, 'top'])->name('item_maintenance.top');
    Route::get('/item_data_import', [ItemMaintenanceController::class, 'data_import_top'])->name('item_maintenance.data_import_top');
    Route::post('/item_data_import', [ItemMaintenanceController::class, 'data_import'])->name('item_maintenance.data_import');
    Route::get('/item_master_import/validator_error_export', [ItemMaintenanceController::class, 'validator_error_export'])->name('item_maintenance.validator_error_export');
    Route::get('/item_maintenance/individual_top', [ItemMaintenanceController::class, 'individual_top'])->name('item_maintenance.individual_top');
    Route::get('/item_maintenance/individual_modify_index/{item_code}', [ItemMaintenanceController::class, 'individual_modify_index'])->name('item_maintenance.individual_modify_index');
    Route::post('/item_maintenance/individual_modify', [ItemMaintenanceController::class, 'individual_modify'])->name('item_maintenance.individual_modify');
    Route::get('/item_maintenance/search', [ItemMaintenanceController::class, 'item_list_search'])->name('item_maintenance.search');
    Route::get('/item_maintenance/sort/{sort_column}/{direction}', [ItemMaintenanceController::class, 'item_list_sort'])->name('item_maintenance.sort');

    // My記録
    Route::get('/my_record', [MyRecordController::class, 'top'])->name('myrecord.top');
    Route::get('/my_record_chart_ajax', [MyRecordController::class, 'chart_ajax']);

});