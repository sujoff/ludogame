<?php

namespace App\Http\Controllers;

use App\Http\Resources\OnlineTableResource;
use App\Models\OnlineTable;
use App\Models\User;
use Illuminate\Http\Request;

class OnlineTableController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return OnlineTableResource::collection(OnlineTable::all());
    }

    public function show(string $id): OnlineTableResource
    {
        return OnlineTableResource::make(OnlineTable::query()->find($id));
    }

    public function check(string $id, string $externalId): \Illuminate\Http\JsonResponse
    {
        $onlineTable = OnlineTable::query()->find($id);
        $user = User::where('external_id', $externalId)->first();

        if ($onlineTable->entry_cost > $user?->coins) {
            return $this->errorResponse(__('Cannot play online game'));
        }

        return $this->successResponse(__('Allowed to play'));
    }
}
