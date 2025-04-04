<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CollectionController
 */
final class CollectionControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $collections = Collection::factory()->count(3)->create();

        $response = $this->get(route('collections.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }
}
