<?php  

namespace Database\Factories;  

use Illuminate\Database\Eloquent\Factories\Factory;  

/**  
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>  
     */  
    class ProductFactory extends Factory  
    {  
        /**  
         * Define the model's default state.  
         *  
         * @return array<string, mixed>  
         */  
        public function definition(): array  
        {  
            $productName = fake()->words(rand(2, 4), true); // Generate 2-4 word product name  
            return [  
                'name' => ucwords($productName),  
                'description' => fake()->paragraph(nbSentences: 3),  
                'price' => fake()->randomFloat(2, 5, 1000), // Price between 5.00 and 1000.00  
                'stock_quantity' => fake()->numberBetween(0, 200),  
                'category' => fake()->randomElement(['Electronics', 'Books', 'Clothing', 'Home Goods', 'Toys']),  
                'image_url' => fake()->optional()->imageUrl(640, 480, 'technics', true), // Placeholder image  
            ];  
        }  
    }  