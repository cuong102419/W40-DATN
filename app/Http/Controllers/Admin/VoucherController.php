<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VoucherController extends Controller
{
    
    public function index()
    {
        $vouchers = Voucher::paginate(10);
        return view('admin.voucher.index', compact('vouchers'));
    }

    
    public function create()
    {
        return view('admin.voucher.create');
    }

    
    public function store(Request $request)
    {


        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'code' => ['required', 'string', 'min:4', 'unique:vouchers,code'],
            'value' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:1'],
        ], [
            'name.required' => 'Tên khuyến mãi không được để trống.',
            'code.required' => 'Mã khuyến mãi không được để trống.',
            'code.min' => 'Mã khuyến mãi phải có ít nhất 4 ký tự.',
            'code.unique' => 'Mã khuyến mãi đã tồn tại, vui lòng nhập mã khác.',
            'value.required' => 'Giá trị khuyến mãi không được để trống.',
            'value.numeric' => 'Giá trị khuyến mãi phải là số.',
            'value.min' => 'Giá trị khuyến mãi phải lớn hơn hoặc bằng 0.',
            'quantity.required' => 'Số lượng không được để trống.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
        ]);

        $data = $request->only(['name', 'code', 'value', 'quantity']);
        $data['product_id'] = $request->product_id ?? null;

        Voucher::create($data);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Thêm khuyến mãi thành công.'
            ], Response::HTTP_OK);
        }

        return redirect()->back()->with('success', 'Thêm khuyến mãi thành công.');
    }

    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
        //
    }

    
    public function update(Request $request, string $id)
    {
        //
    }

   
    public function destroy(string $id)
    {
        //
    }
}
