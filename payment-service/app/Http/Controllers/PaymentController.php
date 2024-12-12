<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Hiển thị form tạo thanh toán mới
    public function create()
    {
        return view('payments.create');  // Trả về form tạo thanh toán
    }

    // Lưu thanh toán mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        // Xác thực dữ liệu từ form
        $data = $request->validate([
            'order_id' => 'required|integer',
            'payment_method' => 'required|string|max:50',
            'payment_status' => 'required|string|max:50',
            'amount' => 'required|numeric',
        ]);

        // Tạo thanh toán mới và lưu vào cơ sở dữ liệu
        $payment = Payment::create($data);

        // Redirect về danh sách thanh toán sau khi lưu
        return redirect()->route('payments.index');
    }

    // Hiển thị danh sách thanh toán
    public function index()
    {
        $payments = Payment::all();
        return view('payments.index', compact('payments'));
    }

    // Hiển thị thông tin thanh toán theo ID
    public function show($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        return view('payments.show', compact('payment'));
    }
}
