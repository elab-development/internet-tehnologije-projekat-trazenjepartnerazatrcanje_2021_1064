<?php

namespace App\Http\Controllers;

use App\Http\Resources\Plan\PlanCollection;
use App\Http\Resources\Plan\PlanResource;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::all();
        return response()->json(new PlanCollection($plans));
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
            'name' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'length' => 'required|numeric|min:0.1|max:100',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::find($request->user_id);
        if (is_null($user)) {
            return response()->json('User not found', 404);
        }

        $plan = Plan::create([
            'name' => $request->name,
            'place' => $request->place,
            'length' => $request->length,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'Plan created' => new PlanResource($plan)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show($plan_id)
    {
        $plan = Plan::find($plan_id);
        if (is_null($plan)) {
            return response()->json('Plan not found', 404);
        }
        return response()->json(new PlanResource($plan));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'length' => 'required|numeric|min:0.1|max:100',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::find($request->user_id);
        if (is_null($user)) {
            return response()->json('User not found', 404);
        }

        $plan->name = $request->name;
        $plan->place = $request->place;
        $plan->length = $request->length;
        $plan->user_id = $request->user_id;

        $plan->save();

        return response()->json([
            'Plan updated' => new PlanResource($plan)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();
        return response()->json('Plan deleted');
    }
}
