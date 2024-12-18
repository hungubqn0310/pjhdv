<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import Log
class HomeController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');  // Tạo view register.blade.php trong resources/views
    }
    public function register(Request $request)
    {
        // Lấy dữ liệu từ request
        $data = $request->only(['username', 'password', 'email', 'phone_number', 'address']);

        // Gửi yêu cầu POST đến API đăng ký của user-service
        $response = Http::post('http://localhost:8000/register', $data);
        dd($response);

        // Log::debug('User-service response:', ['response' => $response->body()]);
        // Kiểm tra kết quả phản hồi từ user-service 
        if ($response->successful()) {
            // Trả về thông báo đăng ký thành công
            return response()->json(['message' => 'User registered successfully.']);
        }

        // Trả về lỗi nếu đăng ký thất bại
        return response()->json(['message' => 'Registration failed.', 'error' => $response->json()], $response->status());
    }
}
