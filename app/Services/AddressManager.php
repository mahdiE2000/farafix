<?php

    namespace App\Services;

    use Illuminate\Support\Arr;

    class AddressManager
    {

        public static function destroy( $model ): void
        {
            $model->addresses()->delete();
        }

        public static function create( $address , $model ): void
        {
            if ($address != [] and $address != null){
                $model->addresses()->create( $address );
            }
        }

        public static function delete( $addresses , $model ): void
        {
            $addresses = Arr::get( $addresses , 'delete' , [] );
            if ( ! empty( $addresses ) ) {
                $model->addresses()->whereIn( 'id' , $addresses )->delete();
            }
        }

    }
