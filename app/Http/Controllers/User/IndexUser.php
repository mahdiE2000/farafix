<?php

    namespace App\Http\Controllers\User;

    use App\Http\Controllers\Controller;
    use App\Http\Resources\UserResource;
    use App\Repositories\UserRepositoryInterface;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

    class IndexUser extends Controller
    {

        public function __invoke(): AnonymousResourceCollection
        {
            return UserResource::collection(
                app(UserRepositoryInterface::class)->index()
            );
        }

    }
