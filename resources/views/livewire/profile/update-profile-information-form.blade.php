<?php

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

use function Livewire\Volt\state;

state([
    'name' => fn () => auth()->user()->name,
    'email' => fn () => auth()->user()->email
]);

$updateProfileInformation = function () {
    $user = Auth::user();

    $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
    ]);

    $user->fill($validated);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    toast('Profil berhasil diperbarui!','success');

    return redirect()->to('/dashboard/profil');
};

$sendVerification = function () {
    $user = Auth::user();

    if ($user->hasVerifiedEmail()) {
        $this->redirectIntended(default: route('dashboard', absolute: false));
        return;
    }

    $user->sendEmailVerificationNotification();

    Session::flash('status', 'verification-link-sent');
};
?>

<section>
    <header>
        <h2 class="h4 text-dark">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-muted">
            {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
        </p>
    </header>

    <form wire:submit.prevent="updateProfileInformation" class="mt-4">
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Nama') }}</label>
            <input wire:model="name" id="name" name="name" type="text" class="form-control" required autofocus
                autocomplete="name">
            @error('name')
            <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input wire:model="email" id="email" name="email" type="email" class="form-control" required
                autocomplete="username">
            @error('email')
            <div class="text-danger mt-2">{{ $message }}</div>
            @enderror

            @if (auth()->user() instanceof MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
            <div class="mt-2">
                <p class="text-muted">
                    {{ __('Your email address is unverified.') }}

                    <button wire:click.prevent="sendVerification" class="btn btn-link p-0 text-decoration-underline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="text-success">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary" wire:loading.remove
                wire:target="updateProfileInformation">{{ __('Simpan') }}</button>

            <button class="btn btn-primary" type="button" disabled wire:loading wire:target="updateProfileInformation">
                Menyimpan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
            </button>
        </div>
    </form>
</section>
