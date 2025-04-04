<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptOrRejectAllRequest;
use App\Http\Requests\AcceptOrRejectRequest;
use App\Http\Requests\BlockUnBlockRequest;
use App\Http\Requests\FriendListRequest;
use App\Http\Requests\StoreFriendRequest;
use App\Http\Requests\UpdateFriendRequest;
use App\Http\Resources\UserResource;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\User;
use App\Notifications\FriendNotification;
use Illuminate\Http\Request;

/**
 * @group Friend management
 *
 * APIs for managing friends
 */
class FriendController extends Controller
{
    /**
     * @queryParam external_id External ID of user. Example: 123
     */
    public function index(Request $request)
    {
        $externalId = $request->get('external_id');

        $user = User::where('external_id', $externalId)->first();

        $friends = $user->friends;

        return UserResource::collection($friends);
    }

    public function blockedList(Request $request)
    {
        $externalId = $request->get('external_id');

        $user = User::where('external_id', $externalId)->first();

        $friends = $user->blockedFriends;

        return UserResource::collection($friends);
    }

    public function makeFriendRequest(StoreFriendRequest $request)
    {
        $data = $request->validated();

        $user = User::where('external_id', $data['external_id'])->first();
        $friendUser = User::where('external_id', $data['friend_external_id'])->first();

        $friend = FriendRequest::firstOrCreate([
            'user_id' => $user->id,
            'friend_id' => $friendUser->id
        ]);

        $friendUser->notify(new FriendNotification(__('Friend request'), __('You got friend request from '.$user->name)));

        return $this->successResponse(__('success'),$friend);
    }

    /**
     * @queryParam external_id External ID of user. Example: 123
     */
    public function myFriendRequests(Request $request)
    {
        $externalId = $request->get('external_id');

        $user = User::where('external_id', $externalId)->first();

        $friends = $user->friendRequests;

        return UserResource::collection($friends);
    }

    public function acceptOrReject(AcceptOrRejectRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        $user = User::where('external_id', $data['external_id'])->first();
        $friend = User::where('external_id', $data['friend_external_id'])->first();

        if ($data['accepted']) {
            Friend::firstOrCreate([
                'user_id' => $user->id,
                'friend_id' => $friend->id
            ]);

            Friend::firstOrCreate([
                'user_id' => $friend->id,
                'friend_id' => $user->id
            ]);

            FriendRequest::where([
                'user_id' => $friend->id,
                'friend_id' => $user->id
            ])->delete();

            FriendRequest::where([
                'user_id' => $user->id,
                'friend_id' => $friend->id
            ])->delete();

            $friend->notify(new FriendNotification(__('Friend request accepted'), __($user->name. ' accepted your request')));
        } else {
            FriendRequest::where([
                'user_id' => $friend->id,
                'friend_id' => $user->id
            ])->delete();
            FriendRequest::where([
                'user_id' => $user->id,
                'friend_id' => $friend->id
            ])->delete();
        }

        return $this->successResponse(__('success'),$friend);
    }

    public function acceptOrRejectAll(AcceptOrRejectAllRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        $user = User::where('external_id', $data['external_id'])->first();
        $friendRequests = $user->friendRequests;

        if ($data['accepted']) {
            foreach ($friendRequests as $friend) {
                Friend::firstOrCreate([
                    'user_id' => $user->id,
                    'friend_id' => $friend->id
                ]);

                Friend::firstOrCreate([
                    'user_id' => $friend->id,
                    'friend_id' => $user->id
                ]);

                FriendRequest::where([
                    'user_id' => $friend->id,
                    'friend_id' => $user->id
                ])->delete();

                FriendRequest::where([
                    'user_id' => $user->id,
                    'friend_id' => $friend->id
                ])->delete();
                $friend->notify(new FriendNotification(__('Friend request accepted'), __($user->name. ' accepted your request')));
            }

        } else {
            foreach ($friendRequests as $friend) {

                FriendRequest::where([
                    'user_id' => $friend->id,
                    'friend_id' => $user->id
                ])->delete();

                FriendRequest::where([
                    'user_id' => $user->id,
                    'friend_id' => $friend->id
                ])->delete();

                $friend->notify(new FriendNotification(__('Friend request rejected'), __($user->name. ' rejected your request')));
            }
        }

        return $this->successResponse(__('success'),[]);
    }

    public function show(Friend $friend)
    {
        //
    }

    public function update(UpdateFriendRequest $request, Friend $friend)
    {
        //
    }

    public function makeUnFriend(StoreFriendRequest $request)
    {
        $data = $request->validated();

        $user = User::where('external_id', $data['external_id'])->first();
        $friend = User::where('external_id', $data['friend_external_id'])->first();

        Friend::where([
            'user_id' => $user->id,
            'friend_id' => $friend->id
        ])->delete();

        return $this->successResponse(__('success'));
    }

    public function blockUnblock(BlockUnBlockRequest $request)
    {
        $data = $request->validated();

        $user = User::where('external_id', $data['external_id'])->first();
        $friend = User::where('external_id', $data['friend_external_id'])->first();

        Friend::where([
            'user_id' => $user->id,
            'friend_id' => $friend->id,
        ])->update([
            'blocked' => $data['block']
        ]);

        return $this->successResponse(__('success'));
    }
}
