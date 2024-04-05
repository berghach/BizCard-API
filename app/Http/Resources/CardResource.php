<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
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
            'WorkAs' => $this->occupation,
            'Adresse' => $this->adresse,
            'Tel' => $this->phone_number,
            'E-mail' => $this->e_mail,
            'Links' => new LinkCollection($this->links),
            'About' => $this->bio
        ];
    }
}
