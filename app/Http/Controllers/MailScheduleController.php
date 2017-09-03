<?php

namespace App\Http\Controllers;

use App\MailRecipient;
use App\MailSchedule;
use App\MailTemplate;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MailScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('schedules.index');
    }

    public function create($templateId)
    {
        $template = MailTemplate::query()->findOrFail($templateId);

        return view('schedules.create', compact('template'));
    }

    public function store(Request $request, $templateId)
    {
        $this->validate($request, [
            'schedule_date' => 'required',
            'schedule_time' => 'required'
        ]);

        $schedule = new MailSchedule([
            'schedule_date' => Carbon::parse($request->get('schedule_date'))->format('Y-m-d'),
            'schedule_time' => Carbon::parse($request->get('schedule_time'))->format('H:i:s')
        ]);

        $user = User::query()->findOrFail($request->user()->id);
        $template = MailTemplate::query()->findOrFail($templateId);

        $schedule->user()->associate($user);
        $schedule->mailTemplate()->associate($template);
        $schedule->save();

        foreach (json_decode($request->get('recipients')) as $item)
        {
            $recipient = MailRecipient::query()->where('mail_recipient_email', $item->tag)->first();

            $schedule->mailRecipients()->attach($recipient->id, ['mail_template_id' => $templateId]);
        }

        $request->session()->flash('status', 'Successfully scheduled template: '.$template->mail_subject);

        return redirect('templates');
    }
}
