<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state([
    'current_password' => '',
    'password' => '',
    'password_confirmation' => ''
]);

rules([
    'current_password' => ['required', 'string', 'current_password'],
    'password' => ['required', 'string', Password::defaults(), 'confirmed'],
]);

$updatePassword = function () {
    try {
        $validated = $this->validate();
    } catch (ValidationException $e) {
        $this->reset('current_password', 'password', 'password_confirmation');

        throw $e;
    }

    Auth::user()->update([
        'password' => Hash::make($validated['password']),
    ]);

    $this->reset('current_password', 'password', 'password_confirmation');

    toast('Password berhasil diperbarui!','success');
    return $this->redirect('/dashboard/profil', navigate: true);
};

?>

<section>
    <header class="mb-4">
        <h2 class="h4 text-dark">
            {{ __('Perbarui Kata Sandi') }}
        </h2>
        <p class="text-muted">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form wire:submit="updatePassword">
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Kata Sandi Saat Ini') }}</label>
            <input wire:model="current_password" placeholder="Masukan kata sandi sekarang.."
                id="update_password_current_password" name="current_password" type="password" class="form-control"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="text-danger" />
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('Kata Sandi Baru') }}</label>
            <input wire:model="password" placeholder="Masukan kata sandi terbaru.." id="update_password_password"
                name="password" type="password" class="form-control" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="text-danger" />
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation"
                class="form-label">{{ __('Konfirmasi Kata Sandi') }}</label>
            <input wire:model="password_confirmation" placeholder="Ketik kembali kata sandi baru.."
                id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger" />
        </div>

        <div class="d-flex justify-content-center">
            <button style="border-radius: 10px;" type="submit" class="btn btn-primary" wire:loading.remove
                wire:target="updatePassword">{{ __('Simpan') }}</button>

            <button style="border-radius: 10px;" class="btn btn-primary" type="button" disabled wire:loading wire:target="updatePassword">
                Menyimpan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
            </button>
        </div>
    </form>
</section>
