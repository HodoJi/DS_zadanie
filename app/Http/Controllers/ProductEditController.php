<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductEditController extends Controller
{
    /**
     * Product editing - returns view with required values if specified product exists, redirects to 'products' otherwise.
     * @param int|string $product_id
     * @return View|RedirectResponse
     */
    public function editProduct(int|string $product_id): View|RedirectResponse
    {
        $productToEdit = Product::select("id", "name", "desc", "cost", "category_id")->find(id:$product_id);

        if(isset($productToEdit['id']))
        {
            $allCategories = Category::select("id", "name")->get();

            return view("product-edit", [
                "product_id" => $productToEdit['id'],
                "product_name" => $productToEdit['name'],
                "product_desc" => $productToEdit['desc'],
                "product_cost" => $productToEdit['cost'],
                "product_category_id" => ($productToEdit['category_id'] ?? null),
                "categories" => $allCategories
            ]);
        }
        else
        {
            return $this->editProductNotSpecified();
        }
    }

    /**
     * Product editing - form save function.
     * @param Request $req
     * @return View
     */
    public function editProductSave(Request $req): View
    {
        $productId = $req['product_id'];
        $productName = $req['product_name'];
        $productDesc = $req['product_desc'];
        $productCost = str_replace(",", ".", $req['product_cost']);
        $productCost = doubleval($productCost);
        $productCategoryId = $req['product_category_id'] ?? null;

        $allCategories = Category::select("id", "name")->get();

        $validation = (
            (strlen($productName) <= 255 && strlen($productName) > 0) &&
            (strlen($productDesc) <= 255 && strlen($productDesc) > 0) &&
            ($productCost >= 0)
        );

        if ($validation)
        {
            $productToUpdate = Product::find(id:$productId);

            $updateResult = $productToUpdate->update([
                "name" => $productName,
                "desc" => $productDesc,
                "cost" => $productCost,
                "category_id" => $productCategoryId
            ]);
        }
        else
        {
            $updateResult = false;
        }

        if ($updateResult)
        {
            $productEditResult = [
                "product_edit_result" => "success",
                "product_edit_result_msg" => "Product was updated successfully."
            ];
        }
        else
        {
            $productEditResult = [
                "product_edit_result" => "danger",
                "product_edit_result_msg" => "Product could not be updated properly (length of product name / description cannot be 0 and higher than 255 characters)."
            ];
        }

        return view("product-edit", [
            "product_id" => $productId,
            "product_name" => $productName,
            "product_desc" => $productDesc,
            "product_cost" => $productCost,
            "product_category_id" => $productCategoryId,
            "product_edit_result" => $productEditResult['product_edit_result'],
            "product_edit_result_msg" => $productEditResult['product_edit_result_msg'],
            "categories" => $allCategories
        ]);
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
