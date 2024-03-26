<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Id' => $this->id,
            'Company' => $this->company,
            'Owner' => $this->card_owner,
            'Work as' => $this->occupation,
            'Adresse' => $this->adresse,
            'Contact me' => $this->contact,
            'Links' => $this->links,
            'About' => $this->bio
        ];
    }
}
