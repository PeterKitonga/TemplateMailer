<?php

namespace App\Http\Controllers;

use App\MailRecipient;
use App\MailTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class DatatablesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fetchRecipients()
    {
        $user = Auth::user();

        $query = MailRecipient::query()->where('user_id', $user->id);

        return Datatables::of($query)
            ->editColumn('created_at', function ($recipient) {
                return Carbon::parse($recipient->created_at)->toFormattedDateString();
            })
            ->addColumn('actions', function ($recipient) {
                return '<a class="dropdown-button btn red" href="#" data-beloworigin="true" data-activates="actions'.$recipient->id.'">More</a>
                        <ul id="actions'.$recipient->id.'" class="dropdown-content">
                            <li><a href="#" data-link="'.route('recipients.update').'" class="edit-recipient">Edit</a></li>
                            <li class="divider"></li>
                            <li><a href="#" data-link="'.route('recipients.delete', [$recipient->id]).'" class="delete-confirm">Remove</a></li>
                        </ul>';
            })
            ->make(true);
    }

    public function fetchTemplates()
    {
        $user = Auth::user();

        $query = MailTemplate::query()->where('user_id', $user->id);

        return Datatables::of($query)
            ->editColumn('mail_body_content', function ($template) {
                return '<div class="chip blue-grey white-text preview" data-placement="top"><i class="ti-info-alt"></i> Preview</div>';
            })
            ->editColumn('created_at', function ($template) {
                return Carbon::parse($template->created_at)->toFormattedDateString();
            })
            ->addColumn('actions', function ($template) {
                return '<a class="dropdown-button btn red" href="#" data-beloworigin="true"  data-constrainwidth="true" data-activates="actions'.$template->id.'">More</a>
                        <ul id="actions'.$template->id.'" class="dropdown-content">
                            <li><a href="'.route('templates.schedules.create', [$template->id]).'">Schedule</a></li>
                            <li class="divider"></li>
                            <li><a href="'.route('templates.edit', [$template->id]).'">Edit</a></li>
                            <li class="divider"></li>
                            <li><a href="#" data-link="'.route('templates.delete', [$template->id]).'" class="delete-confirm">Remove</a></li>
                        </ul>';
            })
            ->make(true);
    }
}
