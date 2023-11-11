<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            //DesignationsSeeder::class,
            //PlaceOfWorkSeeder::class,
           // SubDepartmentSeeder::class,
            //PlaceOfPayrollSeeder::class,
            premission::class,
            modulePermission::class,
        ]);
    }
}
