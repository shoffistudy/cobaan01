<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role; 

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create role
        $divisi = Role::firstOrCreate(['name' => 'divisi']);
        $admin_logistik = Role::firstOrCreate(['name' => 'admin_logistik']);
        $vendor_rekanan = Role::firstOrCreate(['name' => 'vendor_rekanan']);

         // create permission
         $read_vendor = Permission::firstOrCreate(['name' => 'read vendor']);
         $create_vendor = Permission::firstOrCreate(['name' => 'create vendor']);
         $update_vendor = Permission::firstOrCreate(['name' => 'update vendor']);
         $delete_vendor = Permission::firstOrCreate(['name' => 'delete vendor']);
 
         $read_pengajuan = Permission::firstOrCreate(['name' => 'read pengajuan-pembelian-barang']);
         $create_pengajuan = Permission::firstOrCreate(['name' => 'create pengajuan-pembelian-barang']);
         $update_pengajuan = Permission::firstOrCreate(['name' => 'update pengajuan-pembelian-barang']);
         $delete_pengajuan = Permission::firstOrCreate(['name' => 'delete pengajuan-pembelian-barang']);
 
         $read_rfq = Permission::firstOrCreate(['name' => 'read rfq']);
         $create_rfq = Permission::firstOrCreate(['name' => 'create rfq']);
         $update_rfq = Permission::firstOrCreate(['name' => 'update rfq']);
         $delete_rfq = Permission::firstOrCreate(['name' => 'delete rfq']);
         $send_rfq = Permission::firstOrCreate(['name' => 'send rfq']);
         $close_rfq = Permission::firstOrCreate(['name' => 'close rfq']);
         $select_rfq = Permission::firstOrCreate(['name' => 'select rfq']);

         $read_perbandingan = Permission::firstOrCreate(['name' => 'read perbandingan-harga']);
         $create_perbandingan = Permission::firstOrCreate(['name' => 'create perbandingan-harga']);
         $update_perbandingan = Permission::firstOrCreate(['name' => 'update perbandingan-harga']);
         $delete_perbandingan = Permission::firstOrCreate(['name' => 'delete perbandingan-harga']);
 
         $read_pemesanan = Permission::firstOrCreate(['name' => 'read pemesanan-barang']);
         $create_pemesanan = Permission::firstOrCreate(['name' => 'create pemesanan-barang']);
         $update_pemesanan = Permission::firstOrCreate(['name' => 'update pemesanan-barang']);
         $delete_pemesanan = Permission::firstOrCreate(['name' => 'delete pemesanan-barang']);
 
         $read_penerimaan = Permission::firstOrCreate(['name' => 'read penerimaan-barang']);
         $create_penerimaan = Permission::firstOrCreate(['name' => 'create penerimaan-barang']);
         $update_penerimaan = Permission::firstOrCreate(['name' => 'update penerimaan-barang']);
         $delete_penerimaan = Permission::firstOrCreate(['name' => 'delete penerimaan-barang']);
         

        // Permission untuk riwayat barang
        $read_riwayat = Permission::firstOrCreate(['name' => 'read riwayat-barang']);
        $delete_riwayat = Permission::firstOrCreate(['name' => 'delete riwayat-barang']);
        //$export_riwayat = Permission::firstOrCreate(['name' => 'export riwayat-barang']);
 
 
        // attach permission untuk role dengan guard 'web'
        $divisi->givePermissionTo([
            $read_pengajuan,
            $create_pengajuan,
            $update_pengajuan,
            $delete_pengajuan,
            $read_penerimaan,
            $read_riwayat
        ]);

        $admin_logistik->givePermissionTo([
            $read_vendor,
            $create_vendor,
            $update_vendor,
            $delete_vendor,
            $read_pengajuan,
            $read_rfq,
            $create_rfq,
            $update_rfq,
            $delete_rfq,
            $send_rfq,
            $close_rfq,
            $select_rfq,
            $read_perbandingan,
            $create_perbandingan,
            $update_perbandingan,
            $delete_perbandingan,
            $read_pemesanan,
            $create_pemesanan,
            $update_pemesanan,
            $delete_pemesanan,
            $read_penerimaan,
            $create_penerimaan,
            $update_penerimaan,
            $delete_penerimaan,
            $read_riwayat,
            $delete_riwayat
            //$export_riwayat
        ]);

        $vendor_rekanan->givePermissionTo([
            $create_vendor,
            $update_vendor,
            $delete_vendor,
            $read_perbandingan,
            $create_perbandingan,
            $update_perbandingan,
            $delete_perbandingan,
            $read_pemesanan,
            $read_penerimaan
        ]);

        // create user & assign role
        // User::factory()->create([
        //     'name' => 'Divisi',
        //     'email' => 'divisi@procurement.com',
        //     'password' => bcrypt('password')
        // ])->assignRole('divisi');

        // User::factory()->create([
        //     'name' => 'Admin Logistik',
        //     'email' => 'adminlogistik@procurement.com',
        //     'password' => bcrypt('password')
        // ])->assignRole('admin_logistik');

    //    User::factory()->create([
    //         'name' => 'Vendor',
    //         'email' => 'vendor@procurement.com',
    //         'password' => bcrypt('password')
    //     ])->assignRole('vendor');
    }
}