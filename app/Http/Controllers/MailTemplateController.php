<?php

namespace App\Http\Controllers;

use App\MailTemplate;
use App\User;
use Illuminate\Http\Request;

class MailTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('templates.index');
    }

    public function create()
    {
        return view('templates.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'mail_subject' => 'required',
            'mail_body_content' => 'required',
            'mail_title' => 'required'
        ]);

        $mailVariables = $request->get('mail_attachment_file_variables') == null ? null : array_pluck(json_decode($request->get('mail_attachment_file_variables')), 'tag');
        $mailValues = $request->get('mail_attachment_file_variable_values') == null ? null : array_pluck(json_decode($request->get('mail_attachment_file_variable_values')), 'tag');

        $attachment = $request->file('mail_attachment_file_url');
        if ($attachment !== null)
        {
            $attachmentName = mt_rand(100000, 999999).'.'.$attachment->getClientOriginalExtension();
            $attachment->move(storage_path('templates'), $attachmentName);
            $attachmentPath = storage_path('templates/').$attachmentName;
        } else {
            $attachmentPath = null;
        }

        $user = User::query()->findOrFail($request->user()->id);

        $template = new MailTemplate([
            'mail_tag' => $request->get('mail_tag'),
            'mail_title' => trim($request->get('mail_title')),
            'mail_subject' => trim($request->get('mail_subject')),
            'mail_body_content' => $request->get('mail_body_content'),
            'mail_has_attachment' => $request->has('mail_has_attachment'),
            'mail_has_attachment_file' => $request->has('mail_has_attachment_file'),
            'mail_attachment_name' => trim($request->get('mail_attachment_name')),
            'mail_attachment_file_variables' => $mailVariables,
            'mail_attachment_file_variable_values' => $mailValues,
            'mail_attachment_file_url' => $attachmentPath,
            'mail_attachment_content' => $request->get('mail_attachment_content')
        ]);
        $template->user()->associate($user);
        $template->save();

        $request->session()->flash('status', 'Successfully added template: '.$request->get('mail_subject'));

        return redirect('templates');
    }

    public function edit($id)
    {
        $template = MailTemplate::query()->findOrFail($id);

        return view('templates.edit', compact('template'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'mail_subject' => 'required',
            'mail_body_content' => 'required',
            'mail_title' => 'required'
        ]);

        $templateId = $request->get('template_id');

        $mailVariables = $request->get('mail_attachment_file_variables') == null ? null : array_pluck(json_decode($request->get('mail_attachment_file_variables')), 'tag');
        $mailValues = $request->get('mail_attachment_file_variable_values') == null ? null : array_pluck(json_decode($request->get('mail_attachment_file_variable_values')), 'tag');

        $attachment = $request->file('mail_attachment_file_url');
        if ($attachment !== null)
        {
            $attachmentName = mt_rand(100000, 999999).'.'.$attachment->getClientOriginalExtension();
            $attachment->move(storage_path('templates'), $attachmentName);
            $attachmentPath = storage_path('templates/').$attachmentName;
        } else {
            $attachmentPath = null;
        }

        $template = MailTemplate::query()->findOrFail($templateId);
        $template->update([
            'mail_tag' => $request->get('mail_tag'),
            'mail_title' => trim($request->get('mail_title')),
            'mail_subject' => trim($request->get('mail_subject')),
            'mail_body_content' => $request->get('mail_body_content'),
            'mail_has_attachment' => $request->has('mail_has_attachment'),
            'mail_attachment_name' => trim($request->get('mail_attachment_name')),
            'mail_attachment_file_variables' => $mailVariables,
            'mail_attachment_file_variable_values' => $mailValues,
            'mail_attachment_file_url' => $attachmentPath,
            'mail_attachment_content' => $request->get('mail_attachment_content')
        ]);

        $request->session()->flash('status', 'Successfully updated template: '.$request->get('mail_subject'));

        return redirect('templates');
    }

    public function destroy(Request $request, $templateId)
    {
        $template = MailTemplate::query()->findOrFail($templateId);
        $template -> forceDelete();

        $request->session()->flash('status', 'Successfully removed template: '.$template->mail_subject);

        return redirect('templates');
    }

    public function getContent($templateId)
    {
        $template = MailTemplate::query()->findOrFail($templateId);

        return response()->json(['content' => $template->mail_body_content]);
    }
}
