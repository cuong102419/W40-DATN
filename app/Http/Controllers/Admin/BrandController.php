<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BrandController extends Controller
{
    public function index()
    {
        $query = Brand::query();

        // Lọc theo thương hiệu nếu có
        if ($keyword = request()->keyword) {
            $query->where('name', 'like',"%$keyword%");
        }

        $brands =$query->latest('id')->paginate(10);
        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'min:4', 'unique:brands']
        ], [
            'name.required' => 'Tên thương hiệu không được để trống.',
            'name.min'      => 'Tên thương hiệu phải có ít nhất 4 ký tự.',
            'name.unique'   => 'Tên thương hiệu đã tồn tại, vui lòng nhập tên khác.',
            'name.regex'    => 'Tên thương hiệu không hợp lệ.'
        ]);

        Brand::create($data);

        if ($request->ajax()) {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Thêm thương hiệu thành công.'
            ], Response::HTTP_OK);
        }

        return redirect()->back();
    }

    public function edit(Brand $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'min:4', 'unique:brands,name,' . $brand->name]
        ], [
            'name.required' => 'Tên thương hiệu không được để trống.',
            'name.min'      => 'Tên thương hiệu phải có ít nhất 4 ký tự.',
            'name.unique'   => 'Tên thương hiệu đã tồn tại, vui lòng nhập tên khác.',
            'name.regex'    => 'Tên thương hiệu không hợp lệ.'
        ]);

        $brand->update($data);

        if ($request->ajax()) {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Cập nhật thương hiệu thành công.'
            ], Response::HTTP_OK);
        }

        return redirect()->back();
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->back()->with('success', 'Xóa thành công.');
    }
}
