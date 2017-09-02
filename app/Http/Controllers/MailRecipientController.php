<?php

namespace App\Http\Controllers;

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MailRecipientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('recipients.index');
    }

    public function store()
    {
        return redirect()->back();
    }

    public function update()
    {
        return redirect()->back();
    }

    public function destroy()
    {
        return redirect()->back();
    }

    public function import(Request $request)
    {
        $user = $request->user();
        $upload = $request->file('excel');

        $reader = ReaderFactory::create(Type::XLSX);
        $reader -> open($upload->getRealPath());
        $data = [];

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $pushArray['user_id'] = $user->id;
                $pushArray['mail_recipient_name'] = $row[0];
                $pushArray['mail_recipient_email'] = $row[1];
                $pushArray['created_at'] = Carbon::now()->toDateTimeString();
                $pushArray['updated_at'] = Carbon::now()->toDateTimeString();

                array_push($data, $pushArray);
            }
        }

        $reader->close();

        array_splice($data, 0, 1);

        DB::table('mail_recipients')->insert($data);

        return redirect()->back();
    }

    public function download()
    {
        return response()->download(storage_path('templates/recipient_template.xlsx'));
    }
}
