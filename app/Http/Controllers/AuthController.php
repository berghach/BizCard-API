<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;


class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/sanctum/token",
     *      operationId="login",
     *      tags={"Authentication"},
     *      summary="Authenticate user",
     *      description="Authenticate a user with email and password and generate an API token.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="User credentials",
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *              @OA\Property(property="password", type="string", format="password", example="secret")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example=200),
     *              @OA\Property(property="access_token", type="string"),
     *              @OA\Property(property="token_type", type="string", example="Bearer"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized - Invalid credentials"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error - Missing required fields"
     *      )
     * )
     */
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if(!empty($user)){
            if (Hash::check($request->password, $user->password)) {
                return response($user->createToken($user->name.'token', ['create', 'update', 'delete'])->plainTextToken);
            }else{
                    return ['The password is incorrect.'];
            }
        }else{
            return ['User not found', 'Sign up in /api/signup'];
        }
    }
    /**
     * @OA\Post(
     *      path="/api/signup",
     *      operationId="signup",
     *      tags={"Authentication"},
     *      summary="Register new user",
     *      description="Register a new user with name, email, and password and generate an API token.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="User data",
     *          @OA\JsonContent(
     *              required={"name","email","password","password_confirmation"},
     *              @OA\Property(property="name", type="string", example="John Doe"),
     *              @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *              @OA\Property(property="password", type="string", format="password", example="secret"),
     *              @OA\Property(property="password_confirmation", type="string", format="password", example="secret")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User registered successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token", type="string"),
     *              @OA\Property(property="token_type", type="string", example="Bearer"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error - Missing required fields or password confirmation does not match"
     *      )
     * )
     */
    public function signup(Request $request){
        $validData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $user = User::create($validData);
        return $user->createToken($user->name.'token', ['create', 'update', 'delete'])->plainTextToken;
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
