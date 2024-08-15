<?php

namespace App\Http\Resources\Itinerary;

use App\Http\Resources\Plan\PlanResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ItineraryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'itinerary';

    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'plan' => new PlanResource($this->resource->plan),
            'date' => $this->resource->date,
            'user' => new UserResource($this->resource->user),
        ];
    }
}
