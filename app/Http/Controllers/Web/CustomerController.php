<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        return Inertia::render(
            'Contacts/Index',
            [
            'is_customer' => 'true',
            'title'       => 'customer',
            'create_url'  => route('customers.create'),
            'url'         => route('customers.index')
            ]
        );
    }

    public function edit(Contact $customer)
    {
        return Inertia::render(
            'Contacts/Edit',
            [
            'is_customer' => 'true',
            'title'       => 'customer',
            'contact'     => $customer,
            'url'         => route('customers.index')
            ]
        );
    }

    public function create()
    {
        return Inertia::render(
            'Contacts/Create',
            [
            'is_customer' => 'true',
            'title'       => 'customer',
            'url'         => route('customers.index')
            ]
        );
    }
}
