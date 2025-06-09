<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;

class AssignUserToVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua user
        $users = User::all();

        foreach ($users as $user) {
            // Cari vendor yang email-nya sama dan user_id-nya masih kosong
            $vendor = Vendor::where('email', $user->email)->whereNull('user_id')->first();

            if ($vendor) {
                $vendor->user_id = $user->id;
                $vendor->save();

                $this->command->info("✅ User '{$user->email}' berhasil dihubungkan ke vendor '{$vendor->nama}'");
            } else {
                $this->command->warn("⚠️ Tidak ditemukan vendor dengan email: {$user->email} atau sudah terhubung.");
            }
        }
    }
}
