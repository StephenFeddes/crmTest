<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index() 
    {
        return view('employee.index');
    }

    public function fetchstudent() 
    {
        $employees = User::all();
        return response()->json([
            'employees'=>$employees
        ]);
    }

    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'firstName'=>'required|max:255',
            'lastName'=>'required|max:255',
            'department'=>'required|max:255',
            'email'=>'required|email|max:255',
            'phone'=>'required|max:255',
            'username'=>'required|max:255',
            'password'=>'required|max:255',
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        } 
        else 
        {
            $employee = new User;
            $employee->first_name = $request->input('firstName');
            $employee->last_name = $request->input('lastName');
            $employee->department_name = $request->input('department');
            $employee->email_address = $request->input('email');
            $employee->phone_number = $request->input('phone');
            $employee->username = $request->input('username');
            $employee->password = Hash::make($request->input('password'));
            $employee->save();
            return response()->json([
                'status'=>200,
                'message'=>"Employee Added Successfully"
            ]);
        }
    }

    public function edit($id) {
        $employee = User::find($id);
        if ($employee)
        {
            return response()->json([
                'status'=>200,
                'employee'=>$employee
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'employee'=>"Employee Not Found"
            ]);
        }
    }

    public function update(Request $request, $id) 
    {
        $validator = Validator::make($request->all(), [
            'firstName'=>'required|max:255',
            'lastName'=>'required|max:255',
            'department'=>'required|max:255',
            'email'=>'required|email|max:255',
            'phone'=>'required|max:255',
            'username'=>'required|max:255'
        ]);


        if ($validator->fails()) 
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        } 
        else 
        {
            $employee = User::find($id);
            
            if ($employee) 
            {


                $employee->first_name = $request->input('firstName');
                $employee->last_name = $request->input('lastName');
                $employee->department_name = $request->input('department');
                $employee->email_address = $request->input('email');
                $employee->phone_number = $request->input('phone');
                $employee->username = $request->input('username');
                if ($request->input('password')) {
                    $employee->password = $request->input('password');
                }
                $employee->update();
                return response()->json([
                    'status'=>200,
                    'message'=>"Employee Updated Successfully"
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'employee'=>"Employee Not Found"
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $student = User::find($id);
        $student->delete();
        return response()->json([
            'status'=>200,
            'employee'=>"Employee Deleted Successfully"
        ]);
    }
}
