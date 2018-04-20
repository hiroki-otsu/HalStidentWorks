$('a.sweet').click(function(){
    var detailes = $(this).data('join');
    var decision =detailes.split("&");
    var text = null;
    var joinDecision = null;//ステータスコード

    if(decision[0]!=1){
        joinDecision =2;//参加ステータスコード
        text = 'このイベントに参加しますか？';
        sweetAlertConfirm(text,joinDecision,decision[1]);
    }else{
        joinDecision =1;//不参加ステータスコード
        text = 'このイベントに不参加しますか？';
        sweetAlertConfirm(text,joinDecision,decision[1]);
    }
});
/**
 *  確認を表示するsweetAlert関数
 *
 * @param text
 */
function sweetAlertConfirm(text,eventData,no) {
    swal({
        title: "確認",
        text: text,
        icon: "info",
        dangerMode: true,
        buttons: {
            cancel: {
                text: "Cancel",
                value: false,
                visible: true,
                className: "",
                closeModal: true,
            },
            confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "",
                closeModal: true
            },
        },
    }).then(function (value) {
        if(value){
            $.ajax({
                url: 'registration.php',
                type: 'POST',
                dataType: "JSON",
                data:{
                    'eventNo':no,
                    'join':eventData
                }
            }).done(function(data) {
                if (data){
                    if(eventData!=1){
                        swal({
                            title: "成功",
                            text: "参加申し込みが完了しました。",
                            icon: "success",
                            dangerMode: true,
                            button: "OK!",
                            className: 'true-event'
                        });
                        $(document).on('click','.true-event',function(){
                            location.href = "http://192.168.33.10/php/HalStudentWorks/web/events.php"
                        });
                    }else{
                        swal({
                            title: "成功",
                            text: "不参加申し込みが完了しました。",
                            icon: "success",
                            dangerMode: true,
                            button: "OK!",
                            className: 'true-event'
                        });
                        $(document).on('click','.true-event',function(){
                            location.href = "http://192.168.33.10/php/HalStudentWorks/web/events.php"
                        });
                    }
                }
                else{
                    swal({
                        title: "エラー",
                        text: "通信に失敗しました。もう一度やり直してください。",
                        icon: "error",
                        dangerMode: true,
                        button: "OK!",
                    });
                }
            }).fail(function(data) {
                swal({
                    title: "エラー",
                    text: "通信に失敗しました。もう一度やり直してください。",
                    icon: "error",
                    dangerMode: true,
                    button: "OK!",
                });
                $('.result').html(data);
            });
        }
    })
}
