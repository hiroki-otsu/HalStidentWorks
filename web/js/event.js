$('button.sweet').click(function(){
    var title = $('#event [name=title]').val();
    var category = $('#event [name=category]').val();
    var date = $('#event [name=eventDate]').val();
    var target = $('#event [name="target[]"]').val();
    var content = $('#event [name=content]').val();
    var flg = true;

    var empty = [];
    var count = 0;

    inputValuesCheck(title);
    inputValuesCheck(category);
    inputValuesCheck(date);
    inputValuesCheck(target);
    inputValuesCheck(content);
    if(flg){
        swal({
            title: "確認",
            text: "この内容でイベントを投稿しますか？",
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
                    url: 'event.php',
                    type: 'POST',
                    dataType: "JSON",
                    data:{
                        'title':title,
                        'category':category,
                        'date':date,
                        'target':target,
                        'content':content
                    }
                }).done(function(data) {
                    if (data){
                        swal({
                            title: "成功",
                            text: "投稿することが出来ました",
                            icon: "success",
                            dangerMode: true,
                            button: "OK!",
                            className: 'true-event'
                        });
                        $(document).on('click','.true-event',function(){
                            location.href = "http://192.168.33.10/php/HalStudentWorks/web/events.php"
                        });
                    }
                    else{
                        swal({
                            title: "エラー",
                            text: "投稿に失敗しました。もう一度やり直してください。",
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
            }else{
                console.log('Cancel!')
            }
        })
    }
    else {
        swal({
            title: "エラー",
            text: "入力また選択されていない項目があります。",
            icon: "error",
            dangerMode: true,
            button: "OK!",
        });
    }
    function inputValuesCheck(value) {
        if (value === ""){
            empty[count] = value;
            count ++ ;
            flg = false;
        }
    }
});
