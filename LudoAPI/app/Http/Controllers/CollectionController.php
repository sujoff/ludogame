<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionCollection;
use App\Models\Collection;
use Illuminate\Http\Request;

/**
 * @group Collection management
 *
 * APIs for managing collection
 */
class CollectionController extends Controller
{
    public function index(Request $request): CollectionCollection
    {
        $collections = Collection::all();

        return new CollectionCollection($collections);
    }
}
