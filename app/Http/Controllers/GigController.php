<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGigRequest;
use App\Http\Requests\UpdateGigRequest;
use App\Http\Resources\GigResource;
use App\Models\Gig;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Message;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;


class GigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //
    //     return GigResource::collection(Gig::orderBy('created_at', 'desc')->get());
    // }

    public function index()
    {
        $userId = Auth::user()->id; // Get the authenticated user's ID

        // Get gigs that the authenticated user has not applied to
        // $gigs = Gig::whereDoesntHave('applications', function ($query) use ($userId) {
        //     $query->where('student_id', $userId);
        // })->orderBy('created_at', 'desc')->get();

        $gigs = Gig::whereNull('student')->orderBy('created_at', 'desc')->get();


        return GigResource::collection($gigs);
    }


    public function myGigs()
    {
        $user = Auth::user()->id;

        $gigs = Gig::where('posted_by', $user)->orderBy('created_at', 'desc')->get();

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

    public function acceptGigApplication(UpdateGigRequest $request, Gig $gig)
    {


        // Get the student ID from the request
        $studentId = $request->input('student');


        // Begin a transaction to ensure data integrity
        DB::transaction(function () use ($gig, $studentId) {
            // Update the gig's student_id
            $gig->update(['student' => $studentId]);

            // Update the application's status to 'accepted'
            $application = Application::where('gig_id', $gig->id)->where('student_id', $studentId)->first();
            if ($application) {
                $application->update(['status' => 'accepted']);
            }

            // Create a message from the posted_by user to the student_id
            $message = "Gig Accepted\n\nTitle: {$gig->title}\n\nDescription: {$gig->description}";

            Message::create([
                'from' => $gig->posted_by,
                'user_id' => $studentId,
                'message' => $message,
                'read' => false,
            ]);
        });

        // Return the updated gig resource
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

    public function newGigApplication()
    {
        $gigs = Gig::whereHas('applications', function ($query) {
            $query->where('status', 'applied');
        })->whereNull('student')->distinct()->get();

        return GigResource::collection($gigs);
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
