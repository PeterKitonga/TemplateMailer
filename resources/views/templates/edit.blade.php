@extends('layouts.app')

@push('styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col m12">
                <div class="card-panel">
                    <form action="{{ route('templates.update') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="template_id" value="{{ $template->id }}">

                        <div class="row">
                            <div class="col m1 offset-m1"></div>
                            <div class="col m8">
                                <h5 class="card-title">Edit Mail Template: {{ $template->mail_subject }}</h5>
                            </div>
                            <div class="col m1 offset-m1"></div>
                        </div>

                        <div class="row">
                            <div class="col m1 offset-m1"></div>
                            <div class="input-field col m8 {{ $errors->has('mail_subject') ? 'has-error' : '' }}">
                                <input type="text" name="mail_subject" id="mail-subject" class="validate" placeholder="Mail Subject" value="{{ $template->mail_subject }}">
                                {!! $errors->has('mail_subject') ? $errors->first('mail_subject', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </div>
                            <div class="col m1 offset-m1"></div>
                        </div>

                        <div class="row">
                            <div class="col m1 offset-m1"></div>
                            <div class="input-field col m8 {{ $errors->has('mail_title') ? 'has-error' : '' }}">
                                <input type="text" name="mail_title" id="mail-title" class="validate" placeholder="Mail Title" value="{{ $template->mail_title }}">
                                {!! $errors->has('mail_title') ? $errors->first('mail_title', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </div>
                            <div class="col m1 offset-m1"></div>
                        </div>

                        <div class="row">
                            <div class="col m1 offset-m1"></div>
                            <div class="input-field col m8 {{ $errors->has('mail_tag') ? 'has-error' : '' }}">
                                <select name="mail_tag" title="Mail Tag">
                                    <option value="" disabled selected>Choose a Tag here</option>
                                    <option value="Personal" {{ $template->mail_tag == 'Personal' ? 'selected' : '' }}>Personal</option>
                                    <option value="Work" {{ $template->mail_tag == 'Work' ? 'selected' : '' }}>Work</option>
                                    <option value="Newsletter" {{ $template->mail_tag == 'Newsletter' ? 'selected' : '' }}>Newsletter</option>
                                </select>
                                {!! $errors->has('mail_tag') ? $errors->first('mail_tag', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </div>
                            <div class="col m1 offset-m1"></div>
                        </div>

                        <div class="row">
                            <div class="col m1 offset-m1"></div>
                            <div class="input-field col m8 {{ $errors->has('mail_body_content') ? 'has-error' : '' }}">
                                <p>Mail Body:</p>
                                <textarea name="mail_body_content" id="mail-body-content" class="materialize-textarea editor">{{ $template->mail_body_content }}</textarea>
                                {!! $errors->has('mail_body_content') ? $errors->first('mail_body_content', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </div>
                            <div class="col m1 offset-m1"></div>
                        </div>

                        <div class="row">
                            <div class="col m1 offset-m1"></div>
                            <p class="col m8 {{ $errors->has('mail_has_attachment') ? 'has-error' : '' }}">
                                <input type="checkbox" name="mail_has_attachment" id="mail-has-attachment" {{ $template->mail_has_attachment == 1 ? 'checked' : '' }} />
                                <label for="mail-has-attachment">Has Attachment</label>
                                {!! $errors->has('mail_has_attachment') ? $errors->first('mail_has_attachment', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </p>
                            <div class="col m1 offset-m1"></div>
                        </div>

                        <div id="attachment-section" class="{{ $template->mail_has_attachment == 0 ? 'hide' : '' }}">
                            <div class="row">
                                <div class="col m1 offset-m1"></div>
                                <div class="input-field col m8 {{ $errors->has('mail_attachment_name') ? 'has-error' : '' }}">
                                    <input type="text" name="mail_attachment_name" id="mail-attachment-name" class="validate" placeholder="Mail Attachment File Name" value="{{ $template->mail_attachment_name }}">
                                    {!! $errors->has('mail_attachment_name') ? $errors->first('mail_attachment_name', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                                </div>
                                <div class="col m1 offset-m1"></div>
                            </div>

                            <div class="row">
                                <div class="col m1 offset-m1"></div>
                                <div class="input-field col m8 {{ $errors->has('mail_attachment_content') ? 'has-error' : '' }}">
                                    <p>Mail Attachment Content:</p>
                                    <textarea name="mail_attachment_content" id="mail-attachment-content" class="materialize-textarea editor">{{ $template->mail_attachment_content }}</textarea>
                                    {!! $errors->has('mail_attachment_content') ? $errors->first('mail_attachment_content', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                                </div>
                                <div class="col m1 offset-m1"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col m1 offset-m1"></div>
                            <div class="col m8">
                                <button type="submit" class="waves-effect waves-light btn">Update</button>
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
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('ckeditor/adapters/jquery.js') }}"></script>
    <script>
        $(function () {
            $('textarea.editor').ckeditor({
                language: 'en',
                uiColor: '#FFFFFF',
                toolbarCanCollapse: true,
                toolbarGroups: [
                    '/',
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                    { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                    { name: 'links', groups: [ 'links' ] },
                    { name: 'insert', groups: [ 'insert' ] },
                    { name: 'forms', groups: [ 'forms' ] },
                    { name: 'tools', groups: [ 'tools' ] },
                    { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                    { name: 'others', groups: [ 'others' ] },
                    { name: 'styles', groups: [ 'styles' ] },
                    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                    { name: 'colors', groups: [ 'colors' ] },
                    { name: 'about', groups: [ 'about' ] }
                ],
                removeButtons: 'Underline,Subscript,Superscript,About,Source'
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