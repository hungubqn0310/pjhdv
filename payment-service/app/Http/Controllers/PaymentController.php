<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function thankYou()
    {
        return view('payments.thank_you');  // Trả về trang cảm ơn
    }

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

    // Hàm gửi yêu cầu POST cho MoMo
    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        // Bỏ qua chứng chỉ SSL (không khuyến khích cho môi trường sản xuất)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Lỗi cURL: ' . curl_error($ch);  // In ra lỗi cURL nếu có
        } else {
            echo 'Kết quả: ' . $result;  // In ra kết quả trả về nếu không có lỗi
        }
        curl_close($ch);

        return $result;
    }

    // Xử lý thanh toán online
    public function online_checkout(Request $request)
    {
        if ($request->has('cod')) {
            // Xử lý thanh toán COD
            echo 'Thanh toán COD';
        } elseif ($request->has('payUrl')) {
            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
            $orderInfo = "Thanh toán qua MoMo";
            $amount = "10000";
            $orderId = rand(00,9999);  // Tạo mã đơn hàng ngẫu nhiên
            $redirectUrl = route('thank-you');  // Sử dụng route() thay vì URL cố định
            $ipnUrl = route('thank-you');
            $extraData = "";

            $requestId = time() . "";
            $requestType = "payWithATM";

            // Tạo chuỗi rawHash để ký
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            $data = array(
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                'storeId' => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );

            // Gửi yêu cầu và nhận phản hồi từ MoMo
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);

            // Kiểm tra phản hồi JSON
            if ($jsonResult === null) {
                echo 'Lỗi: Phản hồi JSON không hợp lệ';
            } else {
                if (isset($jsonResult['payUrl'])) {
                    // Chuyển hướng người dùng đến URL thanh toán của MoMo
                    return redirect()->to($jsonResult['payUrl']);
                }   
            }
        } 
        elseif ($request->has('vnpay')) {
            // Xử lý thanh toán VNPay
            $vnp_TmnCode = "LNYT5TSP"; // Mã website của bạn tại VNPay
            $vnp_HashSecret = "AGNY8FESHX982OTPP9KUKQFGK0EZH40H"; // Khóa bí mật của bạn
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = route('thank-you');
            $vnp_TxnRef = rand(100000, 999999); // Mã giao dịch duy nhất
            $vnp_OrderInfo = "Thanh toán đơn hàng #" . $vnp_TxnRef;
            $vnp_OrderType = "billpayment";
            $vnp_Amount = 10000 * 100; // Số tiền, nhân 100 để tính theo VND
            $vnp_Locale = "vn";
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            );
    
            // Sắp xếp dữ liệu theo thứ tự tăng dần và tạo chuỗi ký
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . $key . "=" . $value;
                } else {
                    $hashdata .= $key . "=" . $value;
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }
    
            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
    
            // Chuyển hướng người dùng đến cổng thanh toán VNPay
            return redirect()->to($vnp_Url);
        }
        
    }
}
