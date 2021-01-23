<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'data'    => '',
                    'error'   => ['invalid_credentials'],
                ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => true,
                'data'    => '',
                'error'   => 'could_not_create_token',
            ], 500);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'success' => false,
                    'data'    => $user,
                    'error'   => ['user_not_found'],
                ], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => ['token_expired'],
            ], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => ['token_invalid'],
            ], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => ['token_absent'],
            ], $e->getStatusCode());
        }

        return response()->json([
            'success' => true,
            'data'    => $user,
            'error'   => [],
        ]);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
        ]);
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'name'       => 'required',
                'email'      => 'required|email|unique:users',
                'password'   => 'required',
                'c_password' => 'required|same:password',
            ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => $validator->errors(),
            ], 401);

        }

        $user           = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'data'    => $user,
            'error'   => [],
        ], 201);
    }
}
