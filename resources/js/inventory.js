const scan_info = document.getElementById("scan_info");
const logical_stock = document.getElementById("logical_stock");
const inventory_quantity = document.getElementById("inventory_quantity");
const message = document.getElementById("message");
const inventory_quantity_difference = document.getElementById("inventory_quantity_difference");
const individual_jan_code = document.getElementById("individual_jan_code");
const brand_name = document.getElementById("brand_name");
const item_name_1 = document.getElementById("item_name_1");
const item_name_2 = document.getElementById("item_name_2");
const today_inventory_quantity = document.getElementById("today_inventory_quantity");

const scan_ok_audio = new Audio('audio/scan_ok_audio.mp3');
const scan_ng_audio = new Audio('audio/scan_ng_audio.mp3');

const alert_success_div = document.getElementById('alert_success');

// ページの読み込み完了と同時に実行されるよう指定
window.onload = scan_set;

window.document.onkeydown = function(event){
    // エンターが押下されて、商品スキャンに値がある場合
    if (event.key === 'Enter' && scan_info.value) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },    
            url: '/ivy/inventory/' + scan_info.value,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                //message.innerHTML = '';
                // 照合結果がNGの場合
                if(data['item_searched_flg'] == false){
                    audio_play('ng');
                    // エラーメッセージを表示
                    error_msg(data['error_msg']);
                }
                // 照合結果がOKの場合
                if(data['item_searched_flg'] == true){
                    audio_play('ok');
                    // 棚卸数を更新
                    inventory_quantity.innerHTML = data['inventory_quantity'];
                    // 1商品目のスキャンの場合
                    if (data['inventory_quantity'] == 1){
                        // フラッシュメッセージがある場合のみ削除処理
                        if (alert_success_div !== null){
                            alert_success_div.remove();
                        }
                        // 在庫数を表示
                        logical_stock.innerHTML = data['item']['logical_stock'];
                        // 商品情報を表示
                        individual_jan_code.innerHTML = data['item']['individual_jan_code'];
                        brand_name.innerHTML = data['item']['brand_name'];
                        item_name_1.innerHTML = data['item']['item_name_1'];
                        item_name_2.innerHTML = data['item']['item_name_2'];
                        // 当日の累計棚卸数を表示
                        today_inventory_quantity.innerHTML = data['today_inventory_quantity'];
                    }
                    // 棚卸差分を更新
                    inventory_quantity_difference.innerHTML = data['inventory_quantity'] - data['item']['logical_stock'];
                }
                scan_set();
            },
            error: function(){
                audio_play('ng');
                // 通信が失敗した場合
                error_msg("通信に失敗しました");
                scan_set();
            }
        });
    }
}

// 効果音を再生
function audio_play(play_category){
    // 効果音を再生し、再生中に次の処理がされた場合にすぐ再生されるように再生位置をリセット
    if(play_category == 'ok'){
        scan_ok_audio.play();
        scan_ok_audio.currentTime = 0;
    }
    if(play_category == 'ng'){
        scan_ng_audio.play();
        scan_ng_audio.currentTime = 0;
    }
}

// エラーメッセージ表示用
function error_msg(error_msg){
    // return error_msg + "<br><p class='text-red-600'>" + scan_info.value + "</p>";
    alert(error_msg + '\n\n' + scan_info.value);
}
// スキャンエリアをクリアして、フォーカスをセット
function scan_set(){
    scan_info.value = '';
    scan_info.focus();
}
// 確定ボタンが押下されたら、処理の確認を実施
$("[id=inventory_confirm]").on("click",function(){
    // 棚卸数がない場合、処理を中断
    if(inventory_quantity.innerHTML == ''){
        alert('棚卸を行ってから確定をして下さい。');
        return false;
    }
    var result = window.confirm('棚卸確定を実行しますか？');
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == true) {
        form.submit();
    }else {
        return false;
    }
});

// 取消ボタンが押下されたら、処理の確認を実施
$("[id=inventory_cancel]").on("click",function(){
    var result = window.confirm('棚卸取消を実行しますか？');
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == true) {
        form.submit();
    }else {
        return false;
    }
});

// 訂正ボタンが押下されたら、処理の確認を実施
$("[id=inventory_modify]").on("click",function(){
    // 棚卸中でなければ。ここで処理を終了
    if(inventory_quantity.innerHTML == ''){
        alert('棚卸中でない為、訂正は実施できません。');
        return false;
    }
    const modify_quantity = prompt('訂正後の棚卸数を入力して下さい。');
    // 値がnullだったら、ここで処理を終了
    if(modify_quantity === null || modify_quantity == ''){
        return false;
    }
    // 値が数値でないか、1よりも小さい場合はここで処理を終了
    if(isNaN(modify_quantity) || modify_quantity < 1){
        alert('入力した値が正しくありません。');
        return false;
    }
    // 
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },    
        url: '/ivy/inventory_modify/' + modify_quantity,
        type: 'GET',
        dataType: 'json',
        success: function(data){
            // 棚卸数を入力された値に変更
            inventory_quantity.innerHTML = data['inventory_quantity'];
            // 棚卸差分を更新
            inventory_quantity_difference.innerHTML = data['inventory_quantity'] - data['item']['logical_stock'];
            scan_set()
        },
        error: function(){
            alert('訂正処理が失敗しました。');
        }
    });
});