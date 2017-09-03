jQuery.each(["put", "delete"], function(i, method) {
    jQuery[method] = function(url, data, callback, type) {
        if (jQuery.isFunction(data)) {
            type = type || callback;
            callback = data;
            data = undefined;
        }

        return jQuery.ajax({
            url: url,
            type: method,
            dataType: type,
            data: data,
            success: callback
        });
    };
});
$(".button-collapse").sideNav();
$(".dropdown-button").dropdown({
    belowOrigin: true
});
$('select').material_select();
$('.modal').modal();

appRender = {
    initRecipients: function() {
        $('#recipients-table').DataTable({
            serverSide: true,
            ajax: '/datatables/fetch/recipients',
            order: [[2, 'desc']],
            dom: 'Brtip',
            buttons: [
                {extend: 'pageLength'},
                {
                    text: '<i class="ti-plus"></i> Add Recipient',
                    className: 'modal-trigger',
                    action: function (e, dt, node, config) {
                        var url = '/recipients/store';
                        var $modal = $("#modal-add-recipient");
                        $modal.find("#add-recipient-form").attr('action', url);
                        $modal.find('h5').html('Add Recipient');
                        $modal.modal('open');
                    }
                },
                {
                    text: '<i class="ti-upload"></i> Excel Import',
                    className: 'modal-trigger',
                    action: function (e, dt, node, config) {
                        var url = '/recipients/import';
                        var $modal = $("#modal-import-excel");
                        $modal.find("#import-excel-form").attr('action', url);
                        $modal.find('h5').html('Recipients Excel Import'+'<a class="btn red right" href="/recipients/download/template">Download Template</a>');
                        $modal.modal('open');
                    }
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                ['10', '25', '50', 'Show all']
            ],
            columns : [
                {data:'mail_recipient_name', name:'mail_recipient_name'},
                {data:'mail_recipient_email', name:'mail_recipient_email'},
                {data:'created_at', name:'created_at'},
                {data:'actions', name:'actions', orderable: false, searchable:false}
            ],
            drawCallback: function(settings) {
                // Access Datatables API methods
                var $api = new $.fn.dataTable.Api(settings);

                $(".dropdown-button").dropdown({
                    belowOrigin: true
                });

                $('.edit-recipient').on('click', function () {
                    var row = $api.row($(this).closest('tr')).data();
                    var $modal = $('#modal-edit-recipient');

                    $modal.find('h5').html('Edit Recipient: '+row.mail_recipient_name);
                    $modal.find("#edit-recipient-form").attr('action', '/recipients/update');
                    $modal.find('input[name=recipient_id]').val(row.id);
                    $modal.find('input[name=mail_recipient_name]').val(row.mail_recipient_name);
                    $modal.find('input[name=mail_recipient_email]').val(row.mail_recipient_email);
                    $modal.modal('open');
                });

                $('.delete-confirm').on('click', function () {
                    var url = $(this).attr('data-link');
                    var row = $api.row($(this).closest('tr')).data();
                    var $modal = $('#modal-delete-confirm');

                    $modal.find('h5').html('Remove Recipient: '+row.mail_recipient_name);
                    $modal.find("#delete-confirm-form").attr('action', url);
                    $modal.modal('open');
                });
            }
        });
    },
    initTemplates: function() {
        $('#templates-table').DataTable({
            serverSide: true,
            ajax: '/datatables/fetch/templates',
            order: [[3, 'desc']],
            dom: 'Brtip',
            buttons: [
                {extend: 'pageLength'},
                {
                    text: '<i class="ti-plus"></i> Add Template',
                    className: 'modal-trigger',
                    action: function (e, dt, node, config) {
                        window.location = '/templates/create';
                    }
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                ['10', '25', '50', 'Show all']
            ],
            columns : [
                {data:'mail_subject', name:'mail_subject'},
                {data:'mail_title', name:'mail_title'},
                {data:'mail_body_content', name:'mail_body_content'},
                {data:'created_at', name:'created_at'},
                {data:'actions', name:'actions', orderable: false, searchable:false}
            ],
            drawCallback: function(settings) {
                // Access Datatables API methods
                var $api = new $.fn.dataTable.Api(settings);

                $(".dropdown-button").dropdown({
                    belowOrigin: true
                });

                $('.delete-confirm').on('click', function () {
                    var url = $(this).attr('data-link');
                    var row = $api.row($(this).closest('tr')).data();
                    var $modal = $('#modal-delete-confirm');

                    $modal.find('h5').html('Remove Recipient: '+row.mail_subject);
                    $modal.find("#delete-confirm-form").attr('action', url);
                    $modal.modal('open');
                });
            }
        });
    }
};