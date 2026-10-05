<x-filament-panels::page>

    @php
        $user = auth()->user();

        $nama = $user->nama ?? $user->username;
        $username = $user->username ?? '-';
        $role = ucfirst($user->role ?? '-');

        $noTelepon = $user->no_telepon ?? '-';
        $alamat = $user->alamat ?? '-';
        $email = $user->email ?? '-';

        $initial = strtoupper(substr($nama, 0, 1));

        $password = $user->password ?? '';

        $foto = $user->foto ?? null;
    @endphp

    <div
        class="profile-page"
        x-data="{ resetModal: false }"
        @keydown.escape.window="resetModal = false"
    >

        {{-- =====================================================
            HEADER PROFIL
        ====================================================== --}}
        <div class="profile-header-card">

            <div class="profile-header-left">

                {{-- FOTO PROFIL --}}
                <div
                    class="profile-avatar-wrapper"
                    x-data="{ photoMenu: false }"
                    @click.outside="photoMenu = false"
                >

                    @if ($isEditing)

                        <button
                            type="button"
                            class="profile-avatar-button"
                            @click="photoMenu = !photoMenu"
                        >

                            @if ($editFoto)

                                <img
                                    src="{{ $editFoto->temporaryUrl() }}"
                                    alt="Preview Foto Profil"
                                    class="profile-avatar profile-avatar-image"
                                >

                            @elseif ($foto && ! $removeFoto)

                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($foto) }}"
                                    alt="Foto Profil"
                                    class="profile-avatar profile-avatar-image"
                                >

                            @else

                                <div class="profile-avatar">
                                    {{ $initial }}
                                </div>

                            @endif

                            <span
                                class="profile-camera"
                                title="Kelola foto profil"
                            >
                                <x-heroicon-o-camera />
                            </span>

                        </button>


                        {{-- MENU FOTO --}}
                        <div
                            x-show="photoMenu"
                            x-cloak
                            class="profile-photo-menu"
                        >

                            <button
                                type="button"
                                class="profile-photo-menu-item"
                                @click="
                                    document.getElementById('profile-photo-input').click();
                                    photoMenu = false;
                                "
                            >
                                <x-heroicon-o-camera />
                                <span>Ganti Foto</span>
                            </button>


                            @if ($foto || $editFoto)

                                <button
                                    type="button"
                                    class="profile-photo-menu-item profile-photo-delete"
                                    wire:click="deleteFoto"
                                    @click="photoMenu = false"
                                >
                                    <x-heroicon-o-trash />
                                    <span>Hapus Foto</span>
                                </button>

                            @endif

                        </div>


                        <input
                            id="profile-photo-input"
                            type="file"
                            wire:model="editFoto"
                            accept="image/jpeg,image/png,image/webp"
                            class="profile-photo-input"
                        >

                    @else

                        @if ($foto)

                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($foto) }}"
                                alt="Foto Profil"
                                class="profile-avatar profile-avatar-image"
                            >

                        @else

                            <div class="profile-avatar">
                                {{ $initial }}
                            </div>

                        @endif

                    @endif

                </div>


                @error('editFoto')
                    <div class="profile-photo-error">
                        {{ $message }}
                    </div>
                @enderror


                {{-- IDENTITAS PROFIL --}}
                <div class="profile-identity">

                    <h2>{{ $username }}</h2>

                    <div class="profile-role-badge">
                        <x-heroicon-o-user />
                        <span>{{ $role }}</span>
                    </div>

                    <div class="profile-location">
                        <x-heroicon-o-map-pin />
                        <span>{{ $alamat }}</span>
                    </div>

                </div>

            </div>


            {{-- BUTTON RESET & EDIT --}}
            <div class="profile-actions">

                @if (! $isEditing)

                    <button
                        type="button"
                        class="profile-reset-button"
                        @click="resetModal = true"
                    >
                        <x-heroicon-o-arrow-path />
                        <span>Reset</span>
                    </button>


                    <button
                        type="button"
                        class="profile-edit-button"
                        wire:click="editProfile"
                        wire:loading.attr="disabled"
                    >
                        <x-heroicon-o-pencil />
                        <span>Edit</span>
                    </button>

                @endif

            </div>

        </div>


        {{-- =====================================================
            INFORMASI AKUN
        ====================================================== --}}
        <div class="profile-information-card">

            <div class="profile-information-header">
                <h3>Informasi Akun</h3>
            </div>


            <div class="profile-information-body">

                <div class="profile-information-grid">

                    {{-- USERNAME --}}
                    <div class="profile-field">

                        <div class="profile-field-icon">
                            <x-heroicon-o-user />
                        </div>

                        <div class="profile-field-content">

                            <label>Username</label>

                            <div class="profile-field-value profile-field-disabled">
                                {{ $username }}
                            </div>

                        </div>

                    </div>


                    {{-- NO TELEPON --}}
                    <div class="profile-field">

                        <div class="profile-field-icon">
                            <x-heroicon-o-phone />
                        </div>

                        <div class="profile-field-content">

                            <label>No. Telepon</label>

                            @if ($isEditing)

                                <input
                                    type="text"
                                    wire:model="editNoTelepon"
                                    class="profile-edit-input"
                                    placeholder="Masukkan no. telepon"
                                >

                            @else

                                <div class="profile-field-value">
                                    {{ $noTelepon }}
                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- NAMA --}}
                    <div class="profile-field">

                        <div class="profile-field-icon">
                            <x-heroicon-o-user />
                        </div>

                        <div class="profile-field-content">

                            <label>Nama</label>

                            <div class="profile-field-value profile-field-disabled">
                                {{ $nama }}
                            </div>

                        </div>

                    </div>


                    {{-- ALAMAT --}}
                    <div class="profile-field">

                        <div class="profile-field-icon">
                            <x-heroicon-o-map-pin />
                        </div>

                        <div class="profile-field-content">

                            <label>Alamat</label>

                            @if ($isEditing)

                                <textarea
                                    wire:model="editAlamat"
                                    class="profile-edit-input profile-edit-textarea"
                                    placeholder="Masukkan alamat"
                                ></textarea>

                            @else

                                <div class="profile-field-value profile-field-textarea">
                                    {{ $alamat }}
                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- EMAIL --}}
                    <div class="profile-field">

                        <div class="profile-field-icon">
                            <x-heroicon-o-envelope />
                        </div>

                        <div class="profile-field-content">

                            <label>Email</label>

                            @if ($isEditing)

                                <input
                                    type="email"
                                    wire:model="editEmail"
                                    class="profile-edit-input"
                                    placeholder="Masukkan email"
                                >

                            @else

                                <div class="profile-field-value">
                                    {{ $email }}
                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- PASSWORD --}}
                    <div class="profile-field">

                        <div class="profile-field-icon">
                            <x-heroicon-o-lock-closed />
                        </div>

                        <div class="profile-field-content">

                            <label>Password</label>

                            <div class="profile-password-wrapper">

                                <div class="profile-field-value profile-password">

                                    @if ($showPassword)
                                        {{ $password }}
                                    @else
                                        •••••••••
                                    @endif

                                </div>


                                <button
                                    type="button"
                                    class="profile-password-toggle"
                                    wire:click="togglePassword"
                                    title="{{ $showPassword ? 'Sembunyikan password' : 'Lihat password' }}"
                                >

                                    @if ($showPassword)
                                        <x-heroicon-o-eye-slash />
                                    @else
                                        <x-heroicon-o-eye />
                                    @endif

                                </button>

                            </div>

                        </div>

                    </div>

                </div>


                @error('editFoto')

                    <div class="profile-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>

        </div>


        {{-- =====================================================
            BUTTON BAWAH
        ====================================================== --}}
        <div class="profile-cancel-wrapper">

            @if ($isEditing)

                <button
                    type="button"
                    class="profile-cancel-button"
                    wire:click="cancelEdit"
                    wire:loading.attr="disabled"
                >
                    Batal
                </button>


                <button
                    type="button"
                    class="profile-save-button"
                    wire:click="saveProfile"
                    wire:loading.attr="disabled"
                >
                    Simpan
                </button>

            @else

                <button
                    type="button"
                    class="profile-cancel-button"
                    onclick="window.history.back()"
                >
                    Batal
                </button>

            @endif

        </div>


        {{-- =====================================================
            MODAL RESET
        ====================================================== --}}
        <div
            x-show="resetModal"
            x-cloak
            class="profile-reset-modal-backdrop"
            @click.self="resetModal = false"
        >

            <div
                class="profile-reset-modal"
                @click.stop
            >

                <div class="profile-reset-modal-content">

                    <h3>Konfirmasi Reset</h3>

                    <p>
                        Apakah Anda yakin ingin mereset perubahan profil?
                    </p>

                </div>


                <div class="profile-reset-modal-actions">

                    <button
                        type="button"
                        class="profile-reset-no-button"
                        @click="resetModal = false"
                    >
                        Tidak
                    </button>


                    <button
                        type="button"
                        class="profile-reset-yes-button"
                        wire:click="resetProfile"
                        wire:loading.attr="disabled"
                        @click="resetModal = false"
                    >
                        Ya, Reset
                    </button>

                </div>

            </div>

        </div>

    </div>


    <style>

        /* =========================================================
           HALAMAN PROFIL
        ========================================================= */

        .profile-page {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }


        /* =========================================================
           CARD HEADER PROFIL
        ========================================================= */

        .profile-header-card {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            padding: 24px 28px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 7px rgba(0, 0, 0, 0.06);
            box-sizing: border-box;
        }

        .profile-header-left {
            display: flex;
            align-items: center;
            gap: 30px;
            min-width: 0;
            flex: 1;
        }


        /* =========================================================
           FOTO PROFIL
        ========================================================= */

        .profile-avatar-wrapper {
            position: relative;
            width: 140px;
            height: 140px;
            flex-shrink: 0;
        }

        .profile-avatar-button {
            position: relative;
            width: 140px;
            height: 140px;
            display: block;
            padding: 0;
            margin: 0;
            border: none;
            background: transparent;
            border-radius: 50%;
            cursor: pointer;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #e5e7eb;
            color: #1769c2;
            font-size: 46px;
            font-weight: 700;
            border: 4px solid #f3f4f6;
            box-sizing: border-box;
        }

        .profile-avatar-image {
            object-fit: cover;
        }

        .profile-camera {
            position: absolute;
            right: -2px;
            bottom: 2px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #1769c2;
            color: #ffffff;
            border: 3px solid #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.12);
        }

        .profile-camera svg {
            width: 20px;
            height: 20px;
        }

        .profile-photo-input {
            display: none;
        }

        .profile-photo-menu {
            position: absolute;
            top: 148px;
            left: 50%;
            width: 155px;
            padding: 6px;
            transform: translateX(-50%);
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
            z-index: 100;
            box-sizing: border-box;
        }

        .profile-photo-menu-item {
            width: 100%;
            min-height: 38px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            background: transparent;
            border: none;
            border-radius: 6px;
            color: #111827;
            font-size: 13px;
            line-height: 18px;
            font-weight: 500;
            text-align: left;
            cursor: pointer;
            box-sizing: border-box;
        }

        .profile-photo-menu-item:hover {
            background: #f3f4f6;
        }

        .profile-photo-menu-item svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        .profile-photo-menu-item.profile-photo-delete {
            color: #dc2626;
        }

        .profile-photo-menu-item.profile-photo-delete:hover {
            background: #fef2f2;
        }

        [x-cloak] {
            display: none !important;
        }


        /* =========================================================
           IDENTITAS PROFIL
        ========================================================= */

        .profile-identity {
            min-width: 0;
            flex: 1;
        }

        .profile-identity h2 {
            margin: 0 0 8px 0;
            color: #111827;
            font-size: 28px;
            line-height: 34px;
            font-weight: 700;
        }

        .profile-role-badge {
            width: fit-content;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 13px;
            margin-bottom: 9px;
            border-radius: 7px;
            background: #1769c2;
            color: #ffffff;
            font-size: 14px;
            line-height: 18px;
            font-weight: 600;
        }

        .profile-role-badge svg {
            width: 18px;
            height: 18px;
        }

        .profile-location {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            min-width: 0;
            max-width: 100%;
            color: #1769c2;
            font-size: 14px;
            line-height: 22px;
        }

        .profile-location span {
            min-width: 0;
            max-width: 100%;
            white-space: normal;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .profile-location svg {
            width: 19px;
            height: 19px;
            flex-shrink: 0;
            margin-top: 2px;
        }


        /* =========================================================
           BUTTON RESET & EDIT
           POSISI BAWAH KANAN
        ========================================================= */

        .profile-actions {
            display: flex;
            align-items: center;
            align-self: flex-end;
            gap: 16px;
            flex-shrink: 0;
        }

        .profile-reset-button,
        .profile-edit-button {
            width: 170px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 0 20px;
            border-radius: 7px;
            font-size: 15px;
            line-height: 20px;
            font-weight: 600;
            cursor: pointer;
            box-sizing: border-box;
        }

        .profile-reset-button {
            background: #ffffff;
            border: 1px solid #1769c2;
            color: #1769c2;
        }

        .profile-reset-button:hover {
            background: #eff6ff;
        }

        .profile-edit-button {
            background: #1769c2;
            border: 1px solid #1769c2;
            color: #ffffff;
        }

        .profile-edit-button:hover {
            background: #1259a5;
        }

        .profile-reset-button svg,
        .profile-edit-button svg {
            width: 19px;
            height: 19px;
        }


        /* =========================================================
           CARD INFORMASI AKUN
        ========================================================= */

        .profile-information-card {
            width: 100%;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 7px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .profile-information-header {
            display: flex;
            align-items: center;
            padding: 20px 28px;
            border-bottom: 1px solid #e5e7eb;
        }

        .profile-information-header h3 {
            margin: 0;
            color: #111827;
            font-size: 20px;
            line-height: 26px;
            font-weight: 700;
        }

        .profile-information-body {
            padding: 24px 28px;
        }

        .profile-information-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            column-gap: 38px;
            row-gap: 24px;
        }


        /* =========================================================
           FIELD INFORMASI
        ========================================================= */

        .profile-field {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            min-width: 0;
        }

        .profile-field-icon {
            width: 38px;
            height: 38px;
            min-width: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1px;
            border-radius: 50%;
            background: #eaf2ff;
            color: #1769c2;
        }

        .profile-field-icon svg {
            width: 21px;
            height: 21px;
        }

        .profile-field-content {
            width: 100%;
            min-width: 0;
        }

        .profile-field-content label {
            display: block;
            margin-bottom: 7px;
            color: #111827;
            font-size: 16px;
            line-height: 20px;
            font-weight: 500;
        }

        .profile-field-value {
            width: 100%;
            min-height: 44px;
            display: flex;
            align-items: center;
            padding: 10px 13px;
            background: #f1f5fb;
            border: 1px solid #e1e7f0;
            border-radius: 7px;
            color: #111827;
            font-size: 14px;
            line-height: 20px;
            box-sizing: border-box;
            white-space: normal;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .profile-field-disabled {
            color: #4b5563;
            background: #f1f5fb;
        }

        .profile-field-textarea {
            min-height: 76px;
            display: block;
            line-height: 21px;
            white-space: normal;
            overflow-wrap: anywhere;
            word-break: break-word;
        }


        /* =========================================================
           INPUT EDIT
        ========================================================= */

        .profile-edit-input {
            width: 100%;
            min-height: 44px;
            padding: 10px 13px;
            background: #ffffff;
            border: 1px solid #1769c2;
            border-radius: 7px;
            color: #111827;
            font-size: 14px;
            line-height: 20px;
            outline: none;
            box-sizing: border-box;
            font-family: inherit;
        }

        .profile-edit-input:focus {
            border-color: #1769c2;
            box-shadow: 0 0 0 3px rgba(23, 105, 194, 0.12);
        }

        .profile-edit-textarea {
            min-height: 76px;
            resize: vertical;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
            word-break: break-word;
        }


        /* =========================================================
           PASSWORD
        ========================================================= */

        .profile-password-wrapper {
            position: relative;
            width: 100%;
        }

        .profile-password {
            padding-right: 48px;
            letter-spacing: 3px;
            font-size: 15px;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .profile-password-toggle {
            position: absolute;
            top: 50%;
            right: 10px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #6b7280;
            cursor: pointer;
            border-radius: 6px;
        }

        .profile-password-toggle:hover {
            background: #e5e7eb;
            color: #1769c2;
        }

        .profile-password-toggle svg {
            width: 19px;
            height: 19px;
        }


        /* =========================================================
           ERROR
        ========================================================= */

        .profile-photo-error {
            position: absolute;
            left: 0;
            top: 148px;
            width: 140px;
            color: #dc2626;
            font-size: 12px;
            line-height: 17px;
        }

        .profile-error {
            margin-top: 18px;
            padding: 10px 13px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 7px;
            color: #dc2626;
            font-size: 13px;
        }


        /* =========================================================
           BUTTON BAWAH
        ========================================================= */

        .profile-cancel-wrapper {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            box-sizing: border-box;
            margin-top: -8px;
        }

        .profile-cancel-button {
            min-width: 90px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 18px;
            background: #ffffff;
            border: none;
            border-radius: 7px;
            color: #000000;
            font-size: 13px;
            line-height: 18px;
            font-weight: 600;
            cursor: pointer;
            box-sizing: border-box;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.18);
            transition:
                background-color 0.15s ease,
                box-shadow 0.15s ease;
        }

        .profile-cancel-button:hover {
            background: #f9fafb;
            box-shadow: 0 3px 7px rgba(0, 0, 0, 0.12);
        }

        .profile-save-button {
            min-width: 110px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 18px;
            margin-left: auto;
            background: #1769c2;
            border: 1px solid #1769c2;
            border-radius: 7px;
            color: #ffffff;
            font-size: 13px;
            line-height: 18px;
            font-weight: 600;
            cursor: pointer;
            box-sizing: border-box;
        }

        .profile-save-button:hover {
            background: #1259a5;
        }


        /* =========================================================
           MODAL RESET
        ========================================================= */

        .profile-reset-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.45);
            box-sizing: border-box;
        }

        .profile-reset-modal {
            width: 100%;
            max-width: 430px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.20);
            overflow: hidden;
        }

        .profile-reset-modal-content {
            padding: 24px 26px 20px;
        }

        .profile-reset-modal-content h3 {
            margin: 0 0 9px;
            color: #111827;
            font-size: 19px;
            line-height: 25px;
            font-weight: 700;
        }

        .profile-reset-modal-content p {
            margin: 0;
            color: #4b5563;
            font-size: 14px;
            line-height: 21px;
        }

        .profile-reset-modal-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 26px 22px;
        }

        .profile-reset-no-button,
        .profile-reset-yes-button {
            min-width: 100px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 18px;
            border-radius: 7px;
            font-size: 13px;
            line-height: 18px;
            font-weight: 600;
            cursor: pointer;
            box-sizing: border-box;
        }

        .profile-reset-no-button {
            background: #ffffff;
            border: 1px solid #d1d5db;
            color: #374151;
        }

        .profile-reset-no-button:hover {
            background: #f9fafb;
        }

        .profile-reset-yes-button {
            background: #1769c2;
            border: 1px solid #1769c2;
            color: #ffffff;
        }

        .profile-reset-yes-button:hover {
            background: #1259a5;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1100px) {

            .profile-header-card {
                align-items: flex-start;
            }

            .profile-actions {
                align-self: flex-end;
            }

            .profile-reset-button,
            .profile-edit-button {
                width: 150px;
            }

        }


        @media (max-width: 768px) {

            .profile-header-card {
                padding: 20px;
            }

            .profile-header-left {
                gap: 18px;
            }

            .profile-avatar-wrapper,
            .profile-avatar-button,
            .profile-avatar {
                width: 100px;
                height: 100px;
            }

            .profile-avatar {
                font-size: 34px;
            }

            .profile-camera {
                width: 34px;
                height: 34px;
            }

            .profile-camera svg {
                width: 17px;
                height: 17px;
            }

            .profile-photo-menu {
                top: 108px;
            }

            .profile-identity h2 {
                font-size: 22px;
                line-height: 28px;
            }

            .profile-location {
                font-size: 13px;
                line-height: 19px;
            }

            .profile-information-grid {
                grid-template-columns: 1fr;
            }

            .profile-information-body {
                padding: 20px;
            }

            .profile-information-header {
                padding: 18px 20px;
            }

            .profile-cancel-wrapper {
                padding-right: 20px;
            }

        }


        @media (max-width: 520px) {

            .profile-header-left {
                flex-direction: column;
                align-items: flex-start;
            }

            .profile-actions {
                width: 100%;
                flex-direction: column;
                align-self: stretch;
            }

            .profile-reset-button,
            .profile-edit-button {
                width: 100%;
            }

            .profile-cancel-wrapper {
                padding-right: 0;
            }

            .profile-cancel-button,
            .profile-save-button {
                flex: 1;
            }

            .profile-reset-modal-actions {
                gap: 10px;
            }

            .profile-reset-no-button,
            .profile-reset-yes-button {
                flex: 1;
            }

        }

    </style>

</x-filament-panels::page>