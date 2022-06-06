<?php

namespace App\Http\Controllers\API;

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
        //  $company = Company::all();
        //  return response()->json($company);
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

        $created_by = Auth::user()->id;

       // $logo = new logo;
        $getlogo = $request->logo;
        $logoName = time().'.'.$getlogo->extension();
        $logoPath = public_path(). '/logo';

       // $logo->path = $logoPath;
      ////  $logo->logo = $logoName;

      //  $getlogo->move($logoPath, $logoName);

        $data['logo'] = $logoPath;
        $data['created_by'] = $created_by;

        $company = Company::create($data);

       // $company->logo()->save($getlogo);
      //  $company->save($created_by);

        return response()->json([
            "success" => true,
            "message" => "successfully",
            "data" => $company
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      //  $company = Company::findOrFail($id);
      //  return response()->json($company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $request->Validator([
            'name' => 'required|max:255',
            'logo' => 'required',
            'description' => 'required',
        ]);
        $company->name = $request->get('name');
        $company->logo = $request->get('logo');
        $company->description = $request->get('description');

        $company->save();

    return response()->json($company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json($company::all());
    }
}
