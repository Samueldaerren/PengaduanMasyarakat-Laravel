<?php

namespace App\Http\Controllers;

use App\Models\User; // Mengimpor model User
use App\Models\Report;
use App\Models\StaffProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Mengimpor Hash untuk mengenkripsi password

class HeadStaffController extends Controller
{
    // Menampilkan Dashboard
    public function index()
    {
        // Mengambil data pengaduan dan tanggapan berdasarkan provinsi Jawa Barat
        $pengaduan = Report::where('province', 'Jawa Barat')->count(); // Jumlah pengaduan di Jawa Barat
        $tanggapan = Report::where('province', 'Jawa Barat')->whereNotNull('statement')->count(); // Jumlah tanggapan (yang memiliki statement)

        // Mengirim data ke view
        return view('headstaff.dashboard', compact('pengaduan', 'tanggapan'));
    }

    // Menampilkan halaman Kelola Akun
    public function manageAccount()
    {
        // Mendapatkan semua akun staff dengan role 'staff'
        $staffAccounts = User::where('role', 'staff')->get(); 
        
        // Mengirimkan data staffAccounts ke tampilan manage
        return view('headstaff.manage', compact('staffAccounts'));
    }

    // Menyimpan akun staff baru
    public function storeAccount(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email', // Email unik
            'password' => 'required|string|min:3|confirmed', // Validasi password dan konfirmasi password
        ], [
            'password.min' => 'Password harus memiliki minimal 3 karakter.',
            'password.confirmed' => 'Password dan konfirmasi password harus sama.',
        ]);
    
        // Membuat akun staff baru
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'staff';
        $user->save();
    
        // Menambahkan data ke tabel staff_provinces untuk wilayah default "Jawa Barat"
        StaffProvince::create([
            'user_id' => $user->id,
            'province' => 'Jawa Barat', 
        ]);
    
        // Redirect ke halaman kelola akun dengan pesan sukses
        return redirect()->route('headstaff.manage')->with('success', 'Akun staff baru berhasil dibuat');
    }
    
    
    // Mengupdate akun staff
   // Mengupdate akun staff
   public function updateAccount(Request $request, $id)
   {
       $user = User::findOrFail($id); // Cari akun berdasarkan ID
   
       // Jika tidak ada perubahan pada password, reset password otomatis menggunakan 4 kata pertama dari email
       if (!$request->has('password') || empty($request->password)) {
           $newPassword = substr($user->email, 0, strpos($user->email, '@')); // Ambil bagian sebelum '@' dari email
           $newPassword = implode('', array_slice(explode('.', $newPassword), 0, 4)); // Ambil 4 kata pertama, pisahkan dengan titik (jika ada)
           $user->password = Hash::make($newPassword); // Enkripsi password baru
       } else {
           // Jika password diubah, validasi dan update password baru
           $request->validate([
               'password' => 'nullable|string|min:3|confirmed', 
           ], [
               'password.min' => 'Password harus memiliki minimal 3 karakter.',
               'password.confirmed' => 'Password dan konfirmasi password harus sama.',
           ]);
   
           $user->password = Hash::make($request->password); // Enkripsi password baru
       }
   
       $user->save(); // Simpan perubahan ke database
   
       // Redirect dengan pesan sukses
       return redirect()->route('headstaff.manage')->with('success', 'Password akun berhasil diperbarui');
   }

    // Menghapus akun staff
    public function destroyAccount($id)
    {
        // Mencari akun staff berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus akun
        $user->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('headstaff.manage')->with('success', 'Akun berhasil dihapus');
    }

    // Logout
    public function logout(Request $request)
    {
        // Logout dan menghapus session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman utama setelah logout
        return redirect('/');
    }

}
