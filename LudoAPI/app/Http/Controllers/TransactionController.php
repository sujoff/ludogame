<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyCoinRequest;
use App\Http\Requests\BuyCollectionRequest;
use App\Http\Requests\BuyGemRequest;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\UserTransactionRequest;
use App\Http\Resources\TransactionCollection;
use App\Http\Resources\TransactionResource;
use App\Models\Collection;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @group Transaction management
 *
 * APIs for managing users
 */
class TransactionController extends Controller
{
    public function index(Request $request): TransactionCollection
    {
        $transactions = Transaction::all();

        return new TransactionCollection($transactions);
    }

    public function userTransactions(UserTransactionRequest $request): TransactionCollection
    {
        $transactions = Transaction::where('external_id', $request->validated('external_id'))->paginate();

        return new TransactionCollection($transactions);
    }

    public function store(TransactionStoreRequest $request): TransactionResource
    {
        $input  = $request->validated();

        $collection = Collection::where('code', $input['code'])->first();
        $user = User::where('external_id', $input['external_id'])->first();

        $data = [
            'collection_id' => $collection->id,
            'user_id' => $user->id,
            'currency_type' => $input['currency_type'],
            'amount' => $input['amount'],
        ];
        $input['user_id'] = $user->id;
        $transaction = Transaction::create($data);

        return new TransactionResource($transaction);
    }

    public function buyCoins(BuyCoinRequest $request): TransactionResource
    {
        $input  = $request->validated();
        $user = User::where('external_id', $input['external_id'])->first();
        $collection = Collection::where('code', $input['code'])->first();

        $user->coins = $user->coins + $input['coin'];
        $user->save();
        $input['user_id'] = $user->id;
        $input['collection_id'] = $collection->id;
        $transaction = Transaction::create($input);

        return new TransactionResource($transaction);

    }

    public function buyGems(BuyGemRequest $request): TransactionResource
    {
        $input  = $request->validated();
        $user = User::where('external_id', $input['external_id'])->first();

        $user->gem = $user->gem + $input['gem'];
        $user->save();
        $input['user_id'] = $user->id;
        $transaction = Transaction::create($input);

        return new TransactionResource($transaction);

    }

    public function buyCollections(BuyCollectionRequest $request): TransactionResource
    {
        $input  = $request->validated();
        $user = User::where('external_id', $input['external_id'])->first();

        if ($input['currency_type'] == 'COIN') {
            $user->coin = $user->coin - $input['amount'];
        } else if ($input['currency_type'] == 'GEM') {
            $user->gem = $user->gem - $input['amount'];
        } else if ($input['currency_type'] == 'ADS') {
            //$user->ads = $input['amount'];
        }

        $user->save();

        $transaction = Transaction::create($input);

        return new TransactionResource($transaction);

    }
}
