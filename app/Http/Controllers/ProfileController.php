<?php
// ============================================================
// FILE: app/Http/Controllers/ProfileController.php
// ============================================================
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
 
class ProfileController extends Controller
{
    /**
     * Halaman profile & settings user
     */
    public function index(): View
    {
        return view('profile.index', ['user' => auth()->user()]);
    }
 
    /**
     * Update nama & email
     */
    public function updateInfo(Request $request): RedirectResponse
    {
        $user = auth()->user();
 
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);
 
        // Jika email berubah, reset verifikasi
        if ($user->email !== $validated['email']) {
            $user->email_verified_at = null;
        }
 
        $user->fill($validated)->save();
 
        return back()->with('success_info', 'Profil berhasil diperbarui!');
    }
 
    /**
     * Update password
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
        ]);
 
        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);
 
        return back()->with('success_password', 'Password berhasil diperbarui!');
    }
 
    /**
     * Upload foto profil
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'avatar.max' => 'Ukuran foto maksimal 2MB.',
        ]);
 
        $user = auth()->user();
 
        // Hapus avatar lama jika ada
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
 
        // Simpan avatar baru ke storage/app/public/avatars/
        $path = $request->file('avatar')->store('avatars', 'public');
 
        $user->update(['avatar' => $path]);
 
        return back()->with('success_avatar', 'Foto profil berhasil diperbarui!');
    }
 
    /**
     * Hapus akun (dengan konfirmasi password)
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ], [
            'password.current_password' => 'Password tidak sesuai. Akun tidak dihapus.',
        ]);
 
        $user = auth()->user();
 
        Auth::logout();
 
        // Hapus avatar jika ada
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
 
        $user->delete();
 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect('/')->with('status', 'Akun Anda telah dihapus.');
    }
}