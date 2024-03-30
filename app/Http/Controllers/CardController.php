<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Resources\CardResource;
use App\Http\Resources\CardCollection;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('viewAny', Card::class)) {
            return new CardCollection(Card::paginate());
        }else{
            $cards = Card::all();
            $filteredCards = $cards->filter(function ($card) {
                return Gate::allows('view', $card);
            });
            return new CardCollection($filteredCards);
        }
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
    public function store(StoreCardRequest $request)
    {
        $card = Card::create([
            'company' => $request['company'],
            'card_owner' => $request['card_owner'],
            'occupation' => $request['occupation'],
            'adresse' => $request['adresse'],
            'bio' => $request['bio'],
            'phone_number' => $request['phone_number'],
            'e_mail' => $request['e_mail'], 
            'user_id' => Auth::user()->id
        ]);
        if(!empty($request['links'])){
            foreach ($request['links'] as $linkData) {
                $card->links()->create([
                    'name' => $linkData['name'],
                    'url' => $linkData['url'],
                ]);
            }
        }
        return new CardResource($card->refresh());
        // return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card)
    {
        if (Gate::allows('viewAny', Card::class)) {
            return new CardResource($card);
        }else{
            $response = Gate::inspect('view', $card);
            if($response->allowed()){
                return new CardResource($card);
            }else{
                return [$response->message()];
            }
        }
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
        $response = Gate::inspect('update', $card);
 
        if ($response->allowed()) {
            $card->update($request->all());
        } else {
            return [$response->message()];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card)
    {
        $response = Gate::inspect('delete', $card);
        if ($response->allowed()) {
            $card->delete();
        } else {
            return [$response->message()];
        }
    }
}
