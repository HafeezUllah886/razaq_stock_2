<?php

namespace Database\Seeders;

use App\Models\accounts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class accountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        accounts::create(
            [
                'title' => "Cash Account",
                'type' => "Business",
                'category' => "Cash"
            ]
        );

        accounts::create(
            [
                'title' => "Salesman",
                'type' => "Salesman",
                
            ]
        );

        accounts::create(
            [
                'title' => "Company",
                'type' => "Company",
            ]
        );
    }
}
