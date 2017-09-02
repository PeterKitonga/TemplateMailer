<?php

namespace App\Http\Controllers;

use App\MailRecipient;
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
                return '<a class="dropdown-button btn" href="#" data-beloworigin="true" data-activates="actions">Drop Me!</a>
                        <ul id="actions" class="dropdown-content">
                            <li><a href="#">one</a></li>
                            <li><a href="#">two</a></li>
                            <li class="divider"></li>
                            <li><a href="#">three</a></li>
                            <li><a href="#"><i class="material-icons">view_module</i>four</a></li>
                            <li><a href="#"><i class="material-icons">cloud</i>five</a></li>
                        </ul>';
            })
            ->make(true);
    }
}
