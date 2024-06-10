<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGigRequest;
use App\Http\Requests\UpdateGigRequest;
use App\Http\Resources\GigResource;
use App\Models\Gig;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return GigResource::collection(Gig::all());
    }


    public function myGigs()
    {
        $user = Auth::user()->id;

        $gigs = Gig::where('posted_by', $user)->get();

//        return response()->json(['gigs' => $gigs]);
        foreach ($gigs as $gig) {
            if ($gig->student) {

                $gig->student_det = User::where('id', $gig->student)->first();
            }
        }
        return GigResource::collection($gigs);
    }

    public function myGigsApplications(Gig $gig)
    {

//        return response()->json(['gig' => $gig]);
        return GigResource::make($gig);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGigRequest $request)
    {
        //
        $gig = Gig::create($request->validated());

        return GigResource::make($gig);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gig $gig)
    {
        //
//        foreach ($gigs as $gig) {
        if ($gig->student) {

            $gig->student_det = User::where('id', $gig->student)->first();
        }
//        }
        return GigResource::make($gig);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGigRequest $request, Gig $gig)
    {
        //
        $gig->update($request->validated());

        return GigResource::make($gig);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gig $gig)
    {
        //
        $gig->delete();

        return response()->noContent();
    }
}
