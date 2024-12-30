$(() => {
    if ($('.dataTable').length) {
        $('.dataTable').each(function(index,item) {
            let table = $(item).DataTable();
            $(item).attr('data-table',table)
        });
    }
})