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
                <table class="highlight" id="templates-table">
                    <thead>
                    <tr>
                        <th>Mail Subject</th>
                        <th>Mail Title</th>
                        <th>Mail Body</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
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
           appRender.initTemplates();
        });
    </script>
@endpush