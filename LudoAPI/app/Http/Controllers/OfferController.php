<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfferCollection;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index(Request $request): OfferCollection
    {
        $offers = Offer::with(['collections'])->get();

        return new OfferCollection($offers);
    }
}
