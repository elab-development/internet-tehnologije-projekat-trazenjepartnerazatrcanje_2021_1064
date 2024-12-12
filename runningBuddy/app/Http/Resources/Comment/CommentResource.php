<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\Plan\PlanResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'comment';

    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'content' => $this->resource->content,
            'rating' => $this->resource->rating,
            'user' => new UserResource($this->resource->user),
            'plan' => new PlanResource($this->resource->plan),
        ];
    }
}
