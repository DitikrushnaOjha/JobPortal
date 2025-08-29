<?php

namespace App\Http\Controllers;

use App\Models\Catagory;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //this shows the home page
    public function index(){

        $catagory=Catagory::where('status',1)
                            ->orderBy('name','desc')
                            ->take(6)->get();

       $featuredJob = Job::with('jobType')
                  ->where('isFeatured', 1)
                  ->orderby('created_at','desc')
                  ->take(6)
                  ->get();

        $latestJob = Job::with('jobType')
                  ->where('status', 1)
                  ->orderby('created_at', 'desc')
                  ->take(6)
                  ->get();

         return view('front.home',[
            'catagories' => $catagory,
            'featuredJobs' => $featuredJob,
            'latestJobs' => $latestJob
         ]);

    }


}
