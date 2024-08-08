<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    
        public function index()
        {
            $items = Item::all();
            return response()->json($items);
        }
    
        public function store(Request $request)
        {
            $item = Item::create($request->all());
            return response()->json($item, 201);
        }
    
}
