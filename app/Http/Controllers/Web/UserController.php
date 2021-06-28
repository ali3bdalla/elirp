<?php

    namespace App\Http\Controllers\Web;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Inertia\Inertia;

    class UserController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         */
        public function index() : \Inertia\Response
        {
            return Inertia::render('Users/Index');
        }

        public function create()
        {
            return Inertia::render('Users/Create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param Request $request
         * @return Response
         */
        public function store(Request $request)
        {
            //
        }

        /**
         * Display the specified resource.
         *
         * @param User $user
         * @return Response
         */
        public function show(User $user)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param User $user
         * @return Response
         */
        public function edit(User $user)
        {
            return Inertia::render('Users/Edit', [
                'user' => $user
            ]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param User $user
         * @return Response
         */
        public function destroy(User $user)
        {
            //
        }
    }
