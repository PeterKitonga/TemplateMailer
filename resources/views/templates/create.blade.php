@extends('layouts.app')

@push('styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('materialnote/css/materialnote.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col m12">
            <div class="card-panel">
                <form action="{{ route('templates.store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col m1 offset-m1"></div>
                        <div class="col m8">
                            <h5 class="card-title">Add Mail Template</h5>
                        </div>
                        <div class="col m1 offset-m1"></div>
                    </div>

                    <div class="row">
                        <div class="col m1 offset-m1"></div>
                        <div class="input-field col m8 {{ $errors->has('mail_subject') ? 'has-error' : '' }}">
                            <input type="text" name="mail_subject" id="mail-subject" class="validate" placeholder="Mail Subject">
                            {!! $errors->has('mail_subject') ? $errors->first('mail_subject', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                        <div class="col m1 offset-m1"></div>
                    </div>

                    <div class="row">
                        <div class="col m1 offset-m1"></div>
                        <div class="input-field col m8 {{ $errors->has('mail_title') ? 'has-error' : '' }}">
                            <input type="text" name="mail_title" id="mail-title" class="validate" placeholder="Mail Title">
                            {!! $errors->has('mail_title') ? $errors->first('mail_title', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                        <div class="col m1 offset-m1"></div>
                    </div>

                    <div class="row">
                        <div class="col m1 offset-m1"></div>
                        <div class="input-field col m8 {{ $errors->has('mail_tag') ? 'has-error' : '' }}">
                            <select name="mail_tag" title="Mail Tag">
                                <option value="" disabled selected>Choose a Tag here</option>
                                <option value="Personal">Personal</option>
                                <option value="Work">Work</option>
                                <option value="Newsletter">Newsletter</option>
                            </select>
                            {!! $errors->has('mail_tag') ? $errors->first('mail_tag', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                        <div class="col m1 offset-m1"></div>
                    </div>

                    <div class="row">
                        <div class="col m1 offset-m1"></div>
                        <div class="input-field col m8 {{ $errors->has('mail_body_content') ? 'has-error' : '' }}">
                            <textarea name="mail_body_content" id="mail-body-content" class="materialize-textarea"></textarea>
                            {!! $errors->has('mail_body_content') ? $errors->first('mail_body_content', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </div>
                        <div class="col m1 offset-m1"></div>
                    </div>

                    <div class="row">
                        <div class="col m1 offset-m1"></div>
                        <p class="col m8 {{ $errors->has('mail_has_attachment') ? 'has-error' : '' }}">
                            <input type="checkbox" name="mail_has_attachment" id="mail-has-attachment" />
                            <label for="mail-has-attachment">Has Attachment</label>
                            {!! $errors->has('mail_has_attachment') ? $errors->first('mail_has_attachment', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                        </p>
                        <div class="col m1 offset-m1"></div>
                    </div>

                    <div id="attachment-section" class="hide">
                        <div class="row">
                            <div class="col m1 offset-m1"></div>
                            <div class="input-field col m8 {{ $errors->has('mail_attachment_name') ? 'has-error' : '' }}">
                                <input type="text" name="mail_attachment_name" id="mail-attachment-name" class="validate" placeholder="Mail Attachment File Name">
                                {!! $errors->has('mail_attachment_name') ? $errors->first('mail_attachment_name', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </div>
                            <div class="col m1 offset-m1"></div>
                        </div>

                        <div class="row">
                            <div class="col m1 offset-m1"></div>
                            <div class="input-field col m8 {{ $errors->has('mail_attachment_content') ? 'has-error' : '' }}">
                                <textarea name="mail_attachment_content" id="mail-attachment-content" class="materialize-textarea"></textarea>
                                {!! $errors->has('mail_attachment_content') ? $errors->first('mail_attachment_content', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </div>
                            <div class="col m1 offset-m1"></div>
                        </div>
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
</div>
@endsection

@push('scripts')
    <script src="{{ asset('materialnote/js/materialnote.js') }}"></script>
    <script>
        $(function () {
            $('#mail-body-content').materialnote({
                height: 200,
                placeholder: 'Mail body content goes here...'
            });

            $('#mail-attachment-content').materialnote({
                height: 200,
                placeholder: 'Mail attachment content goes here...'
            });

            $('#mail-has-attachment').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#attachment-section').removeClass('hide');
                } else {
                    $('#attachment-section').addClass('hide');
                }
            });
        });
    </script>
@endpush