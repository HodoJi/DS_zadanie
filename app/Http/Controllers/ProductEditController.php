<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductEditController extends Controller
{
    public function editProduct(int|string $product_id)
    {
        $productToEdit = Product::select("id", "name", "desc", "cost", "category_id")->find(id:$product_id);

        if(isset($productToEdit['id']))
        {
            $categoryNameOfProduct = Category::select("name")->find(id:$productToEdit['category_id']);

            $allCategories = Category::select("id", "name")->get();

            return view("product-edit", [
                "product_id" => $productToEdit['id'],
                "product_name" => $productToEdit['name'],
                "product_desc" => $productToEdit['desc'],
                "product_cost" => $productToEdit['cost'],
                "product_category_id" => ($productToEdit['category_id'] ?? null),
                "product_category_name" => ($categoryNameOfProduct ?? "Uncategorized"),
                "categories" => $allCategories
            ]);
        }
        else
        {
            return $this->editProductNotSpecified();
        }
    }

    public function editProductSave(Request $req)
    {

    }

    /**
     * Product editing - Not specified product to edit.
     * @return RedirectResponse
     */
    public function editProductNotSpecified(): RedirectResponse
    {
        return redirect(route("products"))->with([
            "product_deletion_msg" => "Specified product does not exist or cannot be edited.",
            "product_deletion_result" => "danger"
        ]);
    }
}
