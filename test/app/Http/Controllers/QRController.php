<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{

    public function index()
    {
        return view("qrModule.qr_home");
    }

    // QR Home Page
    public function create($id)
    {
        $toy = DB::table('toys')->find($id);

        if ($toy) {
            // Generate URL for QR code
            $qrData = route('qr-code.generate', ['id' => $toy->id]);

            // Generate QR code as SVG
            $qrCode = QrCode::format('svg')->size(200)->generate($qrData);

            
            return view('qrModule.qr_page', [
                'toy' => $toy,        // Pass toy data to the view
                'qrCode' => $qrCode,  // Pass generated QR code to the view
            ]);
        } else {
            abort(404, 'Toy not found');
        }
    }
}