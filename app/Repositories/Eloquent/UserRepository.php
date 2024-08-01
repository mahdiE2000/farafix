<?php

    namespace App\Repositories\Eloquent;

    use App\Models\User;
    use App\Repositories\UserRepositoryInterface;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;

    class UserRepository implements UserRepositoryInterface
    {
        public function destroy( int $userId )
        {
            $user = User::findOrFail( $userId );
            return $user->delete();
        }

        public function index()
        {
            return User::withCount( "requests" )->filtered()->paginate();
        }

        public function show( int $userId )
        {
            return User::with("requests")
                ->withCount("requests")
                ->findOrFail( $userId );
        }

        public function changeRole( int $userId )
        {
            $user = User::findOrFail( $userId );
            $user->role = $user->role == "user" ? "admin" : "user";
            $user->save();
            $user->load( [ "requests" ]  );
            $user->loadCount( [ "requests" ]  );
            return $user;
        }

        public function showMyInfo()
        {
            return User::with("requests")
                ->withCount("requests")
                ->findOrFail( auth()->id() );
        }

        public function store( array $data ): Model|Builder
        {
            $data[ 'password' ] = bcrypt( $data[ 'password' ] );
            $data[ 'verified' ] = 1;
            $user = User::query()->create( $data );
            $user->load( [ "requests" ]  );
            $user->loadCount( [ "requests" ]  );
            return $user;
        }

        public function update( array $data , int $userId )
        {
            $data[ 'password' ] = bcrypt( $data[ "password" ] );
            $user = User::findOrFail( $userId );
            $user->fill( $data );
            $user->load( [ "requests" ]  );
            $user->loadCount( [ "requests" ]  );
            $user->save();
            return $user;
        }
    }
