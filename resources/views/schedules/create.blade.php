@extends('layouts.app')

@push('styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('jquery-datatables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('jquery-datatables/css/buttons.dataTables.min.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col m12">
            <div class="card-panel">
                <form action="{{ route('templates.schedules.store', [$template->id]) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="recipients">
                    <div class="row">
                        <div class="col m1 offset-m1"></div>
                        <div class="col m8">
                            <h5 class="card-title">Schedule Template: {{ $template->mail_subject }}</h5>
                        </div>
                        <div class="col m1 offset-m1"></div>
                    </div>

                    <div class="row">
                        <div class="col m1 offset-m1"></div>
                        <div class="input-field col m8 {{ $errors->has('schedule_date') ? 'has-error' : '' }}">
                            <input type="text" name="schedule_date" id="schedule-date" class="datepicker" placeholder="Schedule Date">
                            {!! $errors->has('schedule_date') ? $errors->first('schedule_date', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                        <div class="col m1 offset-m1"></div>
                    </div>

                    <div class="row">
                        <div class="col m1 offset-m1"></div>
                        <div class="input-field col m8 {{ $errors->has('schedule_time') ? 'has-error' : '' }}">
                            <input type="text" name="schedule_time" id="schedule-time" class="timepicker" placeholder="Schedule Time">
                            {!! $errors->has('schedule_time') ? $errors->first('schedule_time', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                        <div class="col m1 offset-m1"></div>
                    </div>

                    <div class="row">
                        <div class="col m1 offset-m1"></div>
                        <div class="col m8"><p>Enter recipient emails and hit "Enter" or click on icon</p></div>
                        <div class="col m1 offset-m1"></div>
                    </div>

                    <div class="row">
                        <div class="col m1 offset-m1"></div>
                        <div class="input-field col m8 {{ $errors->has('recipients') ? 'has-error' : '' }}">
                            <div class="chips chips-placeholder"></div>
                            {!! $errors->has('recipients') ? $errors->first('recipients', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                        <div class="input-field col m1">
                            <a class="btn btn-floating btn-large pulse tooltipped" data-tooltip="Select Recipients" data-placement="top" id="add-recipients"><i class="ti-plus"></i></a>
                        </div>
                        <div class="col m1 offset-m1"></div>
                    </div>

                    <div class="row">
                        <div class="col m1 offset-m1"></div>
                        <div class="col m8">
                            <button type="submit" class="waves-effect waves-light btn">Add</button>
                        </div>
                        <div class="col m1 offset-m1"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="modal-select-recipients" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h4>Select Recipients</h4>
                <table class="highlight" id="select-recipients-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="center-align"><p><input type="checkbox" name="select_all" id="select-all"/><label for="select-all"></label></p></th>
                            <th>Recipient Name</th>
                            <th>Recipient Email</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
                <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat" id="select-recipients">Add</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('jquery-datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('jquery-datatables/js/dataTables.buttons.min.js') }}"></script>
    <script>
        $(function () {
            $('.chips-placeholder').material_chip({
                placeholder: 'Recipients emails',
                secondaryPlaceholder: '+Emails'
            });

            $('.chips').on('chip.delete', function () {
                var data = $(this).material_chip('data');

                $('input[name=recipients]').val(JSON.stringify(data));
            });

            $('#add-recipients').on('click', function () {
                $('#modal-select-recipients').modal('open');
            });
            appRender.initScheduleTemplates();
        });
    </script>
@endpush