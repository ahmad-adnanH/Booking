<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'booking_date' => $this->booking_date,
            'start_time'   => $this->start_time,
            'end_time'     => $this->end_time,
            'reason'       => $this->reason,
            'created_at'   => $this->created_at->toDateTimeString(),
            'hall'         => [
                'id'          => $this->hall->id,
                'name'        => $this->hall->name,
                'hall_number' => $this->hall->hall_number,
                'building'    => $this->hall->building,
                'floor'       => $this->hall->floor,
                'capacity'    => $this->hall->capacity,
            ],
            'review'       => $this->whenLoaded('review', function () {
                return $this->review ? [
                    'id'      => $this->review->id,
                    'rating'  => $this->review->rating,
                    'comment' => $this->review->comment,
                ] : null;
            }),
        ];
    }
}
