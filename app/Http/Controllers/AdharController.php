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
    public function updateAdharView(Request $request)
    {
        $ENCRYPTION_KEY = env('ENCRYPTION_KEY');
        $user = Auth::user(); 
        //$aadhar = Adhar::where('user_id', $user->id)->first();
        $result = DB::table('adhars')
            ->select(DB::raw('CAST(AES_DECRYPT(FROM_BASE64(adhar_card), "'.$ENCRYPTION_KEY.'") AS CHAR) as decrypted_value'))
            ->where('user_id', $user->id)
            ->get();
        if(!empty($result[0]))
        {
            $adhar_card= $result[0]->decrypted_value;
            $adhar_card = preg_replace('/(\d{4})(?=\d)/', '$1-', $adhar_card);
        }
        else
        {
            $adhar_card = "";
        }
        return view('update-adhar', compact('user','adhar_card'));
    }
    public function updateAdhar(Request $request)
    {
        //echo $request->aadhar_card;
        $ENCRYPTION_KEY = env('ENCRYPTION_KEY');
        $request->validate([
            'aadhar_card' => 'required|regex:/^\d{4}-\d{4}-\d{4}$/|unique:adhars,adhar_card',
        ]);
        $adhar_card = preg_replace('/\D/', '', $request->aadhar_card);
        
        $duplicate = DB::table('adhars')
            ->whereRaw("adhar_card = TO_BASE64(AES_ENCRYPT(?, ?))", [$adhar_card, $ENCRYPTION_KEY])
            ->where('user_id', '!=', Auth::id())
            ->exists();
        if($duplicate)
        {
            return back()->with(['error' => 'Duplicate Aadhaar number found!'], 400);
        }
        DB::table('adhars')->updateOrInsert(
           ['user_id' => Auth::id()],
           ['adhar_card' => DB::raw("TO_BASE64(AES_ENCRYPT($adhar_card, '" . $ENCRYPTION_KEY . "'))"),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        session()->flash('success', 'Adhar card updated successfully.');

        return back()->with('success', 'Adhar card updated successfully.');
    }
}
