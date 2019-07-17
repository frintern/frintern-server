<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class CompanyController extends Controller
{
    //

    public function __construct()
    {

    }


    public function index()
    {
        $companies = Company::all();

        return response()->json($companies);
    }

    public function store(Request $request)
    {
        try {
            $currentUser = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $ex) {
            return response()->json(["message" => $ex->getMessage()], 400);
        }

        $company = new Company();
        $company->name = $request->get('name');
        $company->created_by = $currentUser['id'];
        $company->description = $request->get('description');
        $company->logo_url = $request->get('logoUrl');
        $company->linkedin_url = $request->get('linkedInUrl');
        $company->angelist_url = $request->get('angelistUrl');
        $company->website = $request->get('website');
        $company->save();

        $matchedInterest = $request->get('matchedInterest');

        foreach ($matchedInterest as $interest) {
            DB::table('company_interest')->insert(['company_id' => $company->id,
                'interest_id' => $interest['id']
            ]);
        }

        return response()->json($company, 200);
    }


    public function claim(Request $request)
    {

    }


    public function update(Request $request)
    {

    }


}
