<?php

namespace Database\Seeders;

use App\Models\products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class productsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => "1.5Kw Invertor", "pprice" => 35000, 'catID' => 1],
            ['name' => "565 Watt N-Type Solar Panel", "pprice" => 22000, 'catID' => 1],
            ['name' => "Battery", "pprice" => 15000,'catID' => 2],
        ];
        products::insert($data);
    }
}
