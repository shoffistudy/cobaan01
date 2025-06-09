<div class="flex">
    <!-- Sidebar Navigation -->
    <aside class="w-64 h-screen bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 shadow-lg relative" >
        <!-- Logo -->
        <div class="px-4 py-6 border-b border-gray-100 dark:border-gray-700">
            <div class="flex justify-center">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <x-application-logo class="h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    {{-- <span class="ml-3 font-semibold text-gray-800 dark:text-gray-200">Your App</span> --}}
                </a>
            </div>
        </div>

        {{-- <!-- Dark/Light Mode Toggle -->
        <div class="flex justify-end p-4">
            <button id="themeToggle" type="button" class="text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white focus:outline-none">
                <svg id="themeToggleDarkIcon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293a8 8 0 01-10.586-10.586A8 8 0 1017.293 13.293z" />
                </svg>
                <svg id="themeToggleLightIcon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 01-2 0V3a1 1 0 011-1zm4.22 2.22a1 1 0 111.415 1.415l-.707.707a1 1 0 11-1.414-1.414l.706-.708zM18 9a1 1 0 100 2h1a1 1 0 100-2h-1zM4.22 4.22a1 1 0 10-1.414 1.415l.707.707A1 1 0 005 5l-.78-.78zm1.415 11.15a1 1 0 00-1.415 1.415l.707.707a1 1 0 001.415-1.414l-.707-.708zM10 16a1 1 0 011 1v1a1 1 0 01-2 0v-1a1 1 0 011-1zm6-6a6 6 0 11-12 0 6 6 0 0112 0zM2 9a1 1 0 100 2H1a1 1 0 100-2h1zm14.78 6.78a1 1 0 00-1.415-1.415l-.707.707a1 1 0 101.414 1.414l.708-.706z" />
                </svg>
            </button>
        </div> --}}

       <!-- Notification Button di kanan atas -->
        <div class="fixed top-4 right-4 z-50">
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
                <div id="dropdownNotification" class="z-50 absolute right-0 hidden w-80 py-2 max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700" aria-labelledby="dropdownNotificationButton">
                    <div class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white">
                        Notifications
                    </div>
                    <div class="divide-y overflow-y-auto max-h-72 divide-gray-100 dark:divide-gray-700">
                        @forelse (auth()->user()->unreadNotifications as $notification)
                            <a href="{{ route('notification', $notification->id) }}" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
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
        </div>


        <!-- Navigation Links -->
        <nav class="mt-6 px-4">
            <div class="space-y-2">
                <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </x-sidebar-link>

                @can('read vendor')
                    <x-sidebar-link :href="url('vendor')" :active="request()->segment(1) == 'vendor'">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Vendor
                    </x-sidebar-link>
                @endcan

                @can('read pengajuan-pembelian-barang')
                    <x-sidebar-link :href="url('pengajuan-pembelian-barang')" :active="request()->segment(1) == 'pengajuan-pembelian-barang'">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Pengajuan
                    </x-sidebar-link>
                @endcan

                
                @can('read perbandingan-harga')
                    <x-sidebar-link :href="url('perbandingan-harga')" :active="request()->segment(1) == 'perbandingan-harga'">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                        </svg>
                        Perbandingan Harga
                    </x-sidebar-link>
                @endcan

                @can('read pemesanan-barang')
                    <x-sidebar-link :href="url('pemesanan-barang')" :active="request()->segment(1) == 'pemesanan-barang'">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Pemesanan
                    </x-sidebar-link>
                @endcan

                @can('read penerimaan-barang')
                    <x-sidebar-link :href="url('penerimaan-barang')" :active="request()->segment(1) == 'penerimaan-barang'">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Penerimaan
                    </x-sidebar-link>
                @endcan

                {{-- tambah fitur rowayat barang --}}
                @can('read riwayat-barang')
                    @if(auth()->user()->hasRole(['admin_logistik', 'divisi']))
                        <x-sidebar-link :href="url('riwayat-barang')" :active="request()->segment(1) == 'riwayat-barang'">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 7h18M3 11h18M3 15h18M3 19h18"></path>
                            </svg>
                            Riwayat
                        </x-sidebar-link>
                    @endif
                @endcan
            </div>
        </nav>

        <!-- User Profile Section -->
        <div class="absolute bottom-0 w-full border-t border-gray-100 dark:border-gray-700">
            <div class="px-4 py-3">
                
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    
                    <div class="ml-3">
                        <button id="userMenuButton" data-dropdown-toggle="userMenu" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                            <span class="mr-1">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div id="userMenu" class="hidden z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="font-medium truncate">{{ Auth::user()->email }}</div>
                            </div>
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            Log Out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>



<!-- JavaScript to control mobile sidebar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');
        
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                mobileSidebar.classList.toggle('-translate-x-full');
            });
        }
        
        if (sidebarBackdrop) {
            sidebarBackdrop.addEventListener('click', function() {
                mobileSidebar.classList.add('-translate-x-full');
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const themeToggleBtn = document.getElementById('themeToggle');
        const darkIcon = document.getElementById('themeToggleDarkIcon');
        const lightIcon = document.getElementById('themeToggleLightIcon');

        // Set icon on initial load
        if (localStorage.getItem('color-theme') === 'dark' || 
            (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            lightIcon.classList.remove('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            darkIcon.classList.remove('hidden');
        }

        themeToggleBtn.addEventListener('click', function () {
            darkIcon.classList.toggle('hidden');
            lightIcon.classList.toggle('hidden');

            // Toggle theme
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        });
    });
</script>