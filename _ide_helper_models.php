<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property string $model_type
 * @property int $model_id
 * @property array<array-key, mixed> $data
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @property-read \Illuminate\Database\Eloquent\Model $notifiable
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification read()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification unread()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nomor
 * @property int $perbandingan_id
 * @property int $vendor_id
 * @property string $npwp
 * @property string $pic
 * @property string $kontak_pic
 * @property int $batal
 * @property string|null $keterangan_batal
 * @property string|null $tanggal_batal
 * @property int $user_id
 * @property string $tanggal
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PemesananBarangDetail> $detail
 * @property-read int|null $detail_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PenerimaanBarang> $penerimaan
 * @property-read int|null $penerimaan_count
 * @property-read \App\Models\PerbandinganHarga $perbandingan
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Vendor $vendor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang whereBatal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang whereKeteranganBatal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang whereKontakPic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang whereNomor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang whereNpwp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang wherePerbandinganId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang wherePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang whereTanggalBatal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarang whereVendorId($value)
 */
	class PemesananBarang extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $pemesanan_id
 * @property int $perbandingan_barang_id
 * @property string $nama_barang
 * @property string $spesifikasi
 * @property int $jumlah
 * @property int $harga_satuan
 * @property int $penerimaan
 * @property-read \App\Models\PemesananBarang $pemesanan
 * @property-read \App\Models\PerbandinganHargaItemBarang $perbandinganHargaItemBarang
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarangDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarangDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarangDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarangDetail whereHargaSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarangDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarangDetail whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarangDetail whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarangDetail wherePemesananId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarangDetail wherePenerimaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarangDetail wherePerbandinganBarangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PemesananBarangDetail whereSpesifikasi($value)
 */
	class PemesananBarangDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nomor
 * @property string $judul
 * @property string|null $keterangan
 * @property string $status
 * @property int $user_id
 * @property string $tanggal
 * @property string|null $deadline
 * @property int $batal
 * @property string|null $keterangan_batal
 * @property string|null $tanggal_batal
 * @property-read float $total_harga
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PenawaranItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\PerbandinganHarga|null $perbandinganHarga
 * @property-read \App\Models\Vendor|null $vendor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penawaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penawaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penawaran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penawaran whereBatal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penawaran whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penawaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penawaran whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penawaran whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penawaran whereKeteranganBatal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penawaran whereNomor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penawaran whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penawaran whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penawaran whereTanggalBatal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penawaran whereUserId($value)
 */
	class Penawaran extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\PenawaranVendor|null $penawaranVendor
 * @property-read \App\Models\PengajuanPembelianBarangDetail|null $pengajuanDetail
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenawaranItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenawaranItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenawaranItem query()
 */
	class PenawaranItem extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read mixed $total_quotation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PenawaranItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Penawaran|null $penawaran
 * @property-read \App\Models\Vendor|null $vendor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenawaranVendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenawaranVendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenawaranVendor query()
 */
	class PenawaranVendor extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nomor
 * @property int $pemesanan_id
 * @property string $tanggal_penerimaan
 * @property int $vendor_id
 * @property string $pengantar
 * @property string $penerima
 * @property int $batal
 * @property string|null $keterangan_batal
 * @property string|null $tanggal_batal
 * @property int $user_id
 * @property string $tanggal
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PenerimaanBarangDetail> $detail
 * @property-read int|null $detail_count
 * @property-read \App\Models\PemesananBarang $pemesanan
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Vendor $vendor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang whereBatal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang whereKeteranganBatal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang whereNomor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang wherePemesananId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang wherePenerima($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang wherePengantar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang whereTanggalBatal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang whereTanggalPenerimaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarang whereVendorId($value)
 */
	class PenerimaanBarang extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $penerimaan_id
 * @property int $pemesanan_barang_detail_id
 * @property string $nama_barang
 * @property int $jumlah
 * @property string $keterangan
 * @property-read \App\Models\PenerimaanBarang $penerimaan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarangDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarangDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarangDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarangDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarangDetail whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarangDetail whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarangDetail whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarangDetail wherePemesananBarangDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenerimaanBarangDetail wherePenerimaanId($value)
 */
	class PenerimaanBarangDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nomor
 * @property string $nama_pengajuan
 * @property string $keterangan
 * @property int $batal
 * @property string|null $keterangan_batal
 * @property string|null $tanggal_batal
 * @property int $user_id
 * @property string $tanggal
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PengajuanPembelianBarangDetail> $detail
 * @property-read int|null $detail_count
 * @property-read \App\Models\PemesananBarang|null $pemesanan
 * @property-read \App\Models\PerbandinganHarga|null $perbandingan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rfq> $rfqs
 * @property-read int|null $rfqs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RiwayatBarang> $riwayatBarang
 * @property-read int|null $riwayat_barang_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarang whereBatal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarang whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarang whereKeteranganBatal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarang whereNamaPengajuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarang whereNomor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarang whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarang whereTanggalBatal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarang whereUserId($value)
 */
	class PengajuanPembelianBarang extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $pengajuan_id
 * @property string $nama_barang
 * @property string $spesifikasi
 * @property int $jumlah
 * @property int $harga_satuan
 * @property int $perbandingan
 * @property-read \App\Models\PengajuanPembelianBarang $pengajuan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VendorQuotation> $vendorQuotations
 * @property-read int|null $vendor_quotations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarangDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarangDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarangDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarangDetail whereHargaSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarangDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarangDetail whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarangDetail whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarangDetail wherePengajuanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarangDetail wherePerbandingan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengajuanPembelianBarangDetail whereSpesifikasi($value)
 */
	class PengajuanPembelianBarangDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nomor
 * @property string $judul
 * @property int $pengajuan_id
 * @property int $user_id
 * @property string $tanggal
 * @property int $selesai
 * @property int|null $penawaran_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PemesananBarang> $pemesanan
 * @property-read int|null $pemesanan_count
 * @property-read \App\Models\PengajuanPembelianBarang $pengajuan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PengajuanPembelianBarangDetail> $pengajuanDetail
 * @property-read int|null $pengajuan_detail_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PerbandinganHargaVendor> $perbandinganHargaVendor
 * @property-read int|null $perbandingan_harga_vendor_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHarga newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHarga newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHarga query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHarga whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHarga whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHarga whereNomor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHarga wherePenawaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHarga wherePengajuanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHarga whereSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHarga whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHarga whereUserId($value)
 */
	class PerbandinganHarga extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $perbandingan_vendor_id
 * @property int $pengajuan_barang_detail_id
 * @property string $nama_barang
 * @property string $spesifikasi
 * @property int $jumlah
 * @property int $harga_satuan
 * @property int $pemesanan
 * @property-read \App\Models\PengajuanPembelianBarangDetail|null $pengajuanDetail
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaItemBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaItemBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaItemBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaItemBarang whereHargaSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaItemBarang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaItemBarang whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaItemBarang whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaItemBarang wherePemesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaItemBarang wherePengajuanBarangDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaItemBarang wherePerbandinganVendorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaItemBarang whereSpesifikasi($value)
 */
	class PerbandinganHargaItemBarang extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $perbandingan_id
 * @property int $vendor_id
 * @property string $pic
 * @property string $kontak_pic
 * @property string $ketentuan_pembayaran
 * @property-read \App\Models\PerbandinganHarga $perbandinganHarga
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PerbandinganHargaItemBarang> $perbandinganHargaItemBarang
 * @property-read int|null $perbandingan_harga_item_barang_count
 * @property-read \App\Models\Vendor $vendor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaVendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaVendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaVendor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaVendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaVendor whereKetentuanPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaVendor whereKontakPic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaVendor wherePerbandinganId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaVendor wherePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerbandinganHargaVendor whereVendorId($value)
 */
	class PerbandinganHargaVendor extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $rfq_number
 * @property int $pengajuan_pembelian_barang_id
 * @property int $created_by
 * @property string $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $deadline
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $sent_at
 * @property \Illuminate\Support\Carbon|null $closed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vendor> $acceptedVendors
 * @property-read int|null $accepted_vendors_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\PengajuanPembelianBarang $pengajuanPembelianBarang
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vendor> $rejectedVendors
 * @property-read int|null $rejected_vendors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vendor> $respondedVendors
 * @property-read int|null $responded_vendors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RfqVendor> $rfqVendors
 * @property-read int|null $rfq_vendors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vendor> $vendors
 * @property-read int|null $vendors_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq expired()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq whereClosedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq wherePengajuanPembelianBarangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq whereRfqNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq whereSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rfq whereUpdatedAt($value)
 */
	class Rfq extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $rfq_id
 * @property int $vendor_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $responded_at
 * @property string|null $reject_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VendorQuotation> $quotations
 * @property-read int|null $quotations_count
 * @property-read \App\Models\Rfq $rfq
 * @property-read \App\Models\Vendor $vendor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RfqVendor activeRfq()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RfqVendor forVendor($vendorId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RfqVendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RfqVendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RfqVendor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RfqVendor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RfqVendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RfqVendor whereRejectReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RfqVendor whereRespondedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RfqVendor whereRfqId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RfqVendor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RfqVendor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RfqVendor whereVendorId($value)
 */
	class RfqVendor extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $pengajuan_id
 * @property string $nama_barang
 * @property string $spesifikasi
 * @property int $jumlah
 * @property string $harga_satuan
 * @property string $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PengajuanPembelianBarang $pengajuan
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatBarang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatBarang whereHargaSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatBarang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatBarang whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatBarang whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatBarang wherePengajuanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatBarang whereSpesifikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatBarang whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatBarang whereUpdatedAt($value)
 */
	class RiwayatBarang extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method bool hasRole(string|array $roles, string|null $guard = null)
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rfq> $createdRfqs
 * @property-read int|null $created_rfqs_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Vendor|null $vendor
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nomor
 * @property string $nama
 * @property string $email
 * @property string $npwp
 * @property string $alamat
 * @property string $pic
 * @property string $kontak_pic
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VendorQuotation> $quotations
 * @property-read int|null $quotations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RfqVendor> $rfqVendors
 * @property-read int|null $rfq_vendors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rfq> $rfqs
 * @property-read int|null $rfqs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereKontakPic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereNomor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereNpwp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor wherePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor withoutRole($roles, $guard = null)
 */
	class Vendor extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $rfq_vendor_id
 * @property int $pengajuan_pembelian_barang_detail_id
 * @property numeric $unit_price
 * @property numeric $total_price
 * @property string $payment_terms
 * @property string|null $notes
 * @property bool $is_selected
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PengajuanPembelianBarangDetail $pengajuanPembelianBarangDetail
 * @property-read \App\Models\RfqVendor $rfqVendor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation forRfq($rfqId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation forVendor($vendorId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation selected()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation whereIsSelected($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation wherePaymentTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation wherePengajuanPembelianBarangDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation whereRfqVendorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VendorQuotation whereUpdatedAt($value)
 */
	class VendorQuotation extends \Eloquent {}
}

