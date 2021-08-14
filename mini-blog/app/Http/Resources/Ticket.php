<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Ticket extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
	 
     public function toArray($request)
    {
        return [
            'id' => $this->id,
            'author' => $this->author,
            'title' => $this->title,
            'description' => $this->description,
            // 'created_at' => $this->created_at->format('m/d/Y'),
            'created_at' => Carbon::parse($this->created_at)->format('m/d/Y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('m/d/Y'),
        ];
    }
}
