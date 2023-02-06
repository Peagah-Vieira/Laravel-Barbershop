$(document).ready(function () {
    var defaultStartSelectOption = $("#start").val();
    $("#startTimeDiv").hide();

    var weekdayTimePeriod = [
        "08:00",
        "09:00",
        "10:00",
        "11:00",
        "12:00",
        "13:00",
        "14:00",
        "15:00",
        "16:00",
        "17:00",
        "18:00",
    ];

    var weekendTimePeriod = [
        "08:00",
        "09:00",
        "10:00",
        "11:00",
        "12:00",
        "13:00",
        "14:00",
        "15:00",
        "16:00",
    ];

    $.ajax({
        type: "get",
        url: "checkTypeofDay",
        data: { id: defaultStartSelectOption },
        success: function (data) {
            if (data == 0) {
                $("#startTime").empty();
                $.each(weekdayTimePeriod, function (index, value) {
                    $("#startTime").append($("<option />").text(value));
                });

                $("#startTimeDiv").show();
            } else {
                $.each(weekendTimePeriod, function (index, value) {
                    $("#startTime").append($("<option />").text(value));
                });

                $("#startTimeDiv").show();
            }
        },
    });

    $(document).on("change", "#start", function () {
        var startSelectOption = $(this).val();

        $("#startTimeDiv").hide();

        $.ajax({
            type: "get",
            url: "checkTypeofDay",
            data: { id: startSelectOption },
            success: function (data) {
                if (data == 0) {
                    $("#startTime").empty();
                    $.each(weekdayTimePeriod, function (index, value) {
                        $("#startTime").append($("<option />").text(value));
                    });

                    $("#startTimeDiv").show();
                } else {
                    $("#startTime").empty();
                    $.each(weekendTimePeriod, function (index, value) {
                        $("#startTime").append($("<option />").text(value));
                    });

                    $("#startTimeDiv").show();
                }
            },
        });
    });
});
