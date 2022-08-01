<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\CompanyRequest;
use App\Interfaces\CompanyInterface;

class CompanyController extends Controller
{
    protected $companyInterface;

    public function __construct(CompanyInterface $companyInterface)
    {
        $this->companyInterface = $companyInterface;
    }

    public function show($id)
    {
        return $this->companyInterface->getCompanyById($id);
    }
    
    public function store(CompanyRequest $request)
    {
        return $this->companyInterface->requestCompany($request);
    }

    public function websiteverify(Request $request)
    {
        return $this->companyInterface->requestWebsite($request);
    }

    public function verify($token)
    {
        return $this->companyInterface->verify($token);
    }

    public function companyVerify(Request $request)
    {
        return $this->companyInterface->companyVerify($request, $request->token);
    }

    public function invitepeople(Request $request)
    {
        return $this->companyInterface->invitepeople($request);
    }

    public function getpeople(Request $request)
    {
        return $this->companyInterface->getpeople($request);
    }
}