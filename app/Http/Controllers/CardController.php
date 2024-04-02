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
use OpenApi\Annotations as OA;
/**
 * @OA\Info(
 *   title="BizCard-API",
 *   version="1.0.0",
 * )
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   in="header",
 *   name="Authorization",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 * )
 * @OA\Schema(
 *   schema="Card",
 *   title="Card",
 *   description="Card model",
 *   @OA\Property(property="id", type="integer", format="int64", description="ID of the card"),
 *   @OA\Property(property="company", type="string", description="Company of the card"),
 *   @OA\Property(property="card_owner", type="string", description="Owner of the card"),
 *   @OA\Property(property="occupation", type="string", description="Occupation of the card owner"),
 *   @OA\Property(property="adresse", type="string", description="Address of the card owner"),
 *   @OA\Property(property="bio", type="string", description="Bio information of the card owner"),
 *   @OA\Property(property="phone_number", type="string", description="Phone number of the card owner"),
 *   @OA\Property(property="e_mail", type="string", format="email", description="Email of the card owner"),
 * )
 */

class CardController extends Controller
{
    /**
     * @OA\Get(
     *      path="/cards",
     *      operationId="getCardList",
     *      tags={"Cards"},
     *      summary="Get list of cards",
     *      description="Returns a list of cards that the authenticated user has permission to view.",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Card")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden - The user does not have permission to view any cards."
     *      )
     * )
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
 * @OA\Post(
 *      path="/cards",
 *      operationId="storeCard",
 *      tags={"Cards"},
 *      summary="Create a new card",
 *      description="Creates a new card with the provided data.",
 *      security={{"bearerAuth":{}}},
 *      @OA\RequestBody(
 *          required=true,
 *          description="Card data",
 *          @OA\JsonContent(
 *              required={"company", "card_owner", "occupation", "adresse", "bio", "phone_number", "e_mail"},
 *              @OA\Property(property="company", type="string"),
 *              @OA\Property(property="card_owner", type="string"),
 *              @OA\Property(property="occupation", type="string"),
 *              @OA\Property(property="adresse", type="string"),
 *              @OA\Property(property="bio", type="string"),
 *              @OA\Property(property="phone_number", type="string"),
 *              @OA\Property(property="e_mail", type="string"),
 *              @OA\Property(property="links", type="array", @OA\Items(
 *                  @OA\Property(property="name", type="string"),
 *                  @OA\Property(property="url", type="string"),
 *              )),
 *          )
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Card created successfully",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", ref="#/components/schemas/Card")
 *          )
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Validation error - One or more fields are invalid"
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized"
 *      )
 * )
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
    }
/**
 * @OA\Get(
 *      path="/cards/{cardId}",
 *      operationId="getCard",
 *      tags={"Cards"},
 *      summary="Get a card by ID",
 *      description="Returns the details of a card by its ID.",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *          name="cardId",
 *          in="path",
 *          required=true,
 *          description="ID of the card",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", ref="#/components/schemas/Card")
 *          )
 *      ),
 *      @OA\Response(
 *          response=403,
 *          description="Forbidden - The user does not have permission to view the card."
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Not Found - The card with the specified ID was not found."
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized"
 *      )
 * )
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
 * @OA\Put(
 *      path="/cards/{cardId}",
 *      operationId="updateCard",
 *      tags={"Cards"},
 *      summary="Update a card by ID",
 *      description="Updates the details of a card by its ID.",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *          name="cardId",
 *          in="path",
 *          required=true,
 *          description="ID of the card",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          description="Updated card data",
 *          @OA\JsonContent(
 *              required={"company", "card_owner", "occupation", "adresse", "bio", "phone_number", "e_mail"},
 *              @OA\Property(property="company", type="string"),
 *              @OA\Property(property="card_owner", type="string"),
 *              @OA\Property(property="occupation", type="string"),
 *              @OA\Property(property="adresse", type="string"),
 *              @OA\Property(property="bio", type="string"),
 *              @OA\Property(property="phone_number", type="string"),
 *              @OA\Property(property="e_mail", type="string"),
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Card updated successfully",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", ref="#/components/schemas/Card")
 *          )
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Validation error - One or more fields are invalid"
 *      ),
 *      @OA\Response(
 *          response=403,
 *          description="Forbidden - The user does not have permission to update the card."
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Not Found - The card with the specified ID was not found."
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized"
 *      )
 * )
*/
    public function update(UpdateCardRequest $request, Card $card)
    {
        $response = Gate::inspect('update', $card);
 
        if ($response->allowed()) {
            if($request->method()==="PUT"){
                $card->update($request->all());
                return ["Card updated", new CardResource($card), $request->method()];
            }else{
                $card->update($request->all());
                return ["Card updated", new CardResource($card), $request->method()];
            }
        } else {
            return [$response->message()];
        }
    }

    /**
     * @OA\Delete(
     *      path="/cards/{cardId}",
     *      operationId="deleteCard",
     *      tags={"Cards"},
     *      summary="Delete a card by ID",
     *      description="Deletes a card by its ID.",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="cardId",
     *          in="path",
     *          required=true,
     *          description="ID of the card",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Card deleted successfully"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden - The user does not have permission to delete the card."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found - The card with the specified ID was not found."
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
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
