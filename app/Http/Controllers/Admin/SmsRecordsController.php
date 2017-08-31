<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsRecord;

class SmsRecordsController extends Controller
{
    public function index()
    {
        $records = SmsRecord::orderBy("id", "desc")->paginate(15);
        return view("admin.sms_records.index", ["records" => $records]);
    }
}
