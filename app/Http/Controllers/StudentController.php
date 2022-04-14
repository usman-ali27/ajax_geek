<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    function index(){
        // $user = Auth::users();
        return view('student.index');
    }

    function fetchstudent($id=null){

         $stu= Student::all();
         return response()->json([
             'students'=>$stu,
         ]);

    }

    function store(Request $request ){

        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'
            => $validator->errors()->all()]);
        }
        else {
            $stu = new Student;
            $stu->name = $request->name;
            $stu->email = $request->email;
            $stu->password = $request->password;
            $stu->save();
            return response()->json([
                'status'=> 200,
                'success'=> 'Student SuccesFully Add'
            ]);
        }
    }

    function editStudent($id){

        $stu = Student::find($id);

        if($stu){
            return response()->json([
                'status'=> 200,
                'success'=>$stu,
            ]);
        }
        else{
            return response()->json([
                'status'=> 404,
                'errors'=>"Student Not Found"
            ]);
        }
    }

    function updateStudent(){


    }
}
