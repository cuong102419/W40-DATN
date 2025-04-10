<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ImageList;
use App\Models\ImageVariant;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::query();

        if($keyword = request()->keyword) {
            $query->where('name', 'like', "%$keyword%")
                  ->orWhere('sku', 'like', "%$keyword%");
        }

        $products = $query->with('imageLists')->latest('id')->paginate(10);

        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('admin.product.create', compact('brands', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sku'           => ['required', 'min:4', 'unique:products'],
            'name'          => ['required', 'min:4', 'unique:products'],
            'category_id'   => ['required'],
            'brand_id'      => ['required'],
            'discount'      => ['required'],
            'featured'      => ['nullable'],
            'description'   => ['required']
        ], [
            'sku.required'          => 'Mã sản phẩm không được để trống.',
            'sku.min'               => 'Mã sản phẩm tối thiểu 4 kí tự.',
            'sku.unique'            => 'Mã sản phẩm đã tồn tại. Hãy chọn mã khác.',
            'name.required'         => 'Tên sản phẩm không được để trống.',
            'name.min'              => 'Tên sản phẩm tối thiểu 4 kí tự.',
            'name.unique'           => 'Tên sản phẩm đã tồn tại. Hãy chọn tên khác.',
            'category_id.required'  => 'Vui lòng chọn loại sản phẩm.',
            'brand_id.required'     => 'Vui lòng chọn hãng sản phẩm.',
            'description.required'  => 'Mô tả không được để trống.',
            'discount.required'     => 'Giá trị giảm giá không được để trống'
        ]);

        Product::create($data);

        if ($request->ajax()) {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Thêm sản phẩm thành công.'
            ], Response::HTTP_OK);
        }

        return redirect()->back();
    }

    public function detail(Product $product)
    {
        $images = ImageList::where('product_id', $product->id)->get();

        return view('admin.product.detail', compact('product', 'images'));
    }

    public function edit(Product $product)
    {
        $brands = Brand::all();
        $categories = Category::all();

        return view('admin.product.edit', compact('product', 'brands', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'sku'           => ['required', 'min:4', Rule::unique('products')->ignore($product->id)],
            'name'          => ['required', 'min:4', Rule::unique('products')->ignore($product->id)],
            'category_id'   => ['required'],
            'brand_id'      => ['required'],
            'discount'      => ['required'],
            'featured'      => ['nullable'],
            'description'   => ['required']
        ], [
            'sku.required'          => 'Mã sản phẩm không được để trống.',
            'sku.min'               => 'Mã sản phẩm tối thiểu 4 kí tự.',
            'sku.unique'            => 'Mã sản phẩm đã tồn tại. Hãy chọn mã khác.',
            'name.required'         => 'Tên sản phẩm không được để trống.',
            'name.min'              => 'Tên sản phẩm tối thiểu 4 kí tự.',
            'name.unique'           => 'Tên sản phẩm đã tồn tại. Hãy chọn tên khác.',
            'category_id.required'  => 'Vui lòng chọn loại sản phẩm.',
            'brand_id.required'     => 'Vui lòng chọn hãng sản phẩm.',
            'description.required'  => 'Mô tả không được để trống.',
            'discount.required'     => 'Giá trị giảm giá không được để trống'
        ]);

        if (!$request->has('featured')) {
            $data['featured'] = 0;
        }

        $product->update($data);


        return response()->json([
            'status'    => 'success',
            'message'   => 'Cập nhật sản phẩm thành công.'
        ], Response::HTTP_OK);
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return redirect()->back()->with('success', 'Xóa sản phẩm thành công.');
        } catch (\Throwable $th) {
            return redirect()->route('admin-product.index')->with('error', 'Xóa sản phẩm thất bại.');
        }
    }
}
