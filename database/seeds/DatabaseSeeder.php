<?php

use App\{Plan, Type};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $types = ['a', 'b', 'c', 'a-2018', 'b-2018', 'c-2018'];
        foreach ($types as $type) {
            Type::create(['name' => $type]);
        }

        $plans = ['hostings', 'vps'];
        foreach ($plans as $plan) {
            Plan::create(['name' => $plan]);
        }
        DB::table('tests_completed')->insert(['count' => 0]);
        $this->call(UsersTableSeeder::class);
    }
}
