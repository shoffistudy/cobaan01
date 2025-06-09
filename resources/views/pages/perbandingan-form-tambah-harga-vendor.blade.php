<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Harga Barang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="flex flex-col gap-2">
                     <div>
                        <a href="{{ route('perbandingan-harga.list-vendor', $perbandingan->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Kembali
                        </a>
                    </div>

                    @if (session('error'))
                        <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 mt-3">
                            <strong>Error:</strong> {{ session('error') }}
                        </div>
                    @endif

                    <div class="mt-4">
                        <form id="formVendor" action="{{ route('perbandingan-harga.simpan-vendor', $perbandingan->id) }}" method="POST">
                            @csrf
                            <x-input-label for="vendor_ids" value="Pilih Vendor" />
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-2">
                                @foreach ($vendors as $vendor)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox"
                                               name="vendor_ids[]"
                                               value="{{ $vendor->id }}"
                                               data-nama="{{ $vendor->nama }}"
                                               class="vendor-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                        <span class="text-gray-800 dark:text-gray-100">{{ $vendor->nama }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-4 p-4 border border-blue-200 bg-blue-50 dark:border-blue-800 dark:bg-blue-900/30 rounded-md">
                                <h3 class="font-semibold text-sm text-blue-800 dark:text-blue-100">Vendor yang akan dikirimi penawaran:</h3>
                                <ul id="vendor-terpilih" class="list-disc list-inside text-sm text-gray-800 dark:text-white mt-2">
                                    <li class="italic text-gray-400">Belum ada vendor dipilih</li>
                                </ul>
                            </div>

                            <div class="mt-4">
                                <x-input-label for="batas_waktu_penawaran" value="Batas Waktu Penawaran" />
                                <input type="datetime-local" name="batas_waktu_penawaran" id="batas_waktu_penawaran"
                                    class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                    required>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Setelah waktu ini lewat, vendor tidak dapat mengisi/ubah penawaran.</p>
                            </div>

                            <div class="mt-4">
                                <button type="button" onclick="bukaModal()"
                                        class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tailwind -->
  <div id="konfirmasiModal"
     class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Konfirmasi Pengiriman Penawaran</h2>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Penawaran akan dikirim ke vendor berikut:</p>
            <ul id="vendor-modal-list" class="list-disc list-inside text-sm text-gray-800 dark:text-white my-3 space-y-1"></ul>
            <div class="flex justify-end gap-2 mt-4">
                <button onclick="tutupModal()"
                        class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                    Batal
                </button>
                <button onclick="submitForm()"
                        class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white">
                    Ya, Kirim
                </button>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.vendor-checkbox');
            const vendorList = document.getElementById('vendor-terpilih');

            function updateVendorList() {
                vendorList.innerHTML = '';
                const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.dataset.nama);

                if (selected.length) {
                    selected.forEach(nama => {
                        const li = document.createElement('li');
                        li.textContent = nama;
                        vendorList.appendChild(li);
                    });
                } else {
                    vendorList.innerHTML = '<li class="italic text-gray-400">Belum ada vendor dipilih</li>';
                }
            }

            checkboxes.forEach(cb => cb.addEventListener('change', updateVendorList));
            updateVendorList();
        });

        function bukaModal() {
            const checked = document.querySelectorAll('.vendor-checkbox:checked');
            const modalList = document.getElementById('vendor-modal-list');
            const modal = document.getElementById('konfirmasiModal');
            modalList.innerHTML = '';

            if (!checked.length) {
                modalList.innerHTML = '<li class="text-red-500">Tidak ada vendor dipilih!</li>';
            } else {
                checked.forEach(cb => {
                    const li = document.createElement('li');
                    li.textContent = cb.dataset.nama;
                    modalList.appendChild(li);
                });
            }

            modal.classList.remove('hidden');
        }

        function tutupModal() {
            document.getElementById('konfirmasiModal').classList.add('hidden');
        }

        function submitForm() {
            document.getElementById('formVendor').submit();
        }
    </script>
</x-app-layout>
