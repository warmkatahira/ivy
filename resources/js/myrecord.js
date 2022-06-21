const inventory_total_count = document.getElementById('inventory_total_count');
const inventory_result_ok_count = document.getElementById('inventory_result_ok_count');
const inventory_result_ng_count = document.getElementById('inventory_result_ng_count');

var today_inventory_result_ratio = null;
window.onload = function () {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },    
        url: '/ivy/my_record_chart_ajax',
        type: 'GET',
        dataType: 'json',
        success: function(data){
            // 合計件数を取得
            const all_count = data['inventory_result_ok_count'] + data['inventory_result_ng_count'];
            // 件数が1件以上あれば情報を表示
            if(all_count != 0){
                // 件数と割合を表示
                inventory_total_count.innerHTML = 'TOTAL <i class="las la-caret-right la-lg"></i> ' + all_count.toLocaleString();
                inventory_result_ok_count.innerHTML = 'OK <i class="las la-caret-right la-lg"></i> ' + data['inventory_result_ok_count'].toLocaleString() + ' (' + Math.round((data['inventory_result_ok_count'] / all_count) * 100) + '%)';
                inventory_result_ng_count.innerHTML = 'NG <i class="las la-caret-right la-lg"></i> ' + data['inventory_result_ng_count'].toLocaleString() + ' (' + Math.round((data['inventory_result_ng_count'] / all_count) * 100) + '%)';
                // 当日の棚卸結果割合チャートを表示
                let today_inventory_result_ratio_context = document.querySelector("#today_inventory_result_ratio").getContext('2d');
                // 前回のチャートを破棄
                if (today_inventory_result_ratio != null) {
                    today_inventory_result_ratio.destroy();
                }
                today_inventory_result_ratio = new Chart(today_inventory_result_ratio_context, {
                    type: 'doughnut',
                    data: {
                        labels: ['OK', 'NG'],
                        datasets: [{
                            data: [data['inventory_result_ok_count'], data['inventory_result_ng_count']],
                            backgroundColor: ["rgba(37,99,235,1)", "rgba(220,38,38,1)"]
                        }],
                    },
                    options: {
                        responsive: false,
                        title: {
                            display: true,
                        },
                    }
                })
            }
        },
        error: function(){
            alert('失敗');
        }
    });
}