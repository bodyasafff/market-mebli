<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * php artisan db:seed
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // $this->call(UsersTableSeeder::class);
        self::createUserAdmin();
    }

    static function defaultRun(Faker $faker)
    {
        self::createUserAdmin();
    }

    static function createUserAdmin()
    {
        $model = \App\Models\User::create([
            'role_id' => \App\Models\Datasets\UserRole::ADMIN,
            'email' => 'admin@gmail.com',
            'name' => 'Admin',
            'password' => bcrypt('qwerqwer123')
        ]);
    }
}
