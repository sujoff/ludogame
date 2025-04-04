<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserRemoveRequest;
use App\Http\Requests\UserSearchRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserUpdateStatisticsRequest;
use App\Http\Resources\SearchUserResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @group User management
 *
 * APIs for managing users
 */
class UserController extends Controller
{
    public function register(UserRegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        $user = User::create($data);

        return response()->json(['user' => $user]);
    }
    public function show(string $externalId): UserResource
    {
        $user = User::where('external_id', $externalId)->firstOrFail();
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, $externalId): UserResource
    {
        $user = User::where('external_id', $externalId)->firstOrFail();
        $user->update($request->validated());

        return new UserResource($user);
    }

    public function remove(UserRemoveRequest $request): \Illuminate\Http\JsonResponse
    {

        $user = User::whereExternalId($request->get('external_id'))->firstOrFail();
        $user->delete();

        return $this->successResponse(__('user.removed'));
    }

    public function search(UserSearchRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $friends = [];
        $data = $request->validated();
        $blocked = [];

        if (isset($data['external_id'])) {
            $user = User::whereExternalId($data['external_id'])->first();
            $friends = $user ? $user->allFriends()->pluck('users.id')->toArray() : null;
            $blocked = $user ? $user->blockedFriends()->pluck('users.id')->toArray() : null;
        }

        $users = User::
            orWhere('name', 'like', '%' . $data['search'] . '%')
            ->orWhere('external_id',  $data['search'])
            ->whereNotIn('id', $blocked)
            ->get()
            ->each(function ($user) use ($friends) {
                $user->is_friend = in_array($user->id, $friends);
            });


        return SearchUserResource::collection($users);
    }
}
