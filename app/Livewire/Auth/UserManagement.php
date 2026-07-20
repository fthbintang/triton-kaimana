<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Properti Form
    public $userId, $username, $nama_lengkap, $role, $password;
    
    // Properti Pencarian & State Modal
    public $search = '';
    public $isEditMode = false;

    // Reset halaman jika kata kunci pencarian berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Reset form inputan
    public function resetFields()
    {
        $this->userId = null;
        $this->username = '';
        $this->nama_lengkap = '';
        $this->role = '';
        $this->password = '';
        $this->isEditMode = false;
        $this->resetValidation();
    }

    // Membuka Modal Tambah User (State Awal)
    public function createUser()
    {
        $this->resetFields();
        $this->dispatch('openModal');
    }

    // 1. FUNGSI EDIT: Mengambil data lama ke form
    public function edit($id)
    {
        $this->resetFields();
        $this->isEditMode = true;
        
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->username = $user->username;
        $this->nama_lengkap = $user->nama_lengkap;
        $this->role = $user->role;

        $this->dispatch('openModal');
    }

    // 2. FUNGSI SAVE: Menyimpan Data Baru ATAU Perubahan Data
    public function save()
    {
        // 1. Aturan Validasi
        $rules = [
            'username'     => 'required|string|alpha_dash|unique:users,username,' . $this->userId,
            'nama_lengkap' => 'required|string|max:255',
            'role'         => 'required|in:Admin,Posbakum,Petugas PTSP,Petugas Back Office',
            'password'     => $this->isEditMode ? 'nullable|min:6' : 'required|min:6',
        ];

        // 2. Pesan Validasi Kustom Bahasa Indonesia
        $messages = [
            'username.required'   => 'Username wajib diisi.',
            'username.string'     => 'Username harus berupa teks.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip (-), dan garis bawah (_).',
            'username.unique'     => 'Username ini sudah digunakan oleh pengguna lain.',

            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.string'   => 'Nama lengkap harus berupa teks.',
            'nama_lengkap.max'      => 'Nama lengkap tidak boleh lebih dari 255 karakter.',

            'role.required' => 'Hak akses / Role wajib dipilih.',
            'role.in'       => 'Pilihan hak akses / Role tidak valid.',

            'password.required' => 'Kata sandi wajib diisi.',
            'password.min'      => 'Kata sandi minimal harus 6 karakter.',
        ];

        // 3. Jalankan Validasi
        $this->validate($rules, $messages);

        if ($this->isEditMode) {
            // Proses Perbarui (Update)
            $user = User::findOrFail($this->userId);
            $user->username = $this->username;
            $user->nama_lengkap = $this->nama_lengkap;
            $user->role = $this->role;
            
            if (!empty($this->password)) {
                $user->password = Hash::make($this->password);
            }
            $user->save();
            session()->flash('message', 'Data pengguna berhasil diperbarui!');
        } else {
            // Proses Tambah Baru (Store)
            User::create([
                'username' => $this->username,
                'nama_lengkap' => $this->nama_lengkap,
                'role' => $this->role,
                'password' => Hash::make($this->password),
            ]);
            session()->flash('message', 'Pengguna baru berhasil ditambahkan!');
        }

        $this->dispatch('closeModal');
        $this->resetFields();
    }

    public function destroy($id): void
    {
        // Memanggil ID langsung lewat Facade
        $currentAdminId = Auth::id();

        if ((int)$id === (int)$currentAdminId) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif!');
            return;
        }

        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('message', 'Data pengguna berhasil dihapus dari sistem TRITON.');
        $this->redirect(route('users.index'), navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $users = User::where(function($query) {
                $query->where('nama_lengkap', 'like', '%' . $this->search . '%')
                    ->orWhere('username', 'like', '%' . $this->search . '%')
                    ->orWhere('role', 'like', '%' . $this->search . '%');
            })
            // Mengurutkan secara kustom sesuai hirarki Role yang diinginkan
            ->orderByRaw("FIELD(role, 'Admin', 'Posbakum', 'Petugas PTSP', 'Petugas Back Office') ASC")
            ->latest()
            ->paginate(10);

        return view('livewire.auth.user-management', [
            'users' => $users
        ]);
    }
}