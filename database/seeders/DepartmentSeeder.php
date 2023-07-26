<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = ['Administration',"Accounts"];

        foreach($departments as $department){
            Department::updateOrCreate([
                'title' => $department,
                'slug' => Str::slug($department),
            ]);
        }
    }
}
