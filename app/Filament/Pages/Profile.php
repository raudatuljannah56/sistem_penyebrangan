<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Profile extends Page
{
    use WithFileUploads;

    protected static ?string $title = 'Profil';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.pages.profile';

    public bool $isEditing = false;

    public bool $showPassword = false;

    public string $editNoTelepon = '';

    public string $editAlamat = '';

    public string $editEmail = '';

    public $editFoto = null;

    public bool $removeFoto = false;

    public function mount(): void
    {
        $this->loadProfileData();
    }

    public function loadProfileData(): void
    {
        $user = auth()->user();

        $this->editNoTelepon = $user->no_telepon ?? '';

        $this->editAlamat = $user->alamat ?? '';

        $this->editEmail = $user->email ?? '';

        // Jangan mengisi editFoto dengan foto lama.
        // editFoto hanya digunakan untuk foto baru yang dipilih.
        $this->editFoto = null;

        $this->removeFoto = false;

        $this->showPassword = false;
    }

    public function editProfile(): void
    {
        $this->loadProfileData();

        $this->resetValidation();

        $this->isEditing = true;
    }

    public function cancelEdit(): void
    {
        $this->loadProfileData();

        $this->resetValidation();

        $this->isEditing = false;
    }

    public function resetProfile(): void
    {
        $user = auth()->user();

        $oldFoto = $user->foto;

        $user->no_telepon = null;
        $user->alamat = null;
        $user->email = null;
        $user->foto = null;

        $user->save();

        if ($oldFoto) {
            Storage::disk('public')->delete($oldFoto);
        }

        $this->isEditing = false;

        $this->loadProfileData();

        $this->resetValidation();

        Notification::make()
            ->title('Profil berhasil direset')
            ->body('Data profil yang dapat diedit telah dikosongkan.')
            ->success()
            ->send();
    }

    public function deleteFoto(): void
    {
        if (! $this->isEditing) {
            return;
        }

        $this->editFoto = null;

        $this->removeFoto = true;
    }

    public function togglePassword(): void
    {
        $this->showPassword = ! $this->showPassword;
    }

    public function saveProfile(): void
    {
        $user = auth()->user();

        $this->validate([
            'editNoTelepon' => [
                'nullable',
                'string',
                'max:30',
            ],

            'editAlamat' => [
                'nullable',
                'string',
                'max:500',
            ],

            'editEmail' => [
                'nullable',
                'email',
                'max:255',
            ],

            'editFoto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'editNoTelepon.max' => 'No. telepon maksimal 30 karakter.',
            'editAlamat.max' => 'Alamat maksimal 500 karakter.',
            'editEmail.email' => 'Format email tidak valid.',
            'editEmail.max' => 'Email maksimal 255 karakter.',
            'editFoto.image' => 'File harus berupa gambar.',
            'editFoto.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'editFoto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $oldFoto = $user->foto;

        /*
         * ============================
         * SIMPAN FOTO BARU
         * ============================
         *
         * Foto disimpan langsung ke disk public
         * pada folder:
         *
         * storage/app/public/profile
         */
        if ($this->editFoto) {
            $newFoto = $this->editFoto->storePublicly(
                'profile',
                'public'
            );

            if (! $newFoto) {
                Notification::make()
                    ->title('Foto gagal disimpan')
                    ->body('Foto profil tidak berhasil disimpan. Silakan coba lagi.')
                    ->danger()
                    ->send();

                return;
            }

            /*
             * Pastikan file benar-benar ada
             * sebelum menyimpan path ke database.
             */
            if (! Storage::disk('public')->exists($newFoto)) {
                Notification::make()
                    ->title('Foto gagal disimpan')
                    ->body('File foto tidak ditemukan setelah proses penyimpanan.')
                    ->danger()
                    ->send();

                return;
            }

            // Simpan path foto baru ke database.
            $user->foto = $newFoto;
        }

        /*
         * Jika pengguna memilih Hapus Foto
         * dan tidak memilih foto baru.
         */
        if ($this->removeFoto && ! $this->editFoto) {
            $user->foto = null;
        }

        /*
         * ============================
         * DATA PROFIL LAINNYA
         * ============================
         */

        $user->no_telepon = filled(trim($this->editNoTelepon))
            ? trim($this->editNoTelepon)
            : null;

        $user->alamat = filled(trim($this->editAlamat))
            ? trim($this->editAlamat)
            : null;

        $user->email = filled(trim($this->editEmail))
            ? trim($this->editEmail)
            : null;

        /*
         * Simpan semua perubahan ke database.
         */
        $user->save();

        /*
         * Hapus foto lama hanya jika:
         * - ada foto baru, atau
         * - foto memang dihapus.
         */
        if ($oldFoto && ($this->editFoto || $this->removeFoto)) {
            Storage::disk('public')->delete($oldFoto);
        }

        /*
         * Kembali ke mode tampilan.
         */
        $this->isEditing = false;

        $this->loadProfileData();

        $this->resetValidation();

        Notification::make()
            ->title('Profil berhasil tersimpan')
            ->body('Perubahan informasi profil berhasil disimpan.')
            ->success()
            ->send();
    }

    public function getHeading(): string
    {
        $user = auth()->user();

        return 'Profil ' . ucfirst($user->role);
    }

    public function getSubheading(): ?string
    {
        return 'Informasi akun pengguna';
    }
}