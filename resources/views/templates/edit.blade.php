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
                            <div class="col m12">
                                <h5 class="card-title">Edit Mail Template: {{ $template->mail_subject }}</h5>
                            </div>

                            <div class="input-field col m6 {{ $errors->has('mail_subject') ? 'has-error' : '' }}">
                                <input type="text" name="mail_subject" id="mail-subject" class="validate" placeholder="Mail Subject" value="{{ $template->mail_subject }}">
                                {!! $errors->has('mail_subject') ? $errors->first('mail_subject', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </div>

                            <div class="input-field col m6 {{ $errors->has('mail_title') ? 'has-error' : '' }}">
                                <input type="text" name="mail_title" id="mail-title" class="validate" placeholder="Mail Title" value="{{ $template->mail_title }}">
                                {!! $errors->has('mail_title') ? $errors->first('mail_title', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </div>

                            <div class="input-field col m12 {{ $errors->has('mail_tag') ? 'has-error' : '' }}">
                                <select name="mail_tag" title="Mail Tag">
                                    <option value="" disabled selected>Choose a Tag here</option>
                                    <option value="Personal" {{ $template->mail_tag == 'Personal' ? 'selected' : '' }}>Personal</option>
                                    <option value="Work" {{ $template->mail_tag == 'Work' ? 'selected' : '' }}>Work</option>
                                    <option value="Newsletter" {{ $template->mail_tag == 'Newsletter' ? 'selected' : '' }}>Newsletter</option>
                                </select>
                                {!! $errors->has('mail_tag') ? $errors->first('mail_tag', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </div>

                            <div class="input-field col m12 {{ $errors->has('mail_body_content') ? 'has-error' : '' }}">
                                <p>Mail Body:</p>
                                <textarea name="mail_body_content" id="mail-body-content" class="materialize-textarea editor" title="Mail Body">{{ $template->mail_body_content }}</textarea>
                                {!! $errors->has('mail_body_content') ? $errors->first('mail_body_content', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </div>

                            <p class="col m12 {{ $errors->has('mail_has_attachment') ? 'has-error' : '' }}">
                                <input type="checkbox" name="mail_has_attachment" id="mail-has-attachment" {{ $template->mail_has_attachment == 1 ? 'checked' : '' }} />
                                <label for="mail-has-attachment">Has Attachment</label>
                                {!! $errors->has('mail_has_attachment') ? $errors->first('mail_has_attachment', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                            </p>

                            <div id="attachment-section" class="col m12 {{ $template->mail_has_attachment == 0 ? 'hide' : '' }}">
                                <div class="row">
                                    <div class="input-field col m12 {{ $errors->has('mail_attachment_name') ? 'has-error' : '' }}">
                                        <p>Mail Attachment Name:</p>
                                        <input type="text" name="mail_attachment_name" id="mail-attachment-name" class="validate" placeholder="Mail Attachment File Name" value="{{ $template->mail_attachment_name }}">
                                        {!! $errors->has('mail_attachment_name') ? $errors->first('mail_attachment_name', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                                    </div>

                                    <div class="col m12">
                                        <p>Mail Variables:</p>
                                    </div>
                                    <div class="input-field col m10 {{ $errors->has('mail_attachment_file_variables') ? 'has-error' : '' }}">
                                        <div class="chips variables">Click the icon to add variables to be changed</div>
                                        <div class="chips values hide"></div>
                                        <input type="hidden" name="mail_attachment_file_variables" id="mail-attachment-file-variables" value="">
                                        <input type="hidden" name="mail_attachment_file_variable_values" id="mail-attachment-file-variable-values" value="">
                                        {!! $errors->has('mail_attachment_file_variables') ? $errors->first('mail_attachment_file_variables', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                                    </div>

                                    <div class="input-field col m2">
                                        <a class="btn btn-floating pulse tooltipped" data-tooltip="Add More Variables" id="add-variables"><i class="ti-plus"></i></a>
                                    </div>

                                    <div class="col m12 {{ $errors->has('mail_has_attachment_file') ? 'has-error' : '' }}">
                                        <p class="options">
                                            Attachment Is a file?
                                        </p>
                                        <p class="options">
                                            <input class="with-gap" name="mail_has_attachment_file" type="radio" id="mail-has-attachment-file2" value="1" {{ $template->mail_has_attachment_file == 1 ? 'checked' : '' }} />
                                            <label for="mail-has-attachment-file2">Yes</label>
                                        </p>
                                        <p class="options">
                                            <input class="with-gap" name="mail_has_attachment_file" type="radio" id="mail-has-attachment-file1" value="0" {{ $template->mail_has_attachment_file == 0 ? 'checked' : '' }} />
                                            <label for="mail-has-attachment-file1">No</label>
                                        </p>
                                        {!! $errors->has('mail_has_attachment_file') ? $errors->first('mail_has_attachment_file', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                                    </div>
                                </div>
                            </div>

                            <div id="attachment-file-section" class="col m12 {{ $template->mail_has_attachment_file == 0 ? 'hide' : '' }}">
                                <div class="row">
                                    <div class="file-field input-field col m12">
                                        <div class="btn">
                                            <span>Browse</span>
                                            <input type="file" name="mail_attachment_file_url">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text" placeholder="Click here to replace the old file...">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="attachment-content-section" class="col m12 {{ $template->mail_has_attachment_file == 1 ? 'hide' : '' }}">
                                <div class="row">
                                    <div class="input-field col m12 {{ $errors->has('mail_attachment_content') ? 'has-error' : '' }}">
                                        <p>Mail Attachment Content:</p>
                                        <textarea name="mail_attachment_content" id="mail-attachment-content" class="materialize-textarea editor" title="Mail Attachment Content">{{ $template->mail_attachment_content }}</textarea>
                                        {!! $errors->has('mail_attachment_content') ? $errors->first('mail_attachment_content', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col m12">
                                <button type="submit" class="waves-effect waves-light btn">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="modal-add-variables" class="modal">
            <div class="modal-content">
                <h4>Enter Variable</h4>
                <div class="input-field">
                    <label for="variable_name">Enter Variable Name</label>
                    <input id="variable_name" type="text">
                </div>
                <div class="input-field">
                    <select id="variable_value">
                        <option value="" disabled selected>Choose value</option>
                        <option value="mail_recipient_name">Recipient Full Name</option>
                        <option value="mail_recipient_title">Recipient Title</option>
                        <option value="mail_recipient_company_name">Company Name</option>
                        <option value="mail_recipient_company_position">Company Position</option>
                    </select>
                    <label for="variable_value">Select Value</label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
                <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat" id="select-variables">Add</a>
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
                    $('#attachment-name-section').removeClass('hide');
                } else {
                    $('#attachment-name-section').addClass('hide');
                }
            });

            $('input[name=mail_has_attachment_file]').on('change', function() {
                if ($(this).val() === '1') {
                    $('#attachment-content-section').addClass('hide');
                    $('#attachment-file-section').removeClass('hide');
                } else {
                    $('#attachment-file-section').addClass('hide');
                    $('#attachment-content-section').removeClass('hide');
                }
            });

            var $variableChip = $('.variables');
            var $valueChip = $('.values');
            var $modal = $('#modal-add-variables');

            var varData = '{!! json_encode($template->mail_attachment_file_variables) !!}';
            var valData = '{!! json_encode($template->mail_attachment_file_variable_values) !!}';

            if (varData !== '')
            {
                var varArray = [];

                $.each($.parseJSON(varData), function(key, value) {
                    varArray.push({tag: value});
                });

                $variableChip.material_chip({
                    data: varArray
                });
            }

            if (valData !== '')
            {
                var valArray = [];

                $.each($.parseJSON(valData), function(key, value) {
                    valArray.push({tag: value});
                });

                console.log(valArray);

                $valueChip.material_chip({
                    data: valArray
                });
            }

            $('#add-variables').on('click', function () {
                $modal.find('#variable_name').val('');
                $modal.find('#variable_value').val('');

                $modal.modal('open');
            });

            $('#select-variables').on('click', function () {
                var variable = $modal.find('#variable_name').val();
                var value = $modal.find('#variable_value').val();

                var variableData = $variableChip.material_chip('data');
                var valueData = $valueChip.material_chip('data');

                var variableArray = '';
                var valueArray = '';

                if (variableData === undefined)
                {
                    variableArray = [];
                } else {
                    variableArray = $.parseJSON(JSON.stringify(variableData));
                }

                if (valueData === undefined)
                {
                    valueArray = [];
                } else {
                    valueArray = $.parseJSON(JSON.stringify(valueData));
                }

                variableArray.push({"tag" : variable});
                valueArray.push({"tag" : value});

                $variableChip.material_chip({
                    data: variableArray
                });

                $valueChip.material_chip({
                    data: valueArray
                });

                $('input[name=mail_attachment_file_variables]').val(JSON.stringify(variableArray));
                $('input[name=mail_attachment_file_variable_values]').val(JSON.stringify(valueArray));
            });

            $variableChip.on('chip.add', function(){
                var data = $(this).material_chip('data');

                $('input[name=mail_attachment_file_variables]').val(JSON.stringify(data));
            });

            $variableChip.on('chip.delete', function () {
                var data = $(this).material_chip('data');

                $('input[name=mail_attachment_file_variables]').val(JSON.stringify(data));
            });
        });
    </script>
@endpush