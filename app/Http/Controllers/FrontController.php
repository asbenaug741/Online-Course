<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscribeTransactionRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\SubscribeTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index(){

        $courses = Course::with('teacher','category','students')->orderbydesc('id')->get();
        return view('front.index', compact('courses'));
    }

    public function details(Course $course){
        return view('front.details',compact('course'));
    }

    public function category(Category $category){
        $courses = $category->courses()->get();
        return view('front.category', compact("courses"));
    }

    public function pricing(){
        return view('front.pricing');
    }

    public function checkout(){
        return view('front.checkout');
    }

    public function checkout_store(StoreSubscribeTransactionRequest $request){
        $user = Auth::user();

        if($user->hasActiveSubscription()){ //jika sudah berlangganan
            return redirect()->route('front.index');
        }

        DB::transaction(function () use ($user, $request) {

            $validated = $request->validated();
            
            if($request->hasFile('proof')){
                $proofPath = $request->file('proof')->store('proofs','public');
                $validated['proof'] = $proofPath;
            }
            
    
            $validated['user_id'] = $user->id; 
            $validated['total_amount'] = 490000;
            $validated['is_paid'] = false;

            $transaction = SubscribeTransaction::create($validated);
        });

        return redirect()->route('dashboard');
    }
    
    public function learning(Course $course, $courseVideoId){
        
        $user = Auth::user();
        if(!$user->hasActiveSubscription()){        //jika tidak aktif
            return redirect()->route('front.pricing');  //diarahkan ke halaman pricing
        }

        $video = $course->course_videos()->firstWhere('id', $courseVideoId);
        
        $user->courses()->syncWithoutDetaching($course->id);
    
        return view('front.learning',compact('course','video'));
    }   

}
