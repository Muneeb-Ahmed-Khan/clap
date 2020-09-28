<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('/home');
    }


    //=======================================
    //   VIEW and Update Account
    //=======================================
    public function MyAccount(Request $request)
    {
        return view('MyAccount');
    }

    

    public function ManageMyAccount(Request $request)
    {
        if($request->has('passwordForm'))
        {
            if(Hash::check($request->input('curPass'), Auth::user()->password))
            {
                $count = DB::table(Auth::User()->getTable())->where([

                    'id' =>  Auth::user()->id,
                    'email' => Auth::user()->email,
                    
                    ])->update([
        
                    'password' => Hash::make($request->input('newPass')),
                    'updated_at' => Carbon::now()
        
                ]);
                
                if($count != null)
                {
                    Auth::logout();
                    return redirect('/')->with(["success" => "Password Updated Successfully, Please Login again."]);
                }
            }

            return back()->withErrors(["WrongInput" => "Current password wrong."]);
            
        }
        return back()->withErrors(["WrongInput" => "Something went Wrong"]);
    }
}
