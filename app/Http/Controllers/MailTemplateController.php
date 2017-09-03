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

        $user = User::query()->findOrFail($request->user()->id);

        $template = new MailTemplate($request->all());
        $template->user()->associate($user);
        $template->save();

        $request->session()->flash('status', 'Successfully added template: '.$request->get('mail_subject'));

        return redirect('templates');
    }

    public function edit()
    {
        return view('templates.edit');
    }

    public function getContent($templateId)
    {
        $template = MailTemplate::query()->findOrFail($templateId);

        return response()->json(['content' => $template->mail_body_content]);
    }
}
