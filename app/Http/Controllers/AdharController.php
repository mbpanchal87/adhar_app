<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adhar;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AdharController extends Controller
{
    private $encryptionKey;

    public function __construct()
    {
        $this->encryptionKey = env('ENCRYPTION_KEY');
    }
    
    public function updateAdharView(Request $request)
    {
        $user = Auth::user(); 
        //$aadhar = Adhar::where('user_id', $user->id)->first();
        $result = $this->getAdhar($user);
        $adhar_card = !empty($result[0]) ? $result[0]->decrypted_value : '';

        // Format Aadhaar number as XXXX-XXXX-XXXX
        if (!empty($adhar_card)) {
            $adhar_card = preg_replace('/(\d{4})(?=\d)/', '$1-', $adhar_card);
        }

        return view('update-adhar', compact('user', 'adhar_card'));
    }
    public function updateAdhar(Request $request)
    {
        $request->validate([
            'aadhar_card' => 'required|regex:/^\d{4}-\d{4}-\d{4}$/|unique:adhars,adhar_card',
        ]);
        $adhar_card = preg_replace('/\D/', '', $request->aadhar_card);
        
        $duplicate = $this->checkDuplicateAdhar($adhar_card);
        
        if ($duplicate) {
            return back()->withErrors(['error' => 'Duplicate Aadhaar number found!'])->withInput();
        }
        
        // Insert or update Aadhaar card details
        $add_update = $this->addUpdateAdhar($adhar_card);
        
        // Return success response
        return back()->with('success', 'Aadhaar card updated successfully.');
    }
    public function checkDuplicateAdhar($adhar_card)
    {
        return $duplicate = DB::table('adhars')
            ->whereRaw("adhar_card = TO_BASE64(AES_ENCRYPT(?, ?))", [$adhar_card, $this->encryptionKey])
            ->where('user_id', '!=', Auth::id())
            ->exists();
    }
    public function addUpdateAdhar($adhar_card)
    {
        $add_update = DB::table('adhars')->updateOrInsert(
            ['user_id' => Auth::id()],
            [
                'adhar_card' => DB::raw("TO_BASE64(AES_ENCRYPT('$adhar_card', '" . $this->encryptionKey . "'))"),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        return $add_update;
    }
    public function getAdhar($user)
    {
        $result = DB::table('adhars')
            ->select(
                DB::raw(
                    'CAST(AES_DECRYPT(FROM_BASE64(adhar_card), "' . $this->encryptionKey . '") AS CHAR) as decrypted_value'
                )
            )
            ->where('user_id', $user->id)
            ->get();
        return $result;
    }
}
