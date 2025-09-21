<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/login');

Route::middleware('auth', 'verified', 'force.logout')
    ->namespace('App\Livewire')
    ->group(function () {

        /**
         * beranda / home
         */
        Route::get('beranda', Home\Index::class)
            ->name('home')
            ->middleware('roles:developer,superadmin,admin,user');

        /**
         * Pengguna / User
         */
        Route::prefix('pengguna')
            ->name('user.')
            ->middleware('roles:developer,superadmin,admin')
            ->group(function () {
                Route::get('/', User\Index::class)->name('index');
                Route::get('/tambah', User\Create::class)->name('create');
                Route::get('/sunting/{id}', User\Edit::class)->name('edit');
            });

        /**
         * pengaturan / setting
         */
        Route::prefix('pengaturan')
            ->name('setting.')
            ->middleware('roles:developer,superadmin,admin,user')
            ->group(function () {
                Route::redirect('/', 'pengaturan/aplikasi');

                /**1
                 * profil / profile
                 */
                Route::prefix('profil')->name('profile.')->group(function () {
                    Route::get('/', Setting\Profile\Index::class)->name('index');
                });

                /**
                 * akun / account
                 */
                Route::prefix('akun')->name('account.')->group(function () {
                    Route::get('/', Setting\Account\Index::class)->name('index');
                });
            });
    });
