$(function () {
    $(document).on('click', '#editA', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var order_id = $(this).data('id');
        $.post('/admin/orders/edit', {order_id: order_id}, function (data) {
            if (data.code == 200) {
                $("#optionFirstStatus").val(data.status_01.id);
                $("#order_id").val(order_id);
                $("#optionSecondStatus").val(data.status_02.id);
                $("#optionFirstStatus").text(data.status_01.name);
                $("#optionSecondStatus").text(data.status_02.name);
                $("#statusOrder option[value=optionFirstStatus]").attr('selected', 'selected');
                $('#editOrderModal').modal('show');
            } else {
                toastr.error(data.message);
            }
        }, 'json');
    });

    $('#form_edit_order').on('submit', function (e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var order_status_id = $('#statusOrder').val();
        var order_id = $('#order_id').val();

        console.log(order_id);

        e.preventDefault();
        $.ajax({
            url: '/admin/orders/update',
            type: 'PATCH',
            data: {
                order_status_id: order_status_id,
                order_id: order_id
            },
            dataType: 'json',
            success: function (data) {
                if (data.code == 200) {
                    $('#editOrderModal').modal('hide');
                    toastr.success(data.message);
                } else {
                    toastr.error(data.message);
                }
            },
        });
    });
});
