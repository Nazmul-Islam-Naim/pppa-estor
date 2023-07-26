<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designations = ['DG'];

        foreach($designations as $designation){
            Designation::updateOrCreate([
                'title' => $designation,
                'slug' => Str::slug($designation),
            ]);
        }
    }
}
