<?php


namespace App\Http\Controllers;

use App\Models\Catagory;
use App\Models\Job;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class AccountController extends Controller
{
    // Show user registration page
    public function registration()
    {
        return view('front.account.registration');
    }

    // Save a new user (Registration)
    public function processRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|confirmed',
        ]);

        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash("success", "You have registered successfully");

            return response()->json(['status' => true, 'errors' => []]);
        } else {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
    }

    //Show login page
    public function login()
    {
        return view('front.account.login');
    }


    // Process login (authenticate user)
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:5',
        ]);

        if ($validator->passes()) {

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $request->session()->regenerate(); // prevent session fixation
                return redirect()->route('account.profile')->with('success', 'Welcome back ' . Auth::user()->name . '!');
            } else {
                return redirect()->route('account.login')
                    ->with('error', 'Either email or Password Is incorrect ');
            }
        } else {

            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only("email")); //hold input value

        }
    }

    // Show user profile
    public function profile()
    {
        $id = Auth::user()->id;

        // $user=User::where('id',$id)->first();
        $user = User::find($id);

        // echo "<h1><pre>$user</pre></h1>";

        return view('front.account.profile', [
            'user' => $user
        ]);
    }

    //update profile
    public function updateProfile(Request  $request)
    {

        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:20',
            'email' => 'required|email',
        ]);

        if ($validator->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success', 'Data Updated Sucessfully ');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    //update Profile Pic
    public function updateProfilePic(Request $request)
    {
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:png,jpg,jpeg',

        ]);

        if ($validator->passes()) {

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = $id . '-' . time() . '.' . $ext;
            $image->move(public_path('/profile_pic'), $imageName);


            //delete old image
            File::delete(public_path('/profile_pic/' . Auth::user()->image));


            User::where('id', $id)->update(['image' => $imageName]);


            session()->flash('success', 'Image  updated Sucessfully :) ');

            return response()->json([

                'status' => true,
                'errors' => []

            ]);

        } else {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    //foreign key value fetch
    public function createJob(Request $request){

        $catagory = Catagory::orderBy('name','ASC')->where('status',1)->get();
        $jobType= JobType::orderBy('name','ASC')->where('status',1)->get();


        return view('front.account.job.createjob',[
            'catagories'=>$catagory,
            'jobtypes'=>$jobType
        ]);

    }

    //save the value of jobs
    public function saveJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tittle' => 'required|min:5|max:100',
            'catagory' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:50',

        ]);



        if ($validator->passes()) {

            $job = new Job();

            $job->tittle = $request->tittle;
            $job->catagory_id  = $request->catagory;
            $job->job_type_id  = $request->jobType;
            $job->vaccency = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->user_id=Auth::user()->id;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualification = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();

            session()->flash('success', 'Job Added Sucessfully ');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()

            ]);
        }
    }


    //fetch the jobs
    public function myJobs()
    {
        $jobs =Job:: where('user_id',Auth::user()->id)->paginate(10);

         return view('front.account.job.my-jobs',[
            'jobs'=>$jobs
         ]);
    }

    //edit jobs
    public function editJobs(Request $request ,$id){

        $catagory= Catagory::orderBy('name','ASC')->where('status',1)->get();
         $jobType= JobType::orderBy('name','ASC')->where('status',1)->get();

        $job=Job::where([
            'user_id'=>Auth::user()->id,
            'id'=>$id
        ])->first();

        if($job==null){
            abort(404);
        }

        return view ('front.account.job.editjob' ,[
            'catagories'=>$catagory,
            'jobtypes'=>$jobType,
            'job'=>$job
        ]);

    }

    //update job
    public function updateJobs(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tittle' => 'required|min:5|max:100',
            'catagory' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:50',

        ]);

        if ($validator->passes()) {

            $job = Job::find($id);

            // if ($job == null) {
            //     return response()->json([
            //         'status' => false,
            //         'errors' => ['Job not found']
            //     ]);
            // }

            $job->tittle = $request->tittle;
            $job->catagory_id  = $request->catagory;
            $job->job_type_id  = $request->jobType;
            $job->vaccency = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->user_id=Auth::user()->id;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualification = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();

            session()->flash('success', 'Job Updated Sucessfully ');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()

            ]);
        }
    }

    //delete job
    public function deleteJobs(Request $request)
    {
        $job = Job::where('id', $request->jobId)
            ->where('user_id', Auth::id())
            ->first();

        if ($job == null) {
            session()->flash('error', 'Job not found or you do not have permission to delete this job.');
            return response()->json([
                'status' => true,
            ]);
        }

        $job->delete();

        session()->flash('success', 'Job deleted successfully');
        return response()->json([
            'status' => true,
        ]);
    }



    // Logout user
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }
}
