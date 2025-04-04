<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

/**
 * @group Auth management
 *
 * APIs for managing auth
 */
class AuthController extends Controller
{

    /**
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        try {
            if (User::where('external_id', $request->get('external_id'))->exists()) {
                return $this->errorResponse(__('User already exist'));
            }

            User::create($request->all());

            return $this->successResponse(__('User successfully registered'));
        } catch (\Exception $exception) {
            return $this->errorResponse(__('User registration failed'));
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|null
     */
    public function checkUser(Request $request): ?JsonResponse
    {
        $user = User::where('external_id', $request->get('external_id'))->first();

        if (empty($user)) {
            return $this->errorResponse(__('User not found'));
        }

        return $this->successResponse(__('User exists'),$user);
    }
}
