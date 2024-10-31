<?php

namespace App\Livewire\Dashboard\Users;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $name, $email,$role;
    public $userIdBeingUpdated = null; // Untuk menangani edit data

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userIdBeingUpdated,
            'role' => 'required|exists:roles,id',
        ];
    }

    // Load data pengguna
    public function render()
    {
        return view('livewire.dashboard.users.users', [
            'users' => User::where('name', 'like', '%' . $this->search . '%')->with('roles')->latest()->paginate(5), // Menampilkan 10 data per halaman
            'roles' => Role::all()
        ]);
    }

   // Fungsi untuk membuat pengguna baru
   public function createUser()
   {
       $this->validate();
   
       // Buat user baru
       $user = User::create([
           'name' => $this->name,
           'email' => $this->email,
           'password' => Hash::make("12345678"),
       ]);
   
       // Sinkronkan role yang dipilih dengan menggunakan sync
       $user->roles()->sync([$this->role]); // Hanya satu role untuk setiap user
   
       $this->dispatch('closeAddUserModal');
   }
   


    // Fungsi untuk menampilkan data pengguna di form edit
    public function openUpdateModal($id)
    {
        $user = User::findOrFail($id);

        $this->userIdBeingUpdated = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;

        $this->dispatch('openEditUserModal'); // Kirim event untuk membuka modal dengan jQuery
    }

    // Fungsi untuk memperbarui data pengguna
    public function updateUser()
    {
        $this->validate();
    
        // Ambil user berdasarkan ID yang akan diperbarui
        $user = User::findOrFail($this->userIdBeingUpdated);
    
        // Update informasi pengguna
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);
    
        // Sinkronkan role yang dipilih dengan menggunakan sync
        $user->roles()->sync([$this->role]); // Hanya satu role untuk setiap user
    
        // Tutup modal dan reset form
        $this->dispatch('closeUpdatedModal');
      
    }
    

    // Fungsi untuk menghapus pengguna
    public function deleteUser($id)
    {
        // Ambil user beserta relasi roles dan posts
        $user = User::with(['roles', 'posts'])->findOrFail($id); 
    
        // Hapus semua relasi roles
        $user->roles()->detach(); // Hapus semua role yang terasosiasi dengan user
    
        // Hapus semua postingan yang dibuat oleh pengguna
        $user->posts()->delete(); // Hapus semua postingan yang terasosiasi dengan user
    
        // Hapus data pengguna
        $user->delete();
    
        // Kirim event ke JavaScript dengan ID modal sebagai string
        $this->dispatch('hideModalDelete', 'modalDelete' . $id); // Pastikan modal ID sebagai string
        $this->dispatch('deleteSuccess'); // Event untuk menampilkan pesan sukses
    }
    

    // Fungsi untuk mereset form
    public function resetForm()
    {
        $this->reset(['name', 'email','role']);
    }
}
