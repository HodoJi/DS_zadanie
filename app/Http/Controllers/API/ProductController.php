<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Returns all products.
     * @return JsonResponse
     */
    public function getProducts(): JsonResponse
    {
        return Response()->json(Product::select("id", "name", "desc", "cost", "category_id")->get());
    }

    /**
     * Returns all products for view.
     * @return View
     */
    public function getProductsForView(): View
    {
        $products = Product::select("products.id AS id", "products.name AS name", "products.desc AS desc", "products.cost AS cost", "products.category_id AS category_id", "categories.name AS category_name")->leftJoin("categories", "categories.id", "=", "products.category_id")->get()->toArray();
        foreach($products as $idx => $product)
        {
            if (!$product['category_name'])
            {
                $products[$idx]['category_name'] = "Not in any category";
            }
        }
        return view('products', ["products" => $products]);
    }

    /**
     * Returns product by $id param.
     * @param int $id
     * @return JsonResponse
     */
    public function getProductById(int $id): JsonResponse
    {
        return Response()->json(Product::select("id", "name", "desc", "cost", "category_id")->find($id));
    }

    /**
     * Returns view for product editing.
     * @param int|string $identifier
     * @return View
     */
    public function editProduct(int|string $identifier): View
    {
        $productToEdit = (is_numeric($identifier)) ? Product::select("id", "name", "desc", "cost", "category_id")->find(id:$identifier) : NULL;

        if (isset($productToEdit))
        {
            return view('edit-category', ["category" => $productToEdit]);
        }
        else
        {
            return view('categories');
        }
    }

    /**
     * Delete product by $identifier from Request.
     * @param Request $req
     * @return RedirectResponse
     */
    public function deleteProduct(Request $req): RedirectResponse
    {
        if ($req->isMethod("delete") && isset($req['product_id']))
        {
            $identifier = $req['product_id'];
            $productToDelete = Product::select("id", "name", "cost")->find(id: $identifier);
            $result = (isset($productToDelete)) ? $productToDelete->delete() : NULL;
            if ($result)
            {
                return redirect()->route('products')
                    ->with("product_deletion_msg", "Product with id '#$productToDelete->id', name '$productToDelete->name' and cost '$productToDelete->cost"."€' was deleted successfully.")
                    ->with("product_deletion_result", "success");
            }
            return redirect()->route('products')
                ->with("product_deletion_msg", "Product with id '#$identifier' could not be deleted properly.")
                ->with("product_deletion_result", "danger");
        }
        return redirect()->route('products');
    }
}
