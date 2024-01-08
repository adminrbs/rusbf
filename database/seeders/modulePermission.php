<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class modulePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
DB::table('module_permissions')->insert([
    ['module_id' => '1','permission_id' => '1','created_at' => Carbon::now(),'updated_at' => Carbon::now()], //1
    ['module_id' => '1','permission_id' => '2','created_at' => Carbon::now(),'updated_at' => Carbon::now()], //2
    ['module_id' => '1','permission_id' => '3','created_at' => Carbon::now(),'updated_at' => Carbon::now()], //3
    ['module_id' => '1','permission_id' => '4','created_at' => Carbon::now(),'updated_at' => Carbon::now()], //4
    ['module_id' => '1','permission_id' => '5','created_at' => Carbon::now(),'updated_at' => Carbon::now()], //4
    ['module_id' => '1','permission_id' => '6','created_at' => Carbon::now(),'updated_at' => Carbon::now()], //4
    ['module_id' => '1','permission_id' => '7','created_at' => Carbon::now(),'updated_at' => Carbon::now()], //4
    ['module_id' => '1','permission_id' => '8','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '9','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '10','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '11','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '12','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '13','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '14','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '15','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '16','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '17','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '18','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '19','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '20','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '21','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '22','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '23','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '24','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '25','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '26','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '27','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '28','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '29','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '30','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '31','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '32','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '33','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '34','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '35','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '36','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '37','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
    ['module_id' => '1','permission_id' => '38','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
]);
    }
}
