$(document).ready(function() {
    $('#achievement table tr td a').click(function() {
        var subjectCode = $(this).data('subject');
        console.log(subjectCode);
        $.ajax({
            url: 'achievement.php',
            type: 'POST',
            dataType:"json",
            data:{
                'code':subjectCode
            }
        })
            .done(function(data) {
                $('#achievementData').empty();
                if (data.length==0){
                    console.log("データがありません");
                }else{
                    $('#achievementData').append('<table class="centered"></table>');
                    $('#achievementData table').append('<thead></thead>');
                    $('#achievementData thead').append('<tr><th>課題名称</th><th>点数</th></tr>');
                    $('#achievementData table').append('<tbody></tbody>');
                    console.log(data);
                    for (var i = 0; i < data.length; i++) {
                        $('#achievementData tbody').append('<tr><td>'+data[i].task_name+'</td><td>'+data[i].task_score+'</td></tr>');
                    }
                }
            })
            .fail(function(data) {
                $('.result').html(data);
            });
    });
});
//modal
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
