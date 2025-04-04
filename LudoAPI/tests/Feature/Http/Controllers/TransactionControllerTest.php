<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Collection;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TransactionController
 */
final class TransactionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $transactions = Transaction::factory()->count(3)->create();

        $response = $this->get(route('transactions.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TransactionController::class,
            'store',
            \App\Http\Requests\TransactionStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $user = User::factory()->create();
        $collection = Collection::factory()->create();

        $response = $this->post(route('transactions.store'), [
            'user_id' => $user->id,
            'collection_id' => $collection->id,
        ]);

        $transactions = Transaction::query()
            ->where('user_id', $user->id)
            ->where('collection_id', $collection->id)
            ->get();
        $this->assertCount(1, $transactions);
        $transaction = $transactions->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }
}
