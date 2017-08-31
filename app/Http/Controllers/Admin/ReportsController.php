<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;

class ReportsController extends Controller
{
    //
    public function index()
    {
        $reports = Report::orderBy("id", "desc")->paginate(15);
        return view("admin.reports.index", ["reports" => $reports]);
    }
}
