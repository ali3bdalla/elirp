<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Inertia\Inertia;

class VendorController extends Controller
{
    public function index()
    {
        return Inertia::render('Contacts/Index', [
            'is_vendor'  => 'true',
            'title'      => 'Vendor',
            'create_url' => route('vendors.create'),
            'url'        => route('vendors.index')
        ]);
    }

    public function create()
    {
        return Inertia::render('Contacts/Create', [
            'is_vendor' => 'true',
            'title'     => 'Vendor',
            'url'       => route('vendors.index')
        ]);
    }

    public function edit(Contact $vendor)
    {
        return Inertia::render('Contacts/Edit', [
            'is_vendor' => 'true',
            'contact'   => $vendor,
            'title'     => 'Vendor',
            'url'       => route('vendors.index')
        ]);
    }
}
