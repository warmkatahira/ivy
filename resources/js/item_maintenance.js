$(function(){
    // 新規マスタ一括取込処理
    $("[id=item_data_import]").on("change",function(){
        const form = document.getElementById('item_data_import_form');
        const select_file = document.getElementById('item_data_import');
        const select_file_split = select_file.value.split('\\');
        // 処理を実行するか確認
        var result = window.confirm('新規マスタ一括取込を実行しますか？\r\n\r\n' + select_file_split[select_file_split.length -1]);
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            form.submit();
        }else {
            // 同じファイルを続けて選択するとイベントが発生しないので空にしている
            select_file.value = '';
            return false;
        }
    });
    // 削除ボタンが押下されたら、処理の確認を実施
    $("[name=delete]").on("click",function(){
        var result = window.confirm('商品の削除を実行しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            form.submit();
        }else {
            return false;
        }
    });
});