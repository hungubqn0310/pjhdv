<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Danh sách người dùng
    public function index()
    {
        $users = User::where('is_deleted', false)->get(); // Lấy người dùng không bị xóa
        return view('users.index', compact('users'));
    }

    // Hiển thị form tạo người dùng
    public function create()
    {
        return view('users.create');
    }

    // Lưu người dùng mới
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:User_PJ,username|max:255',
            'password' => 'required|min:6',
            'email' => 'required|email|unique:User_PJ,email',
            'phone_number' => 'nullable|digits_between:10,15',
            'address' => 'nullable|max:255',
        ]);

        User::create([
            'username' => $request->username,
            'password' => $request->password, // Sẽ được mã hóa nhờ setPasswordAttribute
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'role_id' => $request->role_id,
            'is_deleted' => false,
        ]);

        return redirect()->route('users.index')->with('success', 'Người dùng đã được tạo thành công!');
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|max:255|unique:User_PJ,username,' . $id . ',user_id',
            'email' => 'required|email|unique:User_PJ,email,' . $id . ',user_id',
            'phone_number' => 'nullable|digits_between:10,15',
            'address' => 'nullable|max:255',
        ]);

        $user->update($request->only('username', 'email', 'phone_number', 'address', 'role_id'));

        if ($request->filled('password')) {
            $user->password = $request->password; // Sẽ được mã hóa nhờ setPasswordAttribute
            $user->save();
        }

        return redirect()->route('users.index')->with('success', 'Thông tin người dùng đã được cập nhật!');
    }

    // Xóa mềm người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_deleted' => true]);

        return redirect()->route('users.index')->with('success', 'Người dùng đã được xóa!');
    }
}
