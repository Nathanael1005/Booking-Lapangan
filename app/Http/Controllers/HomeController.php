<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Lapangan;
use App\Models\Sewa;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }

    public function sewalapangan()
    {
        $lapangans = Lapangan::all();
        return view ('sewalapangan', ['lapangans' => $lapangans]);
    }

    

    public function formsewa(Request $request)
    {
        $receivedData = $request->input('lapangan_id');
        $lapangan = Lapangan::find($receivedData);

        return view('formsewa', compact('lapangan'));
    }

    public function sewastore(Request $request){
        $messages = [
            'required' => ': Attribute harus diisi.'
            ];
            $validator = Validator::make($request->all(), [
                'namaPenyewa' => 'required',
                'tanggal' => 'required',
                'jamMulai' => 'required',
                'jamSelesai' => 'required'
            ], $messages);
            if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
            }
            // ELOQUENT
            $sewa = New Sewa;
            $sewa->nama_penyewa = $request->namaPenyewa;
            $sewa->jam_mulai = $request->jamMulai;
            $sewa->jam_selesai = $request->jamSelesai;
            $sewa->tanggal = $request->tanggal;
            $sewa->biayatotal = $request->biayaTotal;
            $sewa->lapangan_id = $request->lapanganId;
            $sewa->acc = $request->acc;
            $sewa->save();
            return redirect()->route('sewalapangan');
    }
}
