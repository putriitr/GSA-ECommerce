<?php

namespace App\Http\Controllers\Customer\User;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{

    public function show()
    {
        // Get the authenticated user and their addresses
        $user = auth()->user();
        $addresses = $user->addresses;
    
        // Pass the user and addresses to the view
        return view('customer.settings.account.address.show', compact('user', 'addresses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'label_alamat' => 'required|string|max:255',
            'nama_penerima' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'provinsi' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'kodepos' => 'required|string|max:10',
            'kecamatan' => 'required|string|max:255',
            'detail_alamat' => 'required|string',
            'is_active' => 'boolean', // Handle active status
        ]);
    
        $user = auth()->user();
    
        // Check if it's the user's first address
        $hasExistingAddresses = UserAddress::where('user_id', $user->id)->exists();
    
        // If it's the first address, automatically set it as active
        if (!$hasExistingAddresses) {
            $validatedData['is_active'] = true;
        } else {
            // If the new address is set as active, deactivate all other addresses
            if ($request->input('is_active', false)) {
                UserAddress::where('user_id', $user->id)->update(['is_active' => false]);
            }
        }
    
        // Manually associate the user ID and create the address
        $validatedData['user_id'] = $user->id;
    
        UserAddress::create($validatedData);
        
        return back()->with('success', 'Alamat berhasil ditambahkan.');
    }
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'label_alamat' => 'required|string|max:255',
            'nama_penerima' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'provinsi' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'kodepos' => 'required|string|max:10',
            'kecamatan' => 'required|string|max:255',
            'detail_alamat' => 'required|string',
            'is_active' => 'boolean', // Handle active status
        ]);

        $user = auth()->user();
        $address = UserAddress::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        // If the new address is set as active, deactivate all other addresses
        if ($request->input('is_active', false)) {
            UserAddress::where('user_id', $user->id)->update(['is_active' => false]);
        }

        // Update the address with the new data
        $address->update($validatedData);

        return back()->with('success', 'Alamat berhasil diperbarui.');
    }

    public function setActive($id)
    {
        $user = auth()->user();

        // Deactivate all addresses for this user
        UserAddress::where('user_id', $user->id)->update(['is_active' => false]);

        // Set the selected address as active
        UserAddress::where('id', $id)->update(['is_active' => true]);

        return back()->with('success', 'Alamat berhasil diaktifkan.');
    }

    public function delete($id)
    {
        $address = UserAddress::findOrFail($id);

        // Prevent deleting active address without another address being active
        if ($address->is_active) {
            return back()->with('error', 'Tidak bisa menghapus alamat aktif. Silakan aktifkan alamat lain terlebih dahulu.');
        }

        $address->delete();

        return back()->with('success', 'Alamat berhasil dihapus.');
    }
}
