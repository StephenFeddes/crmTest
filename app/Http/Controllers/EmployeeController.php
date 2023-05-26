<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('employee.index');
    }

    public function fetchemployee() 
    {
        $employees = User::all();
        return response()->json([
            'employees'=>$employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName'=>'required|max:255',
            'lastName'=>'required|max:255',
            'department'=>'required|max:255',
            'email'=>'required|email|max:255',
            'phone'=>'required|unique:employee,phone_number|max:255',
            'username'=>'required|unique:employee,username|max:255',
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
                'message'=>"Employee Added"
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
        else {

            $employee = User::find($id);
            
            if ($employee) {
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = User::find($id);
        $student->delete();
        return response()->json([
            'status'=>200,
            'employee'=>"Employee Deleted Successfully"
        ]);
    }
}
