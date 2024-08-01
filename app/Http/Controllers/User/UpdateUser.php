<?php

    namespace App\Http\Controllers\User;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\User\UpdateUserRequest;
    use App\Http\Resources\UserResource;
    use App\Models\User;
    use App\Repositories\UserRepositoryInterface;

    class UpdateUser extends Controller
    {

        public function __invoke( User $user , UpdateUserRequest $request ): UserResource
        {
            return UserResource::make(
                app( UserRepositoryInterface::class )->update( $request->validated() , $user->id )
            );
        }

        public function UpdateMyInfo( UpdateUserRequest $request ): UserResource
        {
            return UserResource::make(
                app( UserRepositoryInterface::class )->update( $request->validated() , auth()->id() )
            );
        }

    }
