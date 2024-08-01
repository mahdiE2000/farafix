<?php

    namespace App\Http\Controllers\User;

    use App\Http\Controllers\Controller;
    use App\Http\Resources\UserResource;
    use App\Models\User;
    use App\Repositories\UserRepositoryInterface;

    class ShowUser extends Controller
    {

        public function __invoke( User $user ): UserResource
        {
            return UserResource::make(
                app(UserRepositoryInterface::class)->show($user->id)
            );
        }

        public function ShowMyInfo(): UserResource
        {
            return UserResource::make(
                app(UserRepositoryInterface::class)->showMyInfo()
            );
        }

    }
