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
            'Work as' => $this->occupation,
            'Adresse' => $this->adresse,
            // 'Phone number' => $this->contact->phone_number,
            // 'E-mail' => $this->contact->e_mail,
            'Contacts' => new ContactResource($this->contact),
            'Links' => new LinkCollection($this->links),
            'About' => $this->bio
        ];
    }
}
