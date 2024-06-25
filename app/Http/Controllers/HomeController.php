<?php

/**
 * Created By: JISHNU T K
 * Date: 2024/06/25
 * Time: 10:55:01
 * Description: HomeController.php
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * @return [type]
     */
    public function index()
    {
        $products = DB::table('products')
            ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->select('products.id', 'products.name', 'products.price', 'products.description', 'products.created_at', DB::raw('MIN(product_images.file_name) as file_name'))
            ->groupBy('products.id', 'products.name', 'products.description', 'products.created_at', 'products.price')
            ->get();
        return view('pages.shop.index', compact('products'));
    }

    /**
     * @param Request $request
     *
     * @return [type]
     */
    public function addToCart(Request $request)
    {
        $productId = $request->input('id');
        $productName = $request->input('name');
        $productPrice = $request->input('price');
        $cart = $request->session()->get('cart', []);
        $found = false;
        foreach ($cart as &$item) {
            if ($item['id'] == $productId) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $cart[] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => 1
            ];
        }
        $request->session()->put('cart', $cart);
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        return response()->json(['success' => true, 'totalQuantity' => $totalQuantity]);
    }

    /**
     * @return [type]
     */
    public function cart()
    {
        $cartItems = session()->get('cart', []);
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        return view('pages.shop.cart', compact('cartItems', 'totalPrice'));
    }
}
