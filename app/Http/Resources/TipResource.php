<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TipResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'match_teams' => $this->match_teams,
            'prediction'  => $this->prediction,
            'odds'        => (float) $this->odds,
            'status'      => $this->status,
            'match_date'  => $this->match_date,
            'created_at'  => $this->created_at->toDateTimeString(),
            'tipster'     => [
                'id'   => $this->user->id,
                'name' => $this->user->name,
            ],
        ];
    }
}