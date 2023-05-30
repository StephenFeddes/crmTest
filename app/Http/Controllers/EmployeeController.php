<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use OutOfBoundsException;

class EmployeeController extends Controller
{

    private $filters = [];

    // Displays the employee module
    public function index()
    {
        return view('employee.index', [
            'user'=>auth()->user()
        ]);
    }

    public function rowCount()
    {
        return User::all()->count();
    }

    // Returns a json file of all the employees
    public function fetchEmployees($pageNum) 
    {
        $pageSize = 5;
        $lowerPageBound = $pageNum * $pageSize;
        $upperPageBound = $lowerPageBound + $pageSize;
        $employeeList = User::orderBy('id', 'desc')->get();
        $employees = [];
        for ($i = $lowerPageBound; $i < $upperPageBound; $i++) {
            if (!isset($employeeList[$i])) {
                break;
            }
            $employees[] = $employeeList[$i];
        }

        return response()->json([
            'employees'=>$employees
        ]);
    }

    // Fetches data for the employee creation modal
    public function create()
    {
        
    }

    // Stores a created employee in the database
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName'=>'required|max:255',
            'lastName'=>'required|max:255',
            'department'=>'required|max:255',
            'email'=>'required|email|max:255',
            'phone'=>'required|unique:employee,phone_number|max:255', // Checks if the employee's phone number is unique to the employee table
            'username'=>'required|unique:employee,username|max:255', // Checks if the employee's username is unique to the employee table
            'password'=>'required|max:255' // Checks to make sure a password was entered
        ]);

        // If the validation fails, then respond with a '400' error and a list of what was invalid
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
            $employee->password = Hash::make($request->input('password')); // Hashes the password before storing it in the database so that the true password cannot be viewed in the database
            $employee->save(); // Creates the employee in the database
            
            // Responds back with a success message
            return response()->json([
                'status'=>200,
                'message'=>"Employee Added"
            ]);
        }
    }

    // Fetches and returns the selected employee
    public function show(string $id)
    {
        $employee = User::find($id);
        return response()->json([
            'employee'=>$employee
        ]);
    }

    
    // Returns employee data for the updated form
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

    // Updates the selected employee
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'firstName'=>'required|max:255', // max:255 means that the first name cannot have more than 255 characters in it
            'lastName'=>'required|max:255',
            'department'=>'required|max:255',
            'email'=>'required|email|max:255',
            'phone'=>'required|unique:employee,phone_number,'.$id.'|max:255', // Checks if the phone number is unique within the employee table excluding its own record
            'username'=>'required|unique:employee,username,'.$id.'|max:255', // Checks if the username is unique within the employee table excluding its own record
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
                    'message'=>"Employee Updated"
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
