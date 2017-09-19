if (jQuery().datepicker) {
    $('.datepicker-day').datepicker({
        format: "dd.mm.yyyy",
        language: "ru",
        multidate: false,
        autoclose: true
    });

    $('.datepicker-month').datepicker({
        format: "dd.mm.yyyy",
        language: "ru",
        multidate: false,
        autoclose: true,
        minViewMode: 1
    });

    $('.datepicker-year').datepicker({
        format: "dd.mm.yyyy",
        language: "ru",
        multidate: false,
        autoclose: true,
        minViewMode: 2
    });
}

if (jQuery().datetimepicker) {
    $('.datetimepicker').datetimepicker({
        format: "dd.mm.yyyy hh:ii:ss",
        language: "ru",
        multidate: false,
        autoclose: true,
        minViewMode: 1
    });
}
