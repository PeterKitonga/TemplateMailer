<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
