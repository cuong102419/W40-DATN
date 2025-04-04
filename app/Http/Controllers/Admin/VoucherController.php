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
        $vouchers = Voucher::latest('id')->paginate(10);
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
            'type' => ['required'],
            'kind' => ['required'],
            'value' => ['required', 'numeric', 'min:0'],
            'min_total' => ['required'],
            'max_discount' => ['required'],
            'quantity' => ['required', 'integer', 'min:1'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'expiration_date' => ['required', 'date', 'after_or_equal:today'],
        ], [
            'name.required' => 'Tên khuyến mãi không được để trống.',
            'code.required' => 'Mã khuyến mãi không được để trống.',
            'code.min' => 'Mã khuyến mãi phải có ít nhất 4 ký tự.',
            'code.unique' => 'Mã khuyến mãi đã tồn tại, vui lòng nhập mã khác.',
            'value.required' => 'Giá trị khuyến mãi không được để trống.',
            'value.numeric' => 'Giá trị khuyến mãi phải là số.',
            'value.min' => 'Giá trị khuyến mãi phải lớn hơn hoặc bằng 0.',
            'min_total.required' => 'Không được trống.',
            'max_discount.required' => 'Không được trống.',
            'quantity.required' => 'Số lượng không được để trống.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'start_date.required' => 'Ngày bắt đầu không được để trống.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải từ hôm nay trở đi.',
            'expiration_date.required' => 'Ngày hết hạn không được để trống.',
            'expiration_date.date' => 'Ngày hết hạn không hợp lệ.',
            'expiration_date.after_or_equal' => 'Ngày hết hạn phải từ hôm nay trở đi.',
        ]);

        Voucher::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm khuyến mãi thành công.'
        ], Response::HTTP_OK);
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.voucher.edit', compact('voucher'));
    }


    public function update(Request $request, Voucher $voucher)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'code' => ['required', 'string', 'min:4', 'unique:vouchers,code,' . $voucher->id],
            'value' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:1'],
            'expiration_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $voucher->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật khuyến mãi thành công.'

        ], Response::HTTP_OK);
    }


    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->back()->with('success', 'Xóa thành công.');
    }
}
