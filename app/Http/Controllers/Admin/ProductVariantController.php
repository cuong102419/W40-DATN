<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductVariantController extends Controller
{
    public function index(Product $product)
    {
        $variants = ProductVariant::where('product_id', $product->id)->latest('id')->paginate(10);
        return view('admin.product-variant.index', compact('product', 'variants'));
    }

    public function create(Product $product)
    {

        return view('admin.product-variant.create', compact('product'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['nullable'],
            'quantity' => ['required'],
            'price' => ['required'],
            'size' => ['required'],
            'color' => ['nullable']
        ], [
            'quantity.required' => 'Số lượng không được để trống.',
            'price.required' => 'Giá không được để trống.',
            'size.required' => 'Kích cỡ không được để trống.'
        ]);
        
        ProductVariant::create($data);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Tạo mới biến thể thành công.'
            ], Response::HTTP_OK);
        }

        return redirect()->back();
    }
}
