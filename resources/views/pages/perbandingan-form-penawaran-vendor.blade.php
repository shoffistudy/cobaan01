<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Form Penawaran Vendor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="flex flex-col gap-2">
                    <div class="mb-4">
                        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-700 dark:text-blue-400" role="alert">
                            <span class="font-medium">Info!</span> Anda diminta untuk memberikan penawaran harga untuk daftar barang berikut.
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <h3 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Detail Permintaan:</h3>
                                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                    <p><span class="font-medium">No. Permintaan:</span> {{ $permintaan->nomor }}</p>
                                    <p><span class="font-medium">Tanggal:</span> {{ $permintaan->created_at->format('d M Y') }}</p>
                                    <p><span class="font-medium">Batas Waktu Penawaran:</span> {{ $permintaan->batas_waktu->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Informasi Vendor:</h3>
                                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                    <p><span class="font-medium">Nama Vendor:</span> {{ $vendor->nama }}</p>
                                    <p><span class="font-medium">Alamat:</span> {{ $vendor->alamat }}</p>
                                    <p><span class="font-medium">Kontak:</span> {{ $vendor->kontak }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @session('error')
                        <div class="px-4">
                            <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">Error!</span> {{ session('error') }}
                            </div>
                        </div>
                    @endsession

                    @session('success')
                        <div class="px-4">
                            <div class="p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                <span class="font-medium">Sukses!</span> {{ session('success') }}
                            </div>
                        </div>
                    @endsession

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                        <form action="{{ route('vendor.submit-penawaran', $permintaan->id) }}" class="w-full" method="POST">
                            @csrf
                            <div class="py-1 mb-6">
                                <x-input-label for="ketentuan_pembayaran" value="Ketentuan Pembayaran" />
                                <x-textarea-input id="ketentuan_pembayaran" name="ketentuan_pembayaran" :value="old('ketentuan_pembayaran')" class="w-full p-2.5 text-sm" rows="4" placeholder="Masukkan ketentuan pembayaran, contoh: 50% di awal, 50% setelah barang diterima"></x-textarea-input>
                                @error('ketentuan_pembayaran')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <div class="py-1">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Nama Barang
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Qty
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Satuan
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Harga Satuan (Rp)
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Total (Rp)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permintaan->items as $index => $item)
                                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $item->nama_barang }}
                                                </th>
                                                <td class="px-6 py-4 text-gray-900">{{ $item->jumlah }}</td>
                                                <td class="px-6 py-4 text-gray-900">{{ $item->satuan }}</td>
                                                <td class="px-6 py-4">
                                                    <x-text-input 
                                                        type="number" 
                                                        name="harga_satuan[{{ $item->id }}]" 
                                                        id="harga_satuan_{{ $item->id }}"
                                                        :value="old('harga_satuan.' . $item->id)" 
                                                        class="w-full p-2.5 text-sm harga-input" 
                                                        placeholder="0" 
                                                        min="0" 
                                                        data-qty="{{ $item->jumlah }}"
                                                        data-row="{{ $index }}"
                                                        required
                                                    />
                                                    @error('harga_satuan.' . $item->id)
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="total-harga" id="total_{{ $index }}">0</div>
                                                    <input type="hidden" name="total[{{ $item->id }}]" id="total_input_{{ $index }}" value="0">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="font-semibold text-gray-900 dark:text-white">
                                            <th scope="row" colspan="4" class="px-6 py-3 text-right">
                                                Subtotal:
                                            </th>
                                            <td class="px-6 py-3" id="subtotal">0</td>
                                        </tr>
                                        <tr class="font-semibold text-gray-900 dark:text-white">
                                            <th scope="row" colspan="4" class="px-6 py-3 text-right">
                                                PPN (11%):
                                            </th>
                                            <td class="px-6 py-3" id="ppn">0</td>
                                        </tr>
                                        <tr class="font-semibold text-gray-900 dark:text-white">
                                            <th scope="row" colspan="4" class="px-6 py-3 text-right">
                                                Total:
                                            </th>
                                            <td class="px-6 py-3" id="grand-total">0</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                            <div class="py-1 mt-6">
                                <x-input-label for="catatan" value="Catatan Tambahan (Opsional)" />
                                <x-textarea-input id="catatan" name="catatan" :value="old('catatan')" class="w-full p-2.5 text-sm" rows="3" placeholder="Masukkan catatan tambahan jika ada"></x-textarea-input>
                            </div>
                            
                            <div class="flex items-center mt-6">
                                <input type="checkbox" id="konfirmasi" name="konfirmasi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" required>
                                <label for="konfirmasi" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Saya menyatakan bahwa informasi yang diberikan adalah benar dan penawaran ini berlaku selama 30 hari
                                </label>
                            </div>
                            
                            <div class="py-4 flex gap-4">
                                <x-primary-button type="submit">
                                    Kirim Penawaran
                                </x-primary-button>
                                <a href="{{ route('vendor.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hargaInputs = document.querySelectorAll('.harga-input');
            const subtotalElem = document.getElementById('subtotal');
            const ppnElem = document.getElementById('ppn');
            const grandTotalElem = document.getElementById('grand-total');
            
            // Format number as currency
            function formatCurrency(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }
            
            // Calculate total per row and update display
            function calculateTotal(input) {
                const row = input.dataset.row;
                const qty = parseFloat(input.dataset.qty);
                const price = parseFloat(input.value) || 0;
                const total = qty * price;
                
                document.getElementById('total_' + row).textContent = formatCurrency(total);
                document.getElementById('total_input_' + row).value = total;
                
                calculateSubtotal();
            }
            
            // Calculate subtotal, PPN, and grand total
            function calculateSubtotal() {
                let subtotal = 0;
                
                // Sum all totals
                const totalInputs = document.querySelectorAll('[id^="total_input_"]');
                totalInputs.forEach(input => {
                    subtotal += parseFloat(input.value) || 0;
                });
                
                const ppn = subtotal * 0.11;
                const grandTotal = subtotal + ppn;
                
                // Update display
                subtotalElem.textContent = formatCurrency(subtotal);
                ppnElem.textContent = formatCurrency(ppn);
                grandTotalElem.textContent = formatCurrency(grandTotal);
            }
            
            // Add event listeners to all price inputs
            hargaInputs.forEach(input => {
                input.addEventListener('input', function() {
                    calculateTotal(this);
                });
                
                // Initialize calculations on page load
                calculateTotal(input);
            });
        });
    </script>
</x-app-layout>