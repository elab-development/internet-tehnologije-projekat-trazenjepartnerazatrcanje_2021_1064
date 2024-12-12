<?php

namespace App\Http\Controllers;

use App\Http\Resources\Itinerary\ItineraryCollection;
use App\Http\Resources\Itinerary\ItineraryResource;
use App\Models\Itinerary;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itineraries = Itinerary::all();
        return response()->json(new ItineraryCollection($itineraries));
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
        $validator = Validator::make($request->all(), [
            'date' =>  'required|date',
            'plan_id' =>  'required|integer|max:255',
            'user_id' =>  'required|integer|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::find($request->user_id);
        if (is_null($user)) {
            return response()->json('User not found', 404);
        }

        $plan = Plan::find($request->plan_id);
        if (is_null($plan)) {
            return response()->json('Plan not found', 404);
        }

        $itinerary = Itinerary::create([
            'date' => $request->date,
            'plan_id' => $request->plan_id,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'Itinerary created' => new ItineraryResource($itinerary)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function show($itinerary_id)
    {
        $itinerary = Itinerary::find($itinerary_id);
        if (is_null($itinerary)) {
            return response()->json('Itinerary not found', 404);
        }
        return response()->json(new ItineraryResource($itinerary));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function edit(Itinerary $itinerary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Itinerary $itinerary)
    {
        $validator = Validator::make($request->all(), [
            'date' =>  'required|date',
            'plan_id' =>  'required|integer|max:255',
            'user_id' =>  'required|integer|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::find($request->user_id);
        if (is_null($user)) {
            return response()->json('User not found', 404);
        }

        $plan = Plan::find($request->plan_id);
        if (is_null($plan)) {
            return response()->json('Plan not found', 404);
        }

        $itinerary->date = $request->date;
        $itinerary->plan_id = $request->plan_id;
        $itinerary->user_id = $request->user_id;

        $itinerary->save();

        return response()->json([
            'Itinerary updated' => new ItineraryResource($itinerary)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Itinerary $itinerary)
    {
        $itinerary->delete();
        return response()->json('Itinerary deleted');
    }
}
