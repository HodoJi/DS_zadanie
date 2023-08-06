<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
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
     * Returns all products for view by defined $category_id.
     * @param int|string $category_id
     * @return View|RedirectResponse
     */
    public function getProductsForViewByCategoryId(int|string $category_id): View|RedirectResponse
    {
        if(is_numeric($category_id))
        {
            $category = Category::select("id", "name")->find($category_id);
            $products = $category->products()->get();
            return view('products', [
                "products" => $products,
                "products_category_name" => $category['name']
            ]);
        }
        else
        {
            return redirect(route("products"));
        }
    }

    /**
     * Returns view for product editing.
     * @param int|string $identifier
     * @return View
     */
    public function editProduct(int|string $identifier): View
    {
        $productToEdit = (is_numeric($identifier)) ? Product::select("id", "name", "desc", "cost", "category_id", "created_at", "updated_at")->find(id:$identifier) : null;

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
            $result = (isset($productToDelete)) ? $productToDelete->delete() : null;
            if ($result)
            {
                return redirect()->route('products')->with([
                        "product_deletion_msg" => "Product with id '#$productToDelete->id', name '$productToDelete->name' and cost '$productToDelete->cost"."€' was deleted successfully.",
                        "product_deletion_result" => "success"
                    ]);
            }
            return redirect()->route('products')->with([
                    "product_deletion_msg" => "Product with id '#$identifier' could not be deleted properly.",
                    "product_deletion_result" => "danger"
                ]);
        }
        return redirect()->route('products');
    }

    // <==========================================================================================================> //
    // <==============================================[↓ API PART ↓]==============================================> //
    // <==========================================================================================================> //

    /**
     * API: Returns all products.
     * @return JsonResponse
     */
    public function getProducts(): JsonResponse
    {
        return Response()->json(Product::select("id", "name", "desc", "cost", "category_id", "created_at", "updated_at")->get());
    }

    /**
     * API: Returns all products in category defined by $category_identifier (id|slug).
     * @param int|string $category_identifier
     * @return JsonResponse
     */
    public function getProductsByCategoryIdOrSlug(int|string $category_identifier): JsonResponse
    {
        if(is_numeric($category_identifier))
        {
            $products = Category::find($category_identifier)->products()->get();
        }
        else
        {
            $products = Product::select("products.id AS id", "products.name AS name", "products.desc AS desc", "products.cost AS cost", "products.category_id AS category_id", "products.created_at AS created_at", "products.updated_at AS updated_at")->leftJoin("categories", "categories.id", "=", "products.category_id")->where("categories.slug", "like", $category_identifier)->get()->toArray();
        }
        return Response()->json($products);
    }

    /**
     * API: Returns product by $id param.
     * @param int $id
     * @return JsonResponse
     */
    public function getProductById(int $id): JsonResponse
    {
        return Response()->json(Product::select("id", "name", "desc", "cost", "category_id", "created_at", "updated_at")->find($id));
    }
}
