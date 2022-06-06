<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //   $company = Company::all();
       //   return response()->json($company);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'logo' => 'required',
            'description' => 'required|max:255',
         //   'created_by' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'error']);
        }
        $file = $request->file('logo');
        $input['logo'] = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = storage_path('public/logo/');
        $file->move($destinationPath, $input['logo']);
        $company = new Company();

        $company->logo = $input['logo'];
        $company->created_by = Auth::user()->id;
        $company->name = $data['name'];
        $company->description = $data['description'];
        $company->save();
        $logo = url('/api/image/' . $company->id);

      $responseData['status']=true;
      $companyCollection = array("logo" => $logo, "name" => $data['name'], "description" => $data['description']);
      $responseData['data']=$companyCollection;
      return response()->json($responseData);
    }

    public function edit($id)
    {
       $company = Company::find($id);
      return response()->json($company);
    }

    public function update(Request $request, $id)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'logo' => 'required',
            'description' => 'required|max:255',
         //   'created_by' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'error']);
        }

        $file = $request->file('logo');
        $data['logo'] = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = storage_path('public/logo/');
        $file->move($destinationPath, $data['logo']);
        //////$company = Company::where('id',$id)->first();

        //$company->logo = $input['logo'];
        //echo $input['logo'];
        //$company->name = $data['name'];
        //$company->description = $data['description'];
        Company::whereid($id)->update($data);
        $logo = url('/api/image/' . $id);

      $responseData['status']=true;
      $companyCollection = array("logo" => $logo, "name" => $data['name'], "description" => $data['description']);
      $responseData['data']=$companyCollection;
      return response()->json($responseData);

     /*   $logoPath = public_path(). '/logo';
        $data['logo'] = $logoPath;

        $company = Company::find($id)->update($data);

        return response()->json([
            "success" => true,
            "message" => "Updated Successfully",
            "data" => $company
            ]);  */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     //   $company = Company::findOrFail($id);
     //   $company->delete();

     //   return response()->json($company::all());
    }
}
