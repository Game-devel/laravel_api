<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Product;
class CategoryProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories_id = Category::pluck('id')->toArray();
        $products_id = Product::pluck('id')->toArray();

        $cat_prod_table = [];
        for ($i = 0; $i < count($products_id); $i++) {
            for ($j = 0; $j < count($categories_id); $j++) {
                $cat_prod['category_id'] = $categories_id[$j];
                $cat_prod['product_id'] = $products_id[$i];
                $cat_prod_table[] = $cat_prod;
            }            
        }

        DB::table('category_product')->insert($cat_prod_table);
    }
}
