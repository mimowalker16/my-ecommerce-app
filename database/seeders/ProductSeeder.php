<?php  

namespace Database\Seeders;  

use Illuminate\Database\Console\Seeds\WithoutModelEvents;  
use Illuminate\Database\Seeder;  
use App\Models\Product;  

class ProductSeeder extends Seeder  
{  
    /**  
         * Run the database seeds.  
         */  
        public function run(): void  
        {  
            // Create 50 random products  
            Product::factory(50)->create();  
        }  
    }  