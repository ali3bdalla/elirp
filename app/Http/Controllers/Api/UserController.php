<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\User;
use App\Services\User\Features\StoreUserFeature;
use App\Services\User\Features\UserTableFeature;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;

    class UserController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function index()
        {
            return $this->serve(UserTableFeature::class);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return Response
         */
        public function create()
        {
            //
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param Request $request
         * @return Response
         */
        public function store()
        {
            return $this->serve(StoreUserFeature::class);
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
         * Show the form for editing the specified resource.
         *
         * @param User $user
         * @return Response
         */
        public function edit(User $user)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param Request $request
         * @param User $user
         * @return Response
         */
        public function update(Request $request, User $user)
        {
            //
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
