<?php

namespace App\Http\Controllers;

use App\MailLog;
use App\MailRecipient;
use App\MailTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $countLogs = MailLog::query()->where('user_id', $user->id)->where('status', '=', 'Sent')->count();
        $countTemplates = MailTemplate::query()->where('user_id', $user->id)->count();
        $countRecipients = MailRecipient::query()->where('user_id', $user->id)->count();
        $graphData = self::getGraphData();

        return view('home', compact('countLogs', 'countTemplates', 'countRecipients', 'graphData'));
    }

    public function getGraphData()
    {
        $data = MailLog::query()
            ->select(DB::raw('COUNT(IF(status = \'Sent\', 1, NULL)) as successful'), DB::raw('COUNT(IF(status = \'Failed\', 1, NULL)) as failed'), DB::raw('DATE_FORMAT(created_at, \'%b\') as month'))
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->get();

        if ($data)
        {
            $response['successful'] = array_pluck($data,'successful');
            $response['failed'] = array_pluck($data,'failed');
            $response['months'] = array_pluck($data,'month');
        } else {
            $response['successful'] = [0];
            $response['failed'] = [0];
            $response['months'] = [0];
        }

        return json_encode($response);
    }
}
