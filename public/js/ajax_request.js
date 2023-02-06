$(document).ready(function() {
    var defaultStartSelectOption = $('#start').val();
    $('#weekday').hide();
    $('#weekend').hide();

    $.ajax({
            type: 'get',
            url: 'checkTypeofDay',
            data: {'id': defaultStartSelectOption},
            success:function(data) {
                if(data == 0) {
                    $('#weekday').show();
                }
                else {
                    $('#weekend').show();
                }
            }
    });

    $(document).on('change', '#start', function() {
        var startSelectOption = $(this).val();

        $('#weekday').hide();
        $('#weekend').hide();

        $.ajax({
            type: 'get',
            url: 'checkTypeofDay',
            data: {'id': startSelectOption},
            success:function(data) {
                if(data == 0) {
                    $('#weekday').show();
                }
                else {
                    $('#weekend').show();
                }
            }
        });
    })
})