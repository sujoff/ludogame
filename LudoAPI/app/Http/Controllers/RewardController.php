<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClaimRewardRequest;
use App\Http\Requests\RewardRequest;
use App\Http\Resources\RewardResource;
use App\Models\Reward;
use App\Models\User;
use App\Models\UserReward;
use Illuminate\Http\Request;

/**
 * @group Reward management
 *
 * APIs for managing rewards
 */
class RewardController extends Controller
{
    protected function getCurrentReward($cycle): object|null
    {
        return Reward::with(['collection'])
            ->where('cycle', $cycle)
            ->where('day', now()->dayOfWeek())
            ->first();
    }
    /**
     * @queryParam integer cycle.
     */
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $cycle = $request->get('cycle') ?? setting('cycle');

        $rewards = Reward::with(['collection'])
            ->where('cycle', $cycle)
            ->get();

        return RewardResource::collection($rewards);
    }

    public function claim(ClaimRewardRequest $request): \Illuminate\Http\JsonResponse
    {
        $input = $request->validated();
        $user = User::where('external_id', $input['external_id'])->first();
        $reward = $this->getCurrentReward($request->get('cycle'));

        if (empty($reward)) {
            return $this->errorResponse(__('reward.not_found'));
        }

        $userReward = UserReward::where([
            'reward_id' => $reward->id,
            'user_id' => $user->id
        ])->first();

        if ($userReward) {
            return $this->errorResponse(__('reward_already_claimed'));
        }

        UserReward::create([
            'reward_id' => $reward->id,
            'user_id' => $user->id
        ]);

        return $this->successResponse(__('reward_claimed'), $reward);

    }

    public function available(ClaimRewardRequest $request): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();

        $user = User::where('external_id', $input['external_id'])->first();
        $reward = $this->getCurrentReward($request->get('cycle'));

        if (empty($reward)) {
            return $this->errorResponse(__('reward.not_found'));
        }

        $userReward = UserReward::where([
            'reward_id' => $reward->id,
            'user_id' => $user->id
        ])->first();

        if ($userReward) {
            return $this->errorResponse(__('reward_already_claimed'), ['available' => false]);
        }

        return $this->successResponse(__('reward_available'), ['available' => true]);

    }
}
