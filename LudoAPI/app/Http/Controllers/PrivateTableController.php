<?php

namespace App\Http\Controllers;

use App\Http\Resources\PrivateTableResource;
use App\Models\PrivateTable;
use App\Models\User;

class PrivateTableController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return PrivateTableResource::collection(PrivateTable::all());
    }

    public function show(string $id): PrivateTableResource
    {
        return PrivateTableResource::make(PrivateTable::query()->find($id));
    }

    public function check(string $id, string $externalId): \Illuminate\Http\JsonResponse
    {
        $onlineTable = PrivateTable::query()->find($id);
        $user = User::where('external_id', $externalId)->first();

        if ($onlineTable->entry_cost > $user?->coins) {
            return $this->errorResponse(__('Cannot play online game'));
        }

        return $this->successResponse(__('Allowed to play'));
    }
}
