<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;

class FeedbacksController extends Controller
{
    //
    public function index()
    {
        // code...
        $feedbacks = Feedback::orderBy("id", "desc")->paginate(15);
        return view('admin.feedbacks.index', ["feedbacks" => $feedbacks]);
    }
}
