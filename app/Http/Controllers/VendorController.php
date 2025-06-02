<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Unique;

class VendorController extends Controller
{
    //
    public function index()
    {
        $vendors = Vendor::paginate(10);
        return view('pages.vendor', compact('vendors'));

    }

    public function create(Vendor $vendor)
    {
        return view('pages.vendor-form', compact('vendor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_vendor' => 'required|max:255',
            'email' => 'required|email|max:255|unique:vendor,email',
            'npwp' => 'required|max:16',
            'alamat' => 'required',
            'pic' => 'required|max:255',
            'kontak_pic' => 'required|max:15',
            'password' => 'required|min:8|confirmed',
        ]);
        try {
            Vendor::create([
                'nomor' => numbering('vendor', 'CR' . date('ym')),
                'nama' => $request->nama_vendor,
                'email' => $request->email,
                'npwp' => $request->npwp,
                'alamat' => $request->alamat,
                'pic' => $request->pic,
                'kontak_pic' => $request->kontak_pic,
                'password' => Hash::make($request->password)
            ]);
            

            return redirect()->route('login')->with('status', 'Registrasi berhasil. Silakan login.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data gagal disimpan');
        }
    }

    //edit vendor
    public function edit(Vendor $vendor)
    {
        return view('pages.vendor-form', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'nama_vendor' => 'required|max:255',
            'email' => 'required|email|max:255',
            'npwp' => 'required|max:16',
            'alamat' => 'required',
            'pic' => 'required|max:255',
            'kontak_pic' => 'required|max:15'
        ]);
        try {
            $vendor->fill([
                'nama' => $request->nama_vendor,
                'email' => $request->email,
                'npwp' => $request->npwp,
                'alamat' => $request->alamat,
                'pic' => $request->pic,
                'kontak_pic' => $request->kontak_pic
            ])->save();

            return redirect('vendor')->with('success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data gagal diubah');
        }
    }

    //destroy
    public function destroy(Vendor $vendor)
    {
        try {
            $vendor->delete();

            return redirect('vendor')->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }
    }
    
}

