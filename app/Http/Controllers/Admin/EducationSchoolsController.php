<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EducationSchoolApply;

class EducationSchoolsController extends Controller
{
    public function easyEducation()
    {
        $applies = EducationSchoolApply::paginate(100);

        return view('admin.education_schools.easy_education.index', compact('applies'));
    }
}
