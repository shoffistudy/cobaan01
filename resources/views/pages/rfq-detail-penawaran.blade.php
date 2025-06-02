<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Detail RFQ Penawaran') }}
                </h2>
                <nav class="flex mt-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <a href="{{ route('rfq.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">RFQ Penawaran</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Detail RFQ</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

     <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- RFQ Header Information -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title mb-0">Informasi RFQ</h4>
                    <div class="d-flex gap-2">
                        @if($rfq->canBeEdited())
                            <a href="{{ route('rfq.edit', $rfq) }}" class="btn btn-warning btn-sm">
                                <i class="mdi mdi-pencil"></i> Edit
                            </a>
                        @endif
                        
                        @if($rfq->status === 'dibuat')
                            <form action="{{ route('rfq.send-to-vendors', $rfq) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary btn-sm" 
                                        onclick="return confirm('Kirim RFQ ke vendor?')">
                                    <i class="mdi mdi-send"></i> Kirim ke Vendor
                                </button>
                            </form>
                        @endif

                        @if($rfq->status !== 'ditutup')
                            <form action="{{ route('rfq.close', $rfq) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-secondary btn-sm" 
                                        onclick="return confirm('Tutup RFQ ini?')">
                                    <i class="mdi mdi-lock"></i> Tutup RFQ
                                </button>
                            </form>
                        @endif

                        @if($rfq->canBeEdited())
                            <form action="{{ route('rfq.destroy', $rfq) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Hapus RFQ ini?')">
                                    <i class="mdi mdi-delete"></i> Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Nomor RFQ</strong></td>
                                    <td>: {{ $rfq->rfq_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Judul</strong></td>
                                    <td>: {{ $rfq->title }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>: 
                                        @php
                                            $statusColors = [
                                                'dibuat' => 'info',
                                                'berlangsung' => 'warning',
                                                'ditutup' => 'secondary'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$rfq->status] ?? 'secondary' }}">
                                            {{ ucfirst($rfq->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat Oleh</strong></td>
                                    <td>: {{ $rfq->createdBy->name }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Tanggal Dibuat</strong></td>
                                    <td>: {{ $rfq->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Batas Waktu</strong></td>
                                    <td>: {{ \Carbon\Carbon::parse($rfq->deadline)->format('d/m/Y H:i') }}</td>
                                </tr>
                                @if($rfq->sent_at)
                                <tr>
                                    <td><strong>Dikirim Pada</strong></td>
                                    <td>: {{ $rfq->sent_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endif
                                @if($rfq->closed_at)
                                <tr>
                                    <td><strong>Ditutup Pada</strong></td>
                                    <td>: {{ $rfq->closed_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    
                    @if($rfq->description)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Deskripsi:</h6>
                            <p class="text-muted">{{ $rfq->description }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Pengajuan Pembelian Information -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Informasi Pengajuan Pembelian</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nomor Pengajuan:</strong> {{ $rfq->pengajuanPembelianBarang->nomor_pengajuan }}</p>
                            <p><strong>Tanggal Pengajuan:</strong> {{ $rfq->pengajuanPembelianBarang->tanggal_pengajuan->format('d/m/Y') }}</p>
                            <p><strong>Pengaju:</strong> {{ $rfq->pengajuanPembelianBarang->user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Keperluan:</strong> {{ $rfq->pengajuanPembelianBarang->keperluan }}</p>
                            <p><strong>Status Pengajuan:</strong> 
                                <span class="badge bg-success">{{ ucfirst($rfq->pengajuanPembelianBarang->status) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Barang -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Detail Barang yang Diminta</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Spesifikasi</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rfq->pengajuanPembelianBarang->details as $index => $detail)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $detail->barang->nama_barang }}</td>
                                    <td>{{ $detail->spesifikasi ?? '-' }}</td>
                                    <td>{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                    <td>{{ $detail->barang->satuan }}</td>
                                    <td>{{ $detail->keterangan ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor Quotations -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title mb-0">Penawaran dari Vendor</h4>
                    @if(!empty($vendorQuotations) && $rfq->status !== 'ditutup')
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#selectQuotationModal">
                            <i class="mdi mdi-check-circle"></i> Pilih Penawaran
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    @if(empty($vendorQuotations))
                        <div class="alert alert-info">
                            <i class="mdi mdi-information"></i>
                            Belum ada vendor yang terdaftar untuk RFQ ini.
                        </div>
                    @else
                        @foreach($vendorQuotations as $vendorId => $data)
                        <div class="vendor-section mb-4">
                            <div class="card border-primary">
                                <div class="card-header bg-light">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h5 class="mb-1">{{ $data['vendor']->nama_vendor }}</h5>
                                            <p class="text-muted mb-0">
                                                <i class="mdi mdi-map-marker"></i> {{ $data['vendor']->alamat }} | 
                                                <i class="mdi mdi-phone"></i> {{ $data['vendor']->telepon }} | 
                                                <i class="mdi mdi-email"></i> {{ $data['vendor']->email }}
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="badge bg-{{ $data['rfq_vendor']->status === 'ditawarkan' ? 'warning' : 'success' }} fs-6">
                                                {{ ucfirst($data['rfq_vendor']->status) }}
                                            </span>
                                            @if(!empty($data['quotations']))
                                                <div class="mt-1">
                                                    <strong class="text-primary">Total: Rp {{ number_format($data['total_amount'], 0, ',', '.') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if(empty($data['quotations']) || $data['quotations']->isEmpty())
                                        <div class="alert alert-warning mb-0">
                                            <i class="mdi mdi-clock-outline"></i>
                                            Vendor belum memberikan penawaran.
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Barang</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga Satuan</th>
                                                        <th>Total</th>
                                                        <th>Keterangan</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($data['quotations'] as $quotation)
                                                    <tr class="{{ $quotation->is_selected ? 'table-success' : '' }}">
                                                        <td>{{ $quotation->pengajuanPembelianBarangDetail->barang->nama_barang }}</td>
                                                        <td>{{ number_format($quotation->quantity, 0, ',', '.') }}</td>
                                                        <td>Rp {{ number_format($quotation->unit_price, 0, ',', '.') }}</td>
                                                        <td>Rp {{ number_format($quotation->total_price, 0, ',', '.') }}</td>
                                                        <td>{{ $quotation->notes ?? '-' }}</td>
                                                        <td>
                                                            @if($quotation->is_selected)
                                                                <span class="badge bg-success">
                                                                    <i class="mdi mdi-check"></i> Terpilih
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
        <div class="flex justify-start">
            <a href="{{ route('rfq.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar RFQ
            </a>
        </div>
    </div>

    {{-- Modal untuk Select Quotation --}}
    @if(!empty($vendorQuotations))
    <div id="selectQuotationModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                {{-- Modal content dengan form dan tabel Tailwind --}}
            </div>
        </div>
    </div>
    @endif

    <x-slot name="js">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Auto-hide alerts after 5 seconds
                setTimeout(function() {
                    const alerts = document.querySelectorAll('#success-alert, #error-alert');
                    alerts.forEach(alert => {
                        if (alert) {
                            alert.style.transition = 'opacity 0.5s';
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 500);
                        }
                    });
                }, 5000);
            });

            function openSelectQuotationModal() {
                document.getElementById('selectQuotationModal').classList.remove('hidden');
            }

            function closeSelectQuotationModal() {
                document.getElementById('selectQuotationModal').classList.add('hidden');
            }
        </script>
    </x-slot>
</x-app-layout>