<?php

namespace App\Http\Controllers\Card;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardResource;
use App\Models\Card;

class ListCardsController extends Controller
{
    public function index()
    {
        return CardResource::collection(Card::all());
    }
}
