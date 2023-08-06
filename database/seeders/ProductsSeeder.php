<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     *
     * @return void
     */
    public function run(): void
    {
        $products = [
            1 => [
                'name' => 'Fiat Punto',
                'desc' => 'Malé auto od automobilky Fiat',
                'cost' => 2400,
                'category_id' => 1
            ],
            2 => [
                'name' => 'Ford Ranger',
                'desc' => 'Veľké auto od automobilky Ford',
                'cost' => 42000,
                'category_id' => 2
            ]
        ];

        foreach ($products as $product_id => $productData)
        {
            $category = Product::find($product_id);

            if(!$category)
            {
                $newProduct = new Product();
                $newProduct['id'] = $product_id;
                $newProduct['name'] = $productData['name'];
                $newProduct['desc'] = $productData['desc'];
                $newProduct['cost'] = $productData['cost'];
                if (isset($productData['category_id']))
                {
                    $newProduct['category_id'] = $productData['category_id'];
                }
                $newProduct->save();
            }
        }
    }
}
