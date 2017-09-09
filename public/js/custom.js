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
    belowOrigin: true,
    constrainWidth: false
});
$('select').material_select();
$('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15, // Creates a dropdown of 15 years to control year,
    today: 'Today',
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: true // Close upon selecting a date,
});
$('.timepicker').pickatime({
    default: 'now', // Set default time: 'now', '1:30AM', '16:30'
    fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
    twelvehour: true, // Use AM/PM or 24-hour format
    donetext: 'OK', // text for done-button
    cleartext: 'Clear', // text for clear-button
    canceltext: 'Cancel', // Text for cancel-button
    autoclose: false, // automatic close timepicker
    ampmclickable: true, // make AM PM clickable
    aftershow: function(){} //Function for after opening timepicker
});
$('.modal').modal();

appRender = {
    initRecipients: function() {
        $('#recipients-table').DataTable({
            serverSide: true,
            ajax: '/datatables/fetch/recipients',
            order: [[3, 'desc']],
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
                {data:'gender_name', name:'mail_recipient_gender', searchable:false, defaultContent: '<i>Not Found</i>'},
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
                    console.log(row);

                    $modal.find('h5').html('Edit Recipient: ' + row.mail_recipient_name);
                    $modal.find("#edit-recipient-form").attr('action', '/recipients/update');
                    $modal.find('input[name=recipient_id]').val(row.id);
                    $modal.find('input[name=mail_recipient_name]').val(row.mail_recipient_name);
                    $modal.find('input[name=mail_recipient_email]').val(row.mail_recipient_email);
                    if (row.mail_recipient_gender === 1){
                        $modal.find('input[id=mail-recipient-gender3]').attr('checked', true);
                    } else if (row.mail_recipient_gender === 2) {
                        $modal.find('input[id=mail-recipient-gender4]').attr('checked', true);
                    } else {
                        $modal.find('input[name=mail_recipient_gender]').removeAttr('checked');
                    }
                    $modal.find('input[name=mail_recipient_title]').val(row.mail_recipient_title);
                    if (row.mail_recipient_is_business_owner === 1) {
                        $modal.find('input[name=mail_recipient_is_business_owner]').attr('checked', true);
                        $modal.find('#business-details-section').removeClass('hide');
                        $modal.find('input[name=mail_recipient_company_name]').val(row.mail_recipient_company_name);
                        $modal.find('input[name=mail_recipient_company_position]').val(row.mail_recipient_company_position);
                    } else {
                        $modal.find('input[name=mail_recipient_is_business_owner]').attr('checked', false);
                        $modal.find('#business-details-section').addClass('hide');
                        $modal.find('input[name=mail_recipient_company_name]').val(row.mail_recipient_company_name);
                        $modal.find('input[name=mail_recipient_company_position]').val(row.mail_recipient_company_position);
                    }
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

        $('input[name=mail_recipient_is_business_owner]').on('change', function() {
            if ($(this).is(':checked')) {
                $('.business-details-section').removeClass('hide');
            } else {
                $('.business-details-section').addClass('hide');
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
                    var $modal = $('#modal-delete-confirm');
                    var row = $api.row($(this).closest('tr')).data();

                    $modal.find('h5').html('Remove Recipient: '+row.mail_subject);
                    $modal.find("#delete-confirm-form").attr('action', url);
                    $modal.modal('open');
                });

                $('.chip').on('click', function () {
                    var row = $api.row($(this).closest('tr')).data();
                    var $modal = $('#modal-show-content');

                    $modal.find('h5').html('View Body for: '+row.mail_subject);
                    $.get('/templates/get/'+row.id+'/body', function (data) {
                        $modal.find('#mail-content').html(data.content);
                    });
                    $modal.modal('open');
                });
            }
        });
    },
    initScheduleTemplates: function() {
        var rows_selected = [];

        function updateDataTableSelectAllCtrl(table){
            var $table             = table.table().node();
            var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
            var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
            var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

            // If none of the checkboxes are checked
            if($chkbox_checked.length === 0){
                chkbox_select_all.checked = false;
                if('indeterminate' in chkbox_select_all){
                    chkbox_select_all.indeterminate = false;
                }

                // If all of the checkboxes are checked
            } else if ($chkbox_checked.length === $chkbox_all.length){
                chkbox_select_all.checked = true;
                if('indeterminate' in chkbox_select_all){
                    chkbox_select_all.indeterminate = false;
                }

                // If some of the checkboxes are checked
            } else {
                chkbox_select_all.checked = true;
                if('indeterminate' in chkbox_select_all){
                    chkbox_select_all.indeterminate = true;
                }
            }
        }

        var table = $('#select-recipients-table').DataTable({
            serverSide: true,
            ajax: '/datatables/fetch/recipients',
            order: [[2, 'desc']],
            dom: 'Brtip',
            buttons: [
                {extend: 'pageLength'}
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                ['10', '25', '50', 'Show all']
            ],
            columns : [
                {data:'', name:''},
                {data:'mail_recipient_name', name:'mail_recipient_name'},
                {data:'mail_recipient_email', name:'mail_recipient_email'}
            ],
            columnDefs: [{
                'targets': 0,
                'searchable': false,
                'orderable': false,
                'width': '1%',
                'className': 'dt-body-center',
                'render': function (data, type, full, meta){
                    return '<p><input type="checkbox" id="row-select'+full.id+'" name="recipients_selected[]" value="'+full.mail_recipient_email+'"/><label for="row-select'+full.id+'"></label></p>';
                }
            }],
            drawCallback: function(settings) {
                // Access Datatables API methods
                var $api = new $.fn.dataTable.Api(settings);

                $('#select-all').on('click', function(){
                    // Get all rows with search applied
                    var rows = $api.rows({'search': 'applied'}).nodes();

                    // Check/uncheck checkboxes for all rows in the table
                    $('input[type="checkbox"]', rows).prop('checked', this.checked);
                });

                // Handle click on checkbox to set state of "Select all" control
                $('input[type="checkbox"]').on('change', function() {
                    // If checkbox is not checked
                    if(!this.checked){
                        var el = $('#select-all').get(0);

                        // If "Select all" control is checked and has 'indeterminate' property
                        if(el && el.checked && ('indeterminate' in el)){
                            // Set visual state of "Select all" control
                            // as 'indeterminate'
                            el.indeterminate = true;
                        }
                    }
                });
            }
        });

        $('#select-recipients').click(function(){
            var checked_recipients = table.$('input[name="recipients_selected[]"]:checked').serializeArray();

            if(checked_recipients !== "") {
                var data = [];

                $.each(checked_recipients, function(key, value) {
                    data.push({tag: value.value});
                });

                $('.chips-placeholder').material_chip({
                    secondaryPlaceholder: '+Emails',
                    data: data
                });
                $('input[name=recipients]').val(JSON.stringify(data));
            } else {
                Materialize.toast('Select at least one recipient', 10000);
            }
        });
    }
};