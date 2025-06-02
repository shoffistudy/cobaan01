{{-- resources/views/pages/rfq/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Detail RFQ: {{ $rfq->rfq_number }}
            </h2>
            <div class="flex space-x-2">
                @if($rfq->status === 'dibuat')
                    <form action="{{ route('admin.rfq.sendToVendors', $rfq) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Kirim ke Vendor
                        </button>
                    </form>
                @endif
                
                @if($rfq->canBeEdited())
                    <a href="{{ route('admin.rfq.edit', $rfq) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                @endif
                
                <a href="{{ route('admin.rfq.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- RFQ Info -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Status:</span>
                    <span class="block px-2 py-1 text-xs rounded-full inline-block mt-1
                        @if($rfq->status === 'dibuat') bg-yellow-100 text-yellow-800
                        @elseif($rfq->status === 'berlangsung') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($rfq->status) }}
                    </span>
                </div>
                <div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Dibuat:</span>
                    <p class="text-sm">{{ $rfq->created_at->format('d/m/Y') }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Deadline:</span>
                    <p class="text-sm">{{ $rfq->deadline->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Pengajuan:</span>
                    <p class="text-sm">{{ $rfq->pengajuanPembelianBarang->nomor_pengajuan }}</p>
                </div>
            </div>
        </div>

        <!-- Barang -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium mb-4">Daftar Barang</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Barang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Satuan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($rfq->pengajuanPembelianBarang->details as $detail)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $detail->barang->nama_barang }}</td>
                                <td class="px-6 py-4 text-sm">{{ number_format($detail->jumlah) }}</td>
                                <td class="px-6 py-4 text-sm">{{ $detail->satuan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Penawaran Vendor -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium mb-4">Penawaran Vendor</h3>
            
            @forelse($vendorQuotations as $vendorData)
                <div class="border rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="font-medium">{{ $vendorData['vendor']->nama_perusahaan }}</h4>
                        <span class="text-sm text-gray-600">
                            Total: Rp {{ number_format($vendorData['total_amount'], 0, ',', '.') }}
                        </span>
                    </div>
                    
                    @if($vendorData['quotations']->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left py-2">Barang</th>
                                        <th class="text-left py-2">Jumlah</th>
                                        <th class="text-left py-2">Harga Satuan</th>
                                        <th class="text-left py-2">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vendorData['quotations'] as $quotation)
                                        <tr>
                                            <td class="py-2">{{ $quotation->pengajuanPembelianBarangDetail->barang->nama_barang }}</td>
                                            <td class="py-2">{{ $quotation->quantity }}</td>
                                            <td class="py-2">Rp {{ number_format($quotation->unit_price, 0, ',', '.') }}</td>
                                            <td class="py-2">Rp {{ number_format($quotation->total_price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada penawaran</p>
                    @endif
                </div>
            @empty
                <p class="text-gray-500">Belum ada penawaran dari vendor</p>
            @endforelse
        </div>
    </div>
</x-app-layout>