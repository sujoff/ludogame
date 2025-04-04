<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckSpinWheelAllowedRequest;
use App\Http\Requests\SpinWheelRequest;
use App\Http\Resources\SpinWheelResource;
use App\Models\SpinWheel;
use App\Models\User;
use App\Models\UserSpinWheel;
use Illuminate\Http\Request;

/**
 * @group Spin wheel management
 *
 * APIs for managing spin wheel
 */
class SpinWheelController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $collection = collect([
            [
                'id' => 1,
                'name' => 'Free spin',
                'is_free_spin' => true,
                'collection' => [],
                'index' => -1,
            ],
            [
                'id' => 2,
                'name' => 'Try again',
                'is_try_again' => true,
                'collection' => [],
                'index' => -2,
            ]
        ]);


        $collection1 = collect([
            [
                'id' => 1,
                'name' => 'Free spin',
                'is_free_spin' => true,
                'collection' => [],
                'index' => -1,
            ],
            [
                'id' => 2,
                'name' => 'Try again',
                'is_try_again' => true,
                'collection' => [],
                'index' => -2,
            ]
        ]);

        $spinWheels = SpinWheel::with(['collection'])->activeWheel(now())->get();

        return SpinWheelResource::collection($spinWheels);
    }

    public function spinWheel(SpinWheelRequest $request): \Illuminate\Http\JsonResponse
    {
        $input = $request->validated();

        $user = User::where('external_id', $input['external_id'])->first();

        // check if allowed to makeSpin wheel
        if (!$this->validateSpinWheelRequest($request->validated(), $user)) {
            return $this->errorResponse(__('message.spinWheel_not_allowed'));
        }

        // make spin wheel
        $spinWheel = $this->makeSpinWheel();

        if (empty($spinWheel)) {
            return $this->errorResponse(__('message.spinWheel_not_found'));
        }

        UserSpinWheel::create([
            'user_id' => $user->id,
            'spin_wheel_id' => $spinWheel->id,
            'ad_spin_at' => $input['from_ad'] ? now() : null,
        ]);

        return $this->successResponse(__('message.spinWheel.success'), new SpinWheelResource($spinWheel));
    }

    public function spinWheelStatus(CheckSpinWheelAllowedRequest $request): \Illuminate\Http\JsonResponse
    {
        $input = $request->validated();
        $user = User::where('external_id', $input['external_id'])->first();

        $aduserSpinWheel = UserSpinWheel::where('user_id', $user->id)->whereNotNull('ad_spin_at')->latest()->first();
        $diffAdSec = $aduserSpinWheel ? $aduserSpinWheel->ad_spin_at->diffInSeconds(now()) : setting('ad_time_interval');

        $userSpinWheel = UserSpinWheel::where('user_id', $user->id)->whereNull('ad_spin_at')->whereDate('created_at',today())->first();
        $diffNorSec = $userSpinWheel ? $userSpinWheel->created_at->diffInSeconds(now()) : setting('normal_time_interval');

        $adRemainingTime = setting('ad_time_interval') - $diffAdSec;
        $normalRemainingTime = setting('normal_time_interval') - $diffNorSec;

        return $this->successResponse(__('message.spinWheel.status'), [
            'ad_remaining_time' => max($adRemainingTime, 0),
            'normal_remaining_time' => max($normalRemainingTime, 0),
        ]);
    }

    protected function makeSpinWheel()
    {
        return SpinWheel::with(['collection'])->activeWheel(now())->inRandomOrder()->first();
    }

    private function validateSpinWheelRequest(mixed $validated, $user): bool
    {

        if ($validated['from_ad']) {
            $userSpinWheel = UserSpinWheel::where('user_id', $user->id)->whereNotNull('ad_spin_at')->latest()->first();

            if (empty($userSpinWheel)) {
                return true;
            }

            $lastAdSpinTime = $userSpinWheel->ad_spin_at;
            $diff = $lastAdSpinTime->diffInSeconds(now());
//            print_r(now()); print_r($userSpinWheel->ad_spin_at); print_r($diff);die;
            return $diff >= setting('ad_time_interval');
        }

        $userSpinWheel = UserSpinWheel::where('user_id', $user->id)->whereNull('ad_spin_at')->whereDate('created_at',today())->first();

        if (empty($userSpinWheel)) {
            return true;
        }

        $diff = $userSpinWheel->created_at->diffInSeconds(now());

        return $diff >= setting('normal_time_interval');
    }
}
