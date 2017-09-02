$(".button-collapse").sideNav();
$(".dropdown-button").dropdown({
    belowOrigin: true
});
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
            drawCallback: function() {
                $(".dropdown-button").dropdown({
                    belowOrigin: true
                });
            }
        });
    }
};