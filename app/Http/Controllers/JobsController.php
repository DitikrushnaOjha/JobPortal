<?php

namespace App\Http\Controllers;
use App\Models\Catagory;
use App\Models\JobType;
use App\Models\Job;

use Illuminate\Http\Request;

class JobsController extends Controller
{

    //this  shows the jobs page
        public function index(Request $request){

            $catagory = Catagory::where('status', 1)
                            ->get();

            $jobType=JobType::where('status',1)
                                ->get();

            $job=Job::where('status',1)
                        ->with('jobType')
                        ->orderBy('created_at','desc')
                        ->take(9)
                        ->get();


        //search using keyword
        $job = Job::query();

        if ($request->keyword != null) {

            $job->where('tittle', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%')
                ->orWhere('location', 'like', '%' . $request->keyword . '%');
        }

        $jobs = $job->get();





        return view('front.jobs',[
            'catagories'=>$catagory,
            'jobTypes'=>$jobType,
            'jobs'=>$job
        ]);
    }


}
