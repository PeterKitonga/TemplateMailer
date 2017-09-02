@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('jquery-datatables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('jquery-datatables/css/buttons.dataTables.min.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col m12">
            <div class="card-panel">
                <table class="highlight" id="recipients-table">
                    <thead>
                    <tr>
                        <th>Recipient Name</th>
                        <th>Recipient Email</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="modal-add-recipient" class="modal">
            <form id="add-recipient-form" action="" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-content">
                    <h5></h5>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="mail_recipient_name" id="mail-recipient-name" class="validate" placeholder="Recipient Name" value="{{ old('mail_recipient_name') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="mail_recipient_email" id="mail-recipient-email" class="validate" placeholder="Recipient Email" value="{{ old('mail_recipient_email') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
                    <button type="submit" class="modal-action waves-effect waves-green btn-flat">Add</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div id="modal-import-excel" class="modal">
            <form id="import-excel-form" action="" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-content">
                    <h5></h5>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Click to add...</span>
                            <input type="file" name="excel" required>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
                    <button type="submit" class="modal-action waves-effect waves-green btn-flat">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('jquery-datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('jquery-datatables/js/dataTables.buttons.min.js') }}"></script>
    <script>
        $(function () {
           appRender.initRecipients();
        });
    </script>
@endpush