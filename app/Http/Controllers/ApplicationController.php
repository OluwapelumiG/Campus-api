<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\GigResource;
use App\Models\Application;
use App\Models\Gig;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return ApplicationResource::collection(Application::all());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
        $application = Application::create($request->validated());

        return ApplicationResource::make($application);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        //
        return ApplicationResource::make($application);
    }

    public function myApplications()
    {
        $student = Auth::user()->id;

        $gigs = Application::where('student_id', $student)->get();

        // foreach ($gigs as $gig) {
        //     // if ($gig->posted_by) {
        //     $gig->gig_det = Gig::where('id', $gig->id)->first();
        //     // $gig->owner = User::where('id', $gig->gig_det->posted_by)->first();
        //     $gig->owner = $gig->gig_det;
        //     // }
        // }

        // foreach ($gigs as $gig) {
        //     // if ($gig->posted_by) {
        //     // $gig->gig_det = Gig::where('id', $gig->id)->first();
        //     // $gig->owner = User::where('id', $gig->gig_det->posted_by)->first();
        //     // }
        //     // $dsgig = Gig::where('id', $gig->id)->first();
        //     // $gig->gig_det = new GigResource($dsgig);
        // }

        // dd($gigs);
        return ApplicationResource::collection($gigs);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        //
        $application->update($request->validated());

        return ApplicationResource::make($application);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
        $application->delete();

        return response()->noContent();
    }
}
