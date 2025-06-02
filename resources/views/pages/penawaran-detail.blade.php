@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Detail Penawaran</h6>
            <div class="dropdown no-arrow">
                <a href="{{ route('penawaran.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left fa-sm"></i> Kembali
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Nomor Penawaran</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $penawaran->nomor }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Status</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        @switch($penawaran->status)
                                            @case('draft')
                                                <span class="badge badge-secondary">Draft</span>
                                                @break
                                            @case('waiting_quotation')
                                                <span class="badge badge-primary">Menunggu Quotation</span>
                                                @break
                                            @case('quotation_received')
                                                <span class="badge badge-info">Quotation Diterima</span>
                                                @break
                                            @case('completed')
                                                <span class="badge badge-success">Selesai</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge badge-danger">Dibatalkan</span>
                                                @break
                                            @default
                                                <span class="badge badge-warning">Unknown</span>
                                        @endswitch
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Informasi Tambahan -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Penawaran</h6>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">Tanggal Dibuat</dt>
                                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($penawaran->tanggal)->format('d/m/Y H:i') }}</dd>
                                
                                <dt class="col-sm-4">Dibuat Oleh</dt>
                                <dd class="col-sm-8">{{ $penawaran->user->name }}</dd>
                                
                                <dt class="col-sm-4">Jumlah Vendor</dt>
                                <dd class="col-sm-8">{{ $penawaran->vendors->count() }}</dd>
                                
                                @if($penawaran->status == 'cancelled')
                                <dt class="col-sm-4">Tanggal Batal</dt>
                                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($penawaran->tanggal_batal)->format('d/m/Y H:i') }}</dd>
                                
                                <dt class="col-sm-4">Keterangan Batal</dt>
                                <dd class="col-sm-8">{{ $penawaran->keterangan_batal }}</dd>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pengajuan Terkait</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>No. Pengajuan</th>
                                            <th>Nama Pengajuan</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($penawaran->pengajuanList as $pengajuan)
                                        <tr>
                                            <td>{{ $pengajuan->nomor }}</td>
                                            <td>{{ $pengajuan->nama_pengajuan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal)->format('d/m/Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Daftar Item -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Item Penawaran</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Barang</th>
                                    <th>Spesifikasi</th>
                                    <th width="10%">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $items = $penawaran->pengajuanItems; @endphp
                                @forelse($items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td>{{ $item->spesifikasi }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada item</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Daftar Vendor -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Vendor</h6>
                    @if($penawaran->status == 'draft')
                        @can('update penawaran-pengajuan')
                        <a href="{{ route('penawaran.vendor.select', $penawaran->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus fa-sm"></i> Tambah Vendor
                        </a>
                        @endcan
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Vendor</th>
                                    <th>Status</th>
                                    <th>Tanggal Response</th>
                                    <th>Catatan Admin</th>
                                    <th>Catatan Vendor</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penawaran->penawaranVendors as $index => $pv)
                                <tr class="{{ $pv->is_selected ? 'table-success' : '' }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pv->vendor->nama }}</td>
                                    <td>
                                        @switch($pv->status)
                                            @case('invited')
                                                <span class="badge badge-secondary">Invited</span>
                                                @break
                                            @case('seen')
                                                <span class="badge badge-info">Seen</span>
                                                @break
                                            @case('responded')
                                                <span class="badge badge-primary">Responded</span>
                                                @break
                                            @case('selected')
                                                <span class="badge badge-success">Selected</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge badge-danger">Rejected</span>
                                                @break
                                            @default
                                                <span class="badge badge-warning">Unknown</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $pv->tanggal_response ? \Carbon\Carbon::parse($pv->tanggal_response)->format('d/m/Y H:i') : '-' }}</td>
                                    <td>{{ $pv->catatan_admin ?? '-' }}</td>
                                    <td>{{ $pv->catatan_vendor ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('penawaran.vendor.detail', ['penawaran' => $penawaran->id, 'vendor' => $pv->vendor_id]) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye fa-sm"></i> Detail
                                        </a>
                                        
                                        @if($penawaran->status == 'quotation_received' && $pv->status == 'responded' && !$penawaran->hasSelectedVendor())
                                            @can('update penawaran-pengajuan')
                                            <form action="{{ route('penawaran.vendor.select', ['penawaran' => $penawaran->id, 'vendor' => $pv->vendor_id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check fa-sm"></i> Pilih
                                                </button>
                                            </form>
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada vendor yang dipilih</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <a href="{{ route('penawaran.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            
                            @if($penawaran->status == 'draft')
                                @can('update penawaran-pengajuan')
                                <form action="{{ route('penawaran.submit', $penawaran->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary" {{ $penawaran->vendors->count() > 0 ? '' : 'disabled' }}>
                                        <i class="fas fa-paper-plane"></i> Kirim Penawaran
                                    </button>
                                </form>
                                @endcan
                            @endif
                            
                            @if($penawaran->status == 'quotation_received' && !$penawaran->perbandinganHarga)
                                @can('create perbandingan-harga')
                                <a href="{{ route('perbandingan.create', ['penawaran_id' => $penawaran->id]) }}" class="btn btn-success">
                                    <i class="fas fa-chart-bar"></i> Buat Perbandingan Harga
                                </a>
                                @endcan
                            @endif
                            
                            @if($penawaran->perbandinganHarga)
                                <a href="{{ route('perbandingan.show', $penawaran->perbandinganHarga->id) }}" class="btn btn-info">
                                    <i class="fas fa-chart-bar"></i> Lihat Perbandingan Harga
                                </a>
                            @endif
                            
                            @if($penawaran->canBeCancelled())
                                @can('delete penawaran-pengajuan')
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelModal">
                                    <i class="fas fa-times"></i> Batalkan Penawaran
                                </button>
                                @endcan
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Konfirmasi Pembatalan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('penawaran.cancel', $penawaran->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin membatalkan penawaran ini?</p>
                    <div class="form-group">
                        <label for="keterangan_batal">Keterangan Pembatalan</label>
                        <textarea class="form-control" id="keterangan_batal" name="keterangan_batal" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Batalkan Penawaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection