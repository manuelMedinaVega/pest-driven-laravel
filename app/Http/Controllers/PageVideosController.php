<?php

namespace App\Http\Controllers;

use App\Models\Course;

class PageVideosController extends Controller
{
    public function __invoke(Course $course)
    {
        //$purchasedCourses = auth()->user()->courses;

        //return view('dashboard', compact('purchasedCourses'));
    }
}
