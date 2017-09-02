$(".button-collapse").sideNav();
$(".dropdown-button").dropdown({
    belowOrigin: true
});

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
                    text: '<i class="icon-login"></i> Excel Import',
                    action: function ( e, dt, node, config ) {
                        var url = '';
                        $("#import-excel-form").attr('action', url);
                        $("#modal-import-excel").modal('show');
                    }
                },
                {
                    text: '<i class="icon-logout"></i> Excel Export',
                    action: function ( e, dt, node, config ) {
                        window.location = '';
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
            ]
        });
    }
};