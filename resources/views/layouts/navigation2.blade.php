<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    @can('read vendor')
                        <x-nav-link :href="url('vendor')" :active="request()->segment(1) == 'vendor'">
                            Vendor
                        </x-nav-link>
                    @endcan

                    @can('read pengajuan-pembelian-barang')
                        <x-nav-link :href="url('pengajuan-pembelian-barang')" :active="request()->segment(1) == 'pengajuan-pembelian-barang'">
                            Pengajuan
                        </x-nav-link>
                    @endcan

                    @can('read perbandingan-harga')
                        <x-nav-link :href="url('perbandingan-harga')" :active="request()->segment(1) == 'perbandingan-harga'">
                            Perbandingan Harga
                        </x-nav-link>
                    @endcan

                    @can('read pemesanan-barang')
                        <x-nav-link :href="url('pemesanan-barang')" :active="request()->segment(1) == 'pemesanan-barang'">
                            Pemesanan
                        </x-nav-link>
                    @endcan

                    @can('read penerimaan-barang')
                        <x-nav-link :href="url('penerimaan-barang')" :active="request()->segment(1) == 'penerimaan-barang'">
                            Penerimaan
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                {{-- tambah notifikasi --}}
                <div class="relative">
                    <button id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification" class="relative inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400" type="button">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 20">
                            <path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z" />
                        </svg>
                        @if (auth()->user()->unreadNotifications->count())
                            <div class="absolute block w-3 h-3 bg-red-500 border-2 border-white rounded-full -top-0.5 start-2.5 dark:border-gray-900"></div>
                        @endif
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownNotification" class="z-50 absolute hidden w-80 py-2 max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700" aria-labelledby="dropdownNotificationButton">
                        <div class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white">
                            Notifications
                        </div>
                        <div class="divide-y overflow-y-auto max-h-72 divide-gray-100 dark:divide-gray-700">
                            @forelse (auth()->user()->unreadNotifications as $notification)
                                <a href="{{ route('notification', $notification->id) }}" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="w-full ps-3">
                                        <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400">
                                            {{ $notification->data['message'] }}
                                        </div>
                                        <div class="text-xs text-blue-600 dark:text-blue-500">{{ $notification->created_at }}</div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center text-gray-600 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <p>Tidak ada notifikasi</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div>
                        <button id="dropdownLogout" data-dropdown-toggle="dropdown" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </div>
                    <div id="dropdown" class="absolute hidden z-50 mt-2 w-48 rounded-md shadow-lg ltr:origin-top-right rtl:origin-top-left end-0">
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white dark:bg-gray-700">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button data-collapse-toggle="navbar-default" aria-controls="navbar-default" aria-expanded="false" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div class="hidden sm:hidden" id="navbar-default">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
            @can('read vendor')
                <x-responsive-nav-link :href="url('vendor')" :active="request()->segment(1) == 'vendor'">
                    Vendor
                </x-responsive-nav-link>
            @endcan

            @can('read pengajuan-pembelian-barang')
                <x-responsive-nav-link :href="url('pengajuan-pembelian-barang')" :active="request()->segment(1) == 'pengajuan-pembelian-barang'">
                    Pengajuan
                </x-responsive-nav-link>
            @endcan

            @can('read perbandingan-harga')
                <x-responsive-nav-link :href="url('perbandingan-harga')" :active="request()->segment(1) == 'perbandingan-harga'">
                    Perbandingan Harga
                </x-responsive-nav-link>
            @endcan

            @can('read pemesanan-barang')
                <x-responsive-nav-link :href="url('pemesanan-barang')" :active="request()->segment(1) == 'pemesanan-barang'">
                    Pemesanan
                </x-responsive-nav-link>
            @endcan

            @can('read penerimaan-barang')
                <x-responsive-nav-link :href="url('penerimaan-barang')" :active="request()->segment(1) == 'penerimaan-barang'">
                    Penerimaan
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
