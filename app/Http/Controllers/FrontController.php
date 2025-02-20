<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){

        $courses = Course::with('teacher','category','students')->orderbydesc('id')->get();
        return view('front.index', compact('courses'));
    }

    public function details(Course $course){
        return view('front.details',compact('course'));
    }

    public function learning(Course $course, $courseVideoId){
        
    }
}
