<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'opdrachtgever'],
            ['name' => 'coordinator'],
            ['name' => 'lid'],
        ]);
    }
}
