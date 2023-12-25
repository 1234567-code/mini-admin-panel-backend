<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeModel;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = EmployeeModel::paginate(2);
        return $employees;
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
        try{
            $fields = $request->validate([
                'first_name' => 'string| required',
                'last_name' => 'string| required',
                'company_id'=>'int|required',
                'email' => 'string|required',
                'phone'=>'string|required'
            ]);
            $employee = new EmployeeModel();
            $emp = $employee->create(
                [
                    "first_name" => $fields['first_name'],
                    "last_name" => $fields['last_name'],
                    "company_id" => $fields['company_id'],
                    "email" => $fields['email'],
                    "phone" => $fields['phone']
                ]
                );
                if($emp){
                    // Notification::route('mail', $fields['email'])->notify(new SendNotification());
                    return "new employee added";
                }else{
                    return "not added";
                }

        }catch(\Exception $ex){
            return $ex->getMessage();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $fields = $request->validate([
                'first_name' => 'string| required',
                'last_name' => 'string| required',
                'company_id'=>'int|required',
                'email' => 'string|required',
                'phone'=>'string|required'
            ]);
            $employee = EmployeeModel::where('id', $request->id)->update([
                'first_name' => $fields['first_name'],
                'last_name' => $fields['last_name'],
                'company_id' => $fields['company_id'],
                'email' => $fields['email'],
                'phone' => $fields['phone'],
            ]);
            
            // Notification::route('mail', $fields['email'])->notify(new SendNotification());
            if($employee){
                return "new employee updated";
            }else{
                return "not updated";
            }

        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $id;
        try{
            $employee = EmployeeModel::where('id', $id)->delete();
            if($employee){
                return "employee deleted";
            }else{
                return "not deleted";
            }
        }catch(\Exception $ex){
            return $ex->getMessage();

        }
    }
}
