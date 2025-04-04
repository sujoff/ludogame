<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Offer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OfferController
 */
final class OfferControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $offers = Offer::factory()->count(3)->create();

        $response = $this->get(route('offers.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }
}
