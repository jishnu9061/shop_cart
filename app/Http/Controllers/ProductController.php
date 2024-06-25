<?php

/**
 * Created By: JISHNU T K
 * Date: 2024/06/25
 * Time: 10:56:30
 * Description: ProductController.php
 */

namespace App\Http\Controllers;

use App\Http\Constants\FileDestinations;

use App\Http\Helpers\ToastrHelper;
use App\Http\Helpers\Core\FileManager;

use App\Models\Product;
use App\Models\ProductImage;

use App\Http\Requests\ProductStoreRequest;

use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    /**
     * @return [type]
     */
    public function index()
    {
        $products = Product::select('id', 'name', 'price', 'description')->get();
        return view('pages.product.index', compact('products'));
    }

    /**
     * @return [type]
     */
    public function create()
    {
        return view('pages.product.create');
    }

    /**
     * @param ProductStoreRequest $request
     *
     * @return [type]
     */
    public function store(ProductStoreRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);

        if ($request->hasFile('images')) {
            $uploadedImages = [];
            $failedUploads = [];

            foreach ($request->file('images') as $image) {
                $res = FileManager::upload(FileDestinations::PRODUCT_IMAGE, $image, FileManager::FILE_TYPE_IMAGE);

                if ($res['status']) {
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->file_name = $res['data']['fileName'];
                    $productImage->save();

                    $uploadedImages[] = $res['data']['fileName'];
                } else {
                    $failedUploads[] = $image->getClientOriginalName();
                }
            }

            if (!empty($failedUploads)) {
                abort(400, 'Failed to upload the following images: ' . implode(', ', $failedUploads));
            }
            $product->save();
        }
        $route = route('user.product.index');
        return Response::json(['route' => $route]);
    }

    /**
     * @param Product $product
     *
     * @return [type]
     */
    public function destroy(Product $product)
    {
        $product->delete();
        ToastrHelper::success('Product deleted successfully');
        return Response::json(['success' => 'Category Deleted Successfully']);
    }
}
