<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

class UserController extends Controller
{
    function register(){
        return view('auth.register');
    }
    function login(){
        return view('auth.login');
    }

    function do_register(Request $request){


        $validator = Validator::make($request->all(),[
            'username' => 'required|string|max:195',
            'email' => 'required|email|max:195|unique:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request['email'])->first();

        if($user){
            return response()->json([
                'Exist'=>'Email Already exist',
            ]);
        }
        else{
            $user = new User;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json([
                'success' => 'User Registered Successfully',
            ]);
        }
            // $user-save();

    }


    public function do_login(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')])) {
            $user = Auth()->user();
            $request->session()->put('loginId', $user->id);
                return response()->json(['success' => 'Successfully Logged In']);

        } else {
            return response()->json(['error'=> 'Something went wrong']);
        }
    }

    public function logout(){
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('/login');
        }

    }
}
