<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreprofileRequest;
use App\Http\Requests\UpdateprofileRequest;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //get all profiles with user
        $profiles = Profile::with('user')->get();
        return response()->json([
            'profiles' => $profiles
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreprofileRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreprofileRequest $request)
    {
        //store profile
        $data = $request->validated();
//        return $data;
        $profile = Profile::create($data);
        return response()->json(['profile' => $profile->load('user')], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\profile  $profile
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(profile $profile)
    {
        return response()->json($profile);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateprofileRequest  $request
     * @param  \App\Models\profile  $profile
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateprofileRequest $request, profile $profile)
    {
        $data = $request->validated();
        $profile->update($data);
        return response()->json(['profile' => $profile], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(profile $profile)
    {
        $profile->delete();
        return response()->noContent();
    }
}
