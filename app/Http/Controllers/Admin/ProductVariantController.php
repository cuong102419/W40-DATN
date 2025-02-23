<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        try {
            $data = $request->validate([
                'product_id' => ['nullable'],
                'quantity' => ['required'],
                'price' => ['required'],
                'size' => [
                    'required',
                    Rule::unique('product_variants')->where(function ($query) use ($request) {
                        return $query->where('product_id', $request->product_id)
                            ->where('color', $request->color);
                    })
                ],
                'color' => [
                    'nullable',
                    Rule::unique('product_variants')->where(function ($query) use ($request) {
                        return $query->where('product_id', $request->product_id)
                            ->where('size', $request->size);
                    })
                ]
            ], [
                'quantity.required' => 'Số lượng không được để trống.',
                'price.required' => 'Giá không được để trống.',
                'size.required' => 'Kích cỡ không được để trống.',
                'size.unique' => 'Kích cỡ và màu sắc này đã tồn tại cho sản phẩm này.',
                'color.unique' => 'Màu sắc và kích cỡ này đã tồn tại cho sản phẩm này.'
            ]);

            ProductVariant::create($data);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Tạo mới biến thể thành công.'
                ], Response::HTTP_OK);
            }

            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    public function edit(Product $product, ProductVariant $variant)
    {
        return view('admin.product-variant.edit', compact('variant', 'product'));
    }

    public function update(Request $request, ProductVariant $variant)
    {
        try {
            $data = $request->validate([
                'product_id' => ['nullable'],
                'quantity' => ['required'],
                'price' => ['required'],
                'size' => [
                    'required',
                    Rule::unique('product_variants')->where(function ($query) use ($request) {
                        return $query->where('product_id', $request->product_id)
                            ->where('color', $request->color);
                    })
                ],
                'color' => [
                    'nullable',
                    Rule::unique('product_variants')->where(function ($query) use ($request) {
                        return $query->where('product_id', $request->product_id)
                            ->where('size', $request->size);
                    })
                ]
            ], [
                'quantity.required' => 'Số lượng không được để trống.',
                'price.required' => 'Giá không được để trống.',
                'size.required' => 'Kích cỡ không được để trống.',
                'size.unique' => 'Kích cỡ và màu sắc này đã tồn tại cho sản phẩm này.',
                'color.unique' => 'Màu sắc và kích cỡ này đã tồn tại cho sản phẩm này.'
            ]);

            $variant->update($data);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Cập nhật biến thể thành công.'
                ], Response::HTTP_OK);
            }

            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    public function destroy(ProductVariant $variant)
    {
        try {
            $variant->delete();

        return redirect()->back()->with('success', 'Xóa biến thể thành công.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }
}
