<?php

    namespace Database\Seeders;

    use App\Models\User;
    use Illuminate\Database\Seeder;

    class UserSeeder extends Seeder
    {
        public function run()
        {
            User::query()->updateOrCreate(
                [
                    "id" => 1
                ] ,
                [
                    "name" => "Mahdi Purhosseini" ,
                    "cell_number" => "09129677294" ,
                    "role" => "admin" ,
                    "verified" => 1 ,
                    "password" => bcrypt( "12345678" )
                ]
            );
        }
    }


