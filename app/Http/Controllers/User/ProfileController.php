<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function updateAddress(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string'
        ]);

        $user = Auth::user();

        $user->address = $validated['address'];
        $user->save();

        return redirect()->route('user.cart.index')->with('success', 'Berhasil menambahkan alamat');
    }
}
