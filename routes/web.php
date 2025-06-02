<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\PerbandinganHargaController;
use App\Http\Controllers\PengajuanPembelianBarangController;
use App\Http\Controllers\PemesananBarangController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\RiwayatBarangController;
use App\Http\Controllers\PenawaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RfqController;
use App\Http\Controllers\VendorQuotationController;
use Illuminate\Notifications\DatabaseNotification as Notification;

/*
|-------------------------------------------------------------------------- 
| Route Publik
|-------------------------------------------------------------------------- 
*/

Route::get('/', fn () => view('beranda'));

Route::get('/syarat', fn () => view('syarat'))->name('syarat');
Route::get('/tentang', fn () => view('tentang'))->name('tentang');



/*
|-------------------------------------------------------------------------- 
| Route yang Memerlukan Autentikasi
|-------------------------------------------------------------------------- 
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    // Notifikasi
    Route::get('notification/{notification}', function (Notification $notification) {
        return redirect($notification->data['redirect_url']);
    })->name('notification');

    /*
    |-------------------------------------------------------------------------- 
    | Vendor Routes (akses terbatas berdasarkan role vendor)
    |-------------------------------------------------------------------------- 
    */

    Route::resource('vendor', VendorController::class)->except(['show']);


    /*
    |-------------------------------------------------------------------------- 
    | Pengajuan Pembelian Barang
    |-------------------------------------------------------------------------- 
    */
    Route::put('pengajuan-pembelian-barang/batal/{pengajuan_pembelian_barang}', [PengajuanPembelianBarangController::class, 'batal'])
        ->name('pengajuan-pembelian-barang.batal');

    Route::get('pengajuan-pembelian-barang/export/excel', [PengajuanPembelianBarangController::class, 'cetakExcel']);
    Route::get('pengajuan-pembelian-barang/download-template', [PengajuanPembelianBarangController::class, 'downloadTemplate'])->name('pengajuan-pembelian-barang.download-template');
    Route::post('pengajuan-pembelian-barang/upload-excel', [PengajuanPembelianBarangController::class, 'uploadExcel'])->name('pengajuan-pembelian-barang.upload-excel');
    Route::resource('pengajuan-pembelian-barang', PengajuanPembelianBarangController::class)->except(['destroy']);

    
    /*
    |-------------------------------------------------------------------------- 
    | Perbandingan Harga
    |-------------------------------------------------------------------------- 
    */
    Route::group(['prefix' => 'perbandingan-harga', 'as' => 'perbandingan-harga.'], function () {
        Route::get('cari-pengajuan', [PerbandinganHargaController::class, 'cariPengajuan'])->name('cari-pengajuan');
        Route::get('pilih-pengajuan/{pengajuan:nomor}', [PerbandinganHargaController::class, 'pilihPengajuan'])->name('pilih-pengajuan');
        Route::get('vendor/{perbandingan_harga}', [PerbandinganHargaController::class, 'listVendor'])->name('list-vendor');
        Route::get('tambah-vendor/{perbandingan_harga}', [PerbandinganHargaController::class, 'tambahVendor'])->name('tambah-vendor');
        //ini ditabah satu dibawah
        Route::post('kirim-penawaran/{perbandingan_harga}', [PerbandinganHargaController::class, 'kirimPenawaran'])->name('kirim-penawaran');
        Route::post('vendor/{perbandingan_harga}', [PerbandinganHargaController::class, 'simpanVendor'])->name('simpan-vendor');
        Route::get('edit-vendor/{perbandingan_harga_vendor}', [PerbandinganHargaController::class, 'editVendor'])->name('edit-vendor');
        Route::put('vendor/{perbandingan_harga_vendor}', [PerbandinganHargaController::class, 'updateVendor'])->name('update-vendor');
        Route::delete('vendor/{perbandingan_harga_vendor}', [PerbandinganHargaController::class, 'deleteVendor'])->name('delete-vendor');
        Route::post('selesai/{perbandingan_harga}', [PerbandinganHargaController::class, 'tandaiSelesai'])->name('tandai-selesai');

        Route::get('konfirmasi-undangan/{perbandingan_harga_vendor}', [PerbandinganHargaController::class, 'konfirmasiUndangan'])
            ->name('perbandingan-harga.konfirmasi-undangan');

        Route::post('konfirmasi-undangan/{perbandingan_harga_vendor}', [PerbandinganHargaController::class, 'prosesKonfirmasiUndangan'])
            ->name('perbandingan-harga.proses-konfirmasi-undangan');

    });
    Route::resource('perbandingan-harga', PerbandinganHargaController::class)->except(['destroy', 'show']);

    // Routes untuk Perbandingan Harga dengan Alur Penawaran & Negosiasi Terpisah
    // Route::group(['prefix' => 'perbandingan-harga', 'as' => 'perbandingan-harga.'], function () {
    //     // Routes yang sudah ada (tetap dipertahankan)
    //     Route::get('cari-pengajuan', [PerbandinganHargaController::class, 'cariPengajuan'])->name('cari-pengajuan');
    //     Route::get('pilih-pengajuan/{pengajuan:nomor}', [PerbandinganHargaController::class, 'pilihPengajuan'])->name('pilih-pengajuan');
    //     Route::get('vendor/{perbandingan_harga}', [PerbandinganHargaController::class, 'listVendor'])->name('list-vendor');
        
    //     // ALUR PENAWARAN - Admin Side
    //     Route::get('pilih-vendor/{perbandingan_harga}', [PerbandinganHargaController::class, 'pilihVendor'])->name('pilih-vendor');
    //     Route::post('kirim-penawaran/{perbandingan_harga}', [PerbandinganHargaController::class, 'kirimPenawaran'])->name('kirim-penawaran');
    //     Route::post('mulai-negosiasi/{perbandingan_harga}', [PerbandinganHargaController::class, 'mulaiNegosiasi'])->name('mulai-negosiasi');
    //     Route::post('tentukan-pemenang/{perbandingan_harga}', [PerbandinganHargaController::class, 'tentukanPemenang'])->name('tentukan-pemenang');
        
    //     // Routes lama yang masih diperlukan
    //     Route::get('tambah-vendor/{perbandingan_harga}', [PerbandinganHargaController::class, 'tambahVendor'])->name('tambah-vendor');
    //     Route::delete('vendor/{perbandingan_harga_vendor}', [PerbandinganHargaController::class, 'deleteVendor'])->name('delete-vendor');
    // });

    // // ALUR PENAWARAN - Vendor Side
    // Route::group(['prefix' => 'penawaran', 'as' => 'penawaran.'], function () {
    //     Route::get('detail/{perbandingan_harga}', [PerbandinganHargaController::class, 'detailPenawaran'])->name('detail');
    //     Route::post('respon/{perbandingan_harga}', [PerbandinganHargaController::class, 'responPenawaran'])->name('respon');
    // });

    // // ALUR NEGOSIASI - Vendor Side  
    // Route::group(['prefix' => 'negosiasi', 'as' => 'negosiasi.'], function () {
    //     Route::get('detail/{perbandingan_harga}', [PerbandinganHargaController::class, 'detailNegosiasi'])->name('detail');
    //     Route::post('simpan/{perbandingan_harga}', [PerbandinganHargaController::class, 'simpanNegosiasi'])->name('simpan');
    // });

    // // Resource route untuk CRUD dasar
    // Route::resource('perbandingan-harga', PerbandinganHargaController::class)->except(['destroy', 'show']);

    
    /*
    |-------------------------------------------------------------------------- 
    | Pemesanan Barang
    |-------------------------------------------------------------------------- 
    */
    Route::prefix('pemesanan-barang')->name('pemesanan-barang.')->group(function () {
        Route::get('cari-perbandingan', [PemesananBarangController::class, 'cariPerbandingan'])->name('cari-perbandingan');
        Route::get('pilih-perbandingan/{perbandingan_harga:nomor}', [PemesananBarangController::class, 'pilihPerbandingan'])->name('pilih-perbandingan');
        Route::put('batal/{pemesanan_barang}', [PemesananBarangController::class, 'batal'])->name('batal');
        Route::get('cetak/{pemesanan_barang}', [PemesananBarangController::class, 'cetak'])->name('cetak');
    });

    Route::resource('pemesanan-barang', PemesananBarangController::class)->except(['destroy']);

    /*
    |-------------------------------------------------------------------------- 
    | Penerimaan Barang
    |-------------------------------------------------------------------------- 
    */
    Route::prefix('penerimaan-barang')->name('penerimaan-barang.')->group(function () {
        Route::get('cari-pemesanan', [PenerimaanBarangController::class, 'cariPemesanan'])->name('cari-pemesanan');
        Route::get('pilih-pemesanan/{pemesanan_barang:nomor}', [PenerimaanBarangController::class, 'pilihPemesanan'])->name('pilih-pemesanan');
        Route::put('batal/{penerimaan_barang}', [PenerimaanBarangController::class, 'batal'])->name('batal');
    });

    Route::resource('penerimaan-barang', PenerimaanBarangController::class)->except(['destroy']);

    /*
    |-------------------------------------------------------------------------- 
    | Riwayat Barang
    |-------------------------------------------------------------------------- 
    */
    Route::prefix('riwayat-barang')->name('riwayat-barang.')->group(function () {
        Route::get('cari', [RiwayatBarangController::class, 'index'])->name('cari');
        Route::get('detail/{riwayat_barang}', [RiwayatBarangController::class, 'show'])->name('detail');  // Menampilkan detail riwayat barang
        Route::put('update/{riwayat_barang}', [RiwayatBarangController::class, 'update'])->name('update');  // Update riwayat barang
        Route::get('export-pdf', [RiwayatBarangController::class, 'exportPDF'])->name('export-pdf');
        Route::get('/riwayat-barang/export', [RiwayatBarangController::class, 'export'])->name('riwayat-barang.export');
        Route::get('/riwayat-barang', [PengajuanPembelianBarangController::class, 'showRiwayat'])->name('pages.riwayat-barang');

    });

    Route::resource('riwayat-barang', RiwayatBarangController::class)->except(['destroy']);  // Menggunakan resource controller dengan pengecualian pada destroy


        
   /*
    |--------------------------------------------------------------------------
    | RFQ (Request for Quotation) Routes
    |--------------------------------------------------------------------------
    */
    // routes/web.php - RFQ Routes
    Route::prefix('rfq')->name('rfq.')->group(function () {
        Route::get('/', [RfqController::class, 'index'])->name('index');
        Route::get('/create', [RfqController::class, 'create'])->name('create');
        Route::post('/', [RfqController::class, 'store'])->name('store');
        Route::get('/{rfq}', [RfqController::class, 'show'])->name('show');
        Route::get('/{rfq}/edit', [RfqController::class, 'edit'])->name('edit');
        Route::put('/{rfq}', [RfqController::class, 'update'])->name('update');
        Route::post('/{rfq}/send', [RfqController::class, 'sendToVendors'])->name('send');
        Route::post('/{rfq}/close', [RfqController::class, 'closeRfq'])->name('close');
        Route::post('/{rfq}/select', [RfqController::class, 'selectQuotation'])->name('select');
        Route::delete('/{rfq}', [RfqController::class, 'destroy'])->name('destroy');
    });

    /*
    |-------------------------------------------------------------------------- 
    | Profile
    |-------------------------------------------------------------------------- 
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
