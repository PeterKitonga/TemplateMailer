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
        <div id="modal-add-recipient" class="modal modal-fixed-footer">
            <form id="add-recipient-form" action="" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-content">
                    <h5></h5>
                    <div class="row">
                        <div class="input-field col s12 {{ $errors->has('mail_recipient_name') ? 'has-error' : '' }}">
                            <input type="text" name="mail_recipient_name" id="mail-recipient-name" class="validate" placeholder="Recipient Name" value="{{ old('mail_recipient_name') }}" required>
                            {!! $errors->has('mail_recipient_name') ? $errors->first('mail_recipient_name', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 {{ $errors->has('mail_recipient_email') ? 'has-error' : '' }}">
                            <input type="text" name="mail_recipient_email" id="mail-recipient-email" class="validate" placeholder="Recipient Email" value="{{ old('mail_recipient_email') }}" required>
                            {!! $errors->has('mail_recipient_email') ? $errors->first('mail_recipient_email', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 {{ $errors->has('mail_recipient_gender') ? 'has-error' : '' }}">
                            <p class="options">
                                Gender?
                            </p>
                            <p class="options">
                                <input class="with-gap" name="mail_recipient_gender" type="radio" id="mail-recipient-gender1" value="1" />
                                <label for="mail-recipient-gender1">Female</label>
                            </p>
                            <p class="options">
                                <input class="with-gap" name="mail_recipient_gender" type="radio" id="mail-recipient-gender2" value="2" />
                                <label for="mail-recipient-gender2">Male</label>
                            </p>
                            {!! $errors->has('mail_recipient_gender') ? $errors->first('mail_recipient_gender', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 {{ $errors->has('mail_recipient_title') ? 'has-error' : '' }}">
                            <input type="text" name="mail_recipient_title" id="mail-recipient-title" class="validate" placeholder="Recipient Title e.g Mr. Smith" value="{{ old('mail_recipient_title') }}" required>
                            {!! $errors->has('mail_recipient_title') ? $errors->first('mail_recipient_title', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                    </div>
                    <div class="row">
                        <p class="col s12 {{ $errors->has('mail_recipient_is_business_owner') ? 'has-error' : '' }}">
                            <input type="checkbox" name="mail_recipient_is_business_owner" id="mail-recipient-is-business-owner" />
                            <label for="mail-recipient-is-business-owner">Is Business Owner/Company Employee?</label>
                            {!! $errors->has('mail_recipient_is_business_owner') ? $errors->first('mail_recipient_is_business_owner', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </p>
                    </div>
                    <div id="business-details-section" class="business-details-section hide">
                        <div class="row">
                            <div class="input-field col s6 {{ $errors->has('mail_recipient_company_name') ? 'has-error' : '' }}">
                                <input type="text" name="mail_recipient_company_name" id="mail-recipient-company-name" class="validate" placeholder="Recipient's Business/Company Name">
                                {!! $errors->has('mail_recipient_company_name') ? $errors->first('mail_recipient_company_name', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </div>
                            <div class="input-field col s6 {{ $errors->has('mail_recipient_company_position') ? 'has-error' : '' }}">
                                <input type="text" name="mail_recipient_company_position" id="mail-recipient-company-position" class="validate" placeholder="Recipient's Business/Company Position">
                                {!! $errors->has('mail_recipient_company_position') ? $errors->first('mail_recipient_company_position', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </div>
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
        <div id="modal-edit-recipient" class="modal modal-fixed-footer">
            <form id="edit-recipient-form" action="" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="recipient_id">
                <div class="modal-content">
                    <h5></h5>
                    <div class="row">
                        <div class="input-field col s12 {{ $errors->has('mail_recipient_name') ? 'has-error' : '' }}">
                            <input type="text" name="mail_recipient_name" id="mail-recipient-name" class="validate" placeholder="Recipient Name" value="{{ old('mail_recipient_name') }}" required>
                            {!! $errors->has('mail_recipient_name') ? $errors->first('mail_recipient_name', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 {{ $errors->has('mail_recipient_email') ? 'has-error' : '' }}">
                            <input type="text" name="mail_recipient_email" id="mail-recipient-email" class="validate" placeholder="Recipient Email" value="{{ old('mail_recipient_email') }}" required>
                            {!! $errors->has('mail_recipient_email') ? $errors->first('mail_recipient_email', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 {{ $errors->has('mail_recipient_gender') ? 'has-error' : '' }}">
                            <p class="options">
                                Gender?
                            </p>
                            <p class="options">
                                <input class="with-gap" name="mail_recipient_gender" type="radio" id="mail-recipient-gender3" value="1" />
                                <label for="mail-recipient-gender3">Female</label>
                            </p>
                            <p class="options">
                                <input class="with-gap" name="mail_recipient_gender" type="radio" id="mail-recipient-gender4" value="2" />
                                <label for="mail-recipient-gender4">Male</label>
                            </p>
                            {!! $errors->has('mail_recipient_gender') ? $errors->first('mail_recipient_gender', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 {{ $errors->has('mail_recipient_title') ? 'has-error' : '' }}">
                            <input type="text" name="mail_recipient_title" id="mail-recipient-title" class="validate" placeholder="Recipient Title e.g Mr. Smith" value="{{ old('mail_recipient_title') }}" required>
                            {!! $errors->has('mail_recipient_title') ? $errors->first('mail_recipient_title', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                    </div>
                    <div class="row">
                        <p class="col s12 {{ $errors->has('mail_recipient_is_business_owner') ? 'has-error' : '' }}">
                            <input type="checkbox" name="mail_recipient_is_business_owner" id="mail-recipient-is-business-owner-edit" />
                            <label for="mail-recipient-is-business-owner-edit">Is Business Owner/Company Employee?</label>
                            {!! $errors->has('mail_recipient_is_business_owner') ? $errors->first('mail_recipient_is_business_owner', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </p>
                    </div>
                    <div id="business-details-section" class="business-details-section hide">
                        <div class="row">
                            <div class="input-field col s6 {{ $errors->has('mail_recipient_company_name') ? 'has-error' : '' }}">
                                <input type="text" name="mail_recipient_company_name" id="mail-recipient-company-name" class="validate" placeholder="Recipient's Business/Company Name" value="{{ old('mail_recipient_company_name') }}">
                                {!! $errors->has('mail_recipient_company_name') ? $errors->first('mail_recipient_company_name', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </div>
                            <div class="input-field col s6 {{ $errors->has('mail_recipient_company_position') ? 'has-error' : '' }}">
                                <input type="text" name="mail_recipient_company_position" id="mail-recipient-company-position" class="validate" placeholder="Recipient's Business/Company Position" value="{{ old('mail_recipient_company_position') }}">
                                {!! $errors->has('mail_recipient_company_position') ? $errors->first('mail_recipient_company_position', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
                    <button type="submit" class="modal-action waves-effect waves-green btn-flat">Update</button>
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