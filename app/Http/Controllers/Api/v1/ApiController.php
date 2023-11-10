<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\ApiKey;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\InsuranceNeeds;
use App\Http\Controllers\Controller;
use App\Http\Resources\InsuranceSurveyResource;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InsuranceSurveyResource::collection(InsuranceNeeds::all());
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(InsuranceNeeds $insuranceNeed)
    {
        return InsuranceSurveyResource::make($insuranceNeed);

        if ($insuranceNeed) {
            return InsuranceSurveyResource::make($insuranceNeed);
        }

        else {
            return response()->json(['status' => 'error', 'message' => 'There was an error getting the data.'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function storeApiKey()
    {
        // Set all existing keys to inactive
        ApiKey::query()->update(['is_active' => false]);

        // Generate a new API key
        $apiKey = new ApiKey;
        $apiKey->key = Str::random(60);
        $apiKey->save();

        return response()->json(['api_key' => $apiKey->key], 200);
    }
}