<?php

namespace App\Interfaces;

use App\Http\Requests\CompanyRequest;

interface CompanyInterface
{ 
    public function getCompanyById($id);

    public function requestCompany(CompanyRequest $request, $id = null);
    
    public function requestWebsite($request);

    public function verify($token);

    public function companyVerify($request, $token);

    public function invitepeople($request);

    public function getpeople($request);

    // company records
    public function companyindex($request);

    public function companydestroy($id);

    public function companyshow($id);

    // company show detail
    public function companylogo($id);

    

}