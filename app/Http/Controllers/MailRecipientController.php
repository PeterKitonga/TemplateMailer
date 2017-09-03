<?php

namespace App\Http\Controllers;

use App\MailRecipient;
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

    public function store(Request $request)
    {
        $this->validate($request, [
            'mail_recipient_name' => 'required',
            'mail_recipient_email' => 'required|email|max:255|unique:mail_recipients'
        ]);

        $recipient = new MailRecipient([
            'user_id' => $request->user()->id,
            'mail_recipient_name' => ucwords($request->get('mail_recipient_name')),
            'mail_recipient_email' => trim($request->get('mail_recipient_email'))
        ]);

        $recipient->save();

        $request->session()->flash('status', 'Successfully added recipient: '.$request->get('mail_recipient_name'));

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'mail_recipient_name' => 'required',
            'mail_recipient_email' => 'required'
        ]);

        $recipientId = $request->get('recipient_id');

        $recipient = MailRecipient::query()->findOrFail($recipientId);
        $recipient -> update([
            'mail_recipient_name' => ucwords($request->get('mail_recipient_name')),
            'mail_recipient_email' => trim($request->get('mail_recipient_email'))
        ]);

        $request->session()->flash('status', 'Successfully updated recipient: '.$request->get('mail_recipient_name'));

        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $recipient = MailRecipient::query()->findOrFail($id);
        $recipient -> forceDelete();

        $request->session()->flash('status', 'Successfully removed recipient: '.$request->get('mail_recipient_name'));

        return redirect()->back();
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'excel' => 'required'
        ]);

        $user = $request->user();
        $upload = $request->file('excel');

        $reader = ReaderFactory::create(Type::XLSX);
        $reader -> open($upload->getRealPath());
        $data = [];

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $pushArray['user_id'] = $user->id;
                $pushArray['mail_recipient_name'] = ucwords($row[0]);
                $pushArray['mail_recipient_email'] = trim($row[1]);
                $pushArray['created_at'] = Carbon::now()->toDateTimeString();
                $pushArray['updated_at'] = Carbon::now()->toDateTimeString();

                array_push($data, $pushArray);
            }
        }

        $reader->close();

        array_splice($data, 0, 1);

        DB::table('mail_recipients')->insert($data);

        $request->session()->flash('status', 'Successfully imported recipients from excel');

        return redirect()->back();
    }

    public function download()
    {
        return response()->download(storage_path('templates/recipient_template.xlsx'));
    }
}
