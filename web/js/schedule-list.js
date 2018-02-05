//HTMLの読み込みが終わった時点でなにかしらの処理
$(document).ready(function() {
    $('#plans table tr td a').click(function() {
        $('#limit').empty();
        var classNo = $(this).data('class');
        console.log(classNo);
        $.ajax({
            url: 'schedule.php',
            type: 'POST',
            dataType: "json",
            data:{
                'no':classNo
            }
        })
        .done(function(data) {
            $('#limit').append('<thead></thead>');
            $('#limit thead').append('<tr><th>限目</th><th>学科</th><th>使用状況</th><th>申請</th></tr>');
            $('#limit').append('<tbody></tbody>');
            for (var i = 0; i < data.length; i++) {
                var usageStatus = '利用不可';
                var usageDisabled = 'disabled="disabled"';
                if(data[i].department_code==null){
                    data[i].department_code = '未使用';
                    usageStatus = '利用可能';
                    usageDisabled = '';
                }
                var requestNo =data[i].schedule_no + '-' + data[i].schedule_limit;
                $('#limit tbody').append('<tr>' +
                    '<td>'+data[i].schedule_limit+'限目</td>' +
                    '<td>'+data[i].department_code+'</td>' +
                    '<td>'+usageStatus+'</td>' +
                    '<td><a class="waves-effect waves-light btn"'+usageDisabled+' data-request="'+requestNo+'">使用申請</a></td>' +
                    '</tr>');
            }
            $('#limit a').click(function() {
                var requestNo = $(this).data('request');
                $(this).attr('disabled', true);
                console.log(requestNo);
                $.ajax({
                    url: 'requestSchedule.php',
                    type: 'POST',
                    dataType: "json",
                    data:{
                        'requestClass': requestNo
                    }
                })
                 .done(function(classData) {
                     
                 })
                 .fail(function(classData) {
                        $('.result').html(classData);
                 });
            });
        })
        .fail(function(data) {
            $('.result').html(data);
        });
    });
});


$(document).ready(function(){
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
});
$('.modal').modal({
        dismissible: true, // Modal can be dismissed by clicking outside of the modal
        opacity: .5, // Opacity of modal background
        inDuration: 300, // Transition in duration
        outDuration: 200, // Transition out duration
        startingTop: '4%', // Starting top style attribute
        endingTop: '10%', // Ending top style attribute
        ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
            alert("Ready");
            console.log(modal, trigger);
        },
        complete: function() { alert('Closed'); } // Callback for Modal close
    }
);
