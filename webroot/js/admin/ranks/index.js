$(function () {
    $('#sortable-table').sortable({
        update: function () {
            var items = $('#sortable-table').sortable('toArray').join(',');
            $.ajax({
                url: '/admin_ajax/ranks/sort',
                type: "post",
                data: {items: items},
            }).done(function (response) {
            }).fail(function () {
            });
        }
    });
});
