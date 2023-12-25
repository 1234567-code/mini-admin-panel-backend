<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use App\Notifications\SendNotification;

use Illuminate\Http\Request;
use App\Models\CompanyModel;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = CompanyModel::paginate(2);
        return $companies;
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
                'name' => 'string| required',
                'email'=>'string|required',
                'logo' => 'file|required',
                'website'=>'string|required'
            ]);
            if(!file_exists($request->file('logo'))){
                return "select logo first";
            }
            $logo_name = time().'_'.$request->file('logo')->getClientOriginalName();
            $logo_path = $request->file('logo')->storeAs('logos', $logo_name, 'public');
            $company = new CompanyModel();
            $comp = $company->create(
                [
                    "name" => $fields['name'],
                    "email" => $fields['email'],
                    "logo" => $logo_path,
                    "website" => $fields['website']
                ]
                );
                if($comp){
                    // Notification::route('mail', $fields['email'])->notify(new SendNotification());
                    return "new company added";
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
                'name' => 'string|required',
                'email'=>'string|required',
                'logo' => 'file|required',
                'website'=>'string|required'
            ]);
            if(!file_exists($request->file('logo'))){
                return "select logo first";
            }
            $logo_name = time().'_'.$request->file('logo')->getClientOriginalName();
            $logo_path = $request->file('logo')->storeAs('logos', $logo_name, 'public');
            $com = CompanyModel::find($request->id);
            $company = CompanyModel::where('id', $request->id )->update([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'logo' => $logo_path,
                'website' => $fields['website']
            ]);
           if($company){
            Storage::disk('public')->delete($com->logo);
            return "company updated";
           }else{
            return "could not updated";
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
        try{
            $com = CompanyModel::find($id);
            $company = CompanyModel::where('id', $id)->delete();
           if($company){
            Storage::disk('public')->delete($com->logo);
            return "company deleted";
           }else{
            return "could not deleted";
           }
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
        
    }
}
