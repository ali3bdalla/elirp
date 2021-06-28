<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Inertia\Inertia;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index() : \Inertia\Response
    {
        return Inertia::render('Items/Index');
    }

    public function create()
    {
        return Inertia::render('Items/Create');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Item $item
     * @return Response
     */
    public function edit(Item $item)
    {
        return Inertia::render('Items/Edit', [
            'item' => $item
        ]);
    }
}
