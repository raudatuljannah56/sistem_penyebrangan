<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN PAGE
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CEK LOGIN
        |--------------------------------------------------------------------------
        */

        if (!Auth::attempt($credentials)) {

            return back()
                ->withErrors([
                    'username' => 'Username atau password salah.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | REGENERATE SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | USER LOGIN
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {

            return redirect('/admin');
        }


        /*
        |--------------------------------------------------------------------------
        | PETUGAS
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'petugas') {

            /*
            |--------------------------------------------------------------------------
            | Ambil shift milik Petugas.
            |--------------------------------------------------------------------------
            |
            | Petugas tidak memilih shift sendiri.
            | Sistem mengambil shift yang ditugaskan Admin.
            |
            */

            $shift = Shift::query()
                ->where('id_user', $user->id_user)
                ->orderBy('jam_mulai')
                ->first();


            /*
            |--------------------------------------------------------------------------
            | Tidak memiliki shift
            |--------------------------------------------------------------------------
            */

            if (!$shift) {

                $request->session()->forget(
                    'id_shift_aktif'
                );

                return redirect('/petugas');
            }


            /*
            |--------------------------------------------------------------------------
            | Sinkronkan status sebelum login
            |--------------------------------------------------------------------------
            */

            $shift->sinkronisasiStatus();


            /*
            |--------------------------------------------------------------------------
            | Mulai shift karena Petugas berhasil login
            |--------------------------------------------------------------------------
            */

            $shiftBerhasilDimulai = $shift->mulaiShift();


            /*
            |--------------------------------------------------------------------------
            | Kalau login pada saat shift sudah selesai
            |--------------------------------------------------------------------------
            */

            if (
                !$shiftBerhasilDimulai &&
                $shift->status === 'selesai'
            ) {

                $request->session()->forget(
                    'id_shift_aktif'
                );

                return redirect('/petugas');
            }


            /*
            |--------------------------------------------------------------------------
            | Simpan ID shift aktif
            |--------------------------------------------------------------------------
            |
            | Hanya simpan session kalau shift memang sedang
            | berlangsung.
            |
            */

            if ($shiftBerhasilDimulai) {

                $request->session()->put(
                    'id_shift_aktif',
                    $shift->id_shift
                );

            } else {

                $request->session()->forget(
                    'id_shift_aktif'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Masuk ke panel Petugas
            |--------------------------------------------------------------------------
            */

            return redirect('/petugas');
        }


        /*
        |--------------------------------------------------------------------------
        | ROLE TIDAK DIKENALI
        |--------------------------------------------------------------------------
        */

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return back()
            ->withErrors([
                'username' => 'Role pengguna tidak dikenali.',
            ])
            ->withInput();
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | JANGAN mengubah status shift di sini.
        |--------------------------------------------------------------------------
        |
        | Logout bukan berarti shift selesai.
        |
        | Contoh:
        |
        | 08:00 login  -> berlangsung
        | 12:00 logout -> tetap berlangsung
        | 16:00        -> selesai
        |
        */

        $request->session()->forget(
            'id_shift_aktif'
        );


        /*
        |--------------------------------------------------------------------------
        | LOGOUT USER
        |--------------------------------------------------------------------------
        */

        Auth::logout();


        /*
        |--------------------------------------------------------------------------
        | HAPUS SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        /*
        |--------------------------------------------------------------------------
        | KEMBALI KE LOGIN
        |--------------------------------------------------------------------------
        */

        return redirect()->route('login');
    }
}