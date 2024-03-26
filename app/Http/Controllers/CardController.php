<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Resources\CardResource;
use App\Http\Resources\CardCollection;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CardCollection(Card::paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company' => 'required',
            'card_owner' => 'required',
            'occupation' => 'required',
            'adresse' => 'required',
            'bio' => 'required',
            'phone_number' => 'nullable',
            'e_mail' => 'nullable',
            'links' => 'nullable|array',
            'links.*.name' => 'nullable|required_with:links',
            'links.*.url' => 'nullable|required_with:links|url',
        ]);
        $card = Card::create([
            'company' => $validatedData['company'],
            'card_owner' => $validatedData['card_owner'],
            'occupation' => $validatedData['occupation'],
            'adresse' => $validatedData['adresse'],
            'bio' => $validatedData['bio'],
        ]);
        if(isset($validatedData['phone_number'], $validatedData['e_mail'])){
            $contact = $card->contact()->create([
                'phone_number' => $validatedData['phone_number'],
                'e_mail' => $validatedData['e_mail'],
            ]);
        }
        if(isset($validatedData['links'])){
            foreach ($validatedData['links'] as $linkData) {
                $contact->links()->create([
                    'name' => $linkData['name'],
                    'url' => $linkData['url'],
                ]);
            }
        }
        return new CardResource($card->refresh());
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card)
    {
        return new CardResource($card);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCardRequest $request, Card $card)
    {
        $card->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card)
    {
        $card->delete();
    }
}
