<?php

use App\Http\Controllers\corecontroller;
use App\Http\Controllers\ToyController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return redirect('/toys/');
});

Route::get('/toys', [ToyController::class, 'index']);

Route::get('/core', [corecontroller::class, 'index']);

Route::get('/qr-code/{id}', function($id) {

    $toy = DB::table('toys')->find($id);


    if ($toy) {
        //URL for Toy
        $qrData = url("/toys/{$toy->id}");

        // Generate QR code as svg
        $qrCode = QrCode::format('svg')->size(200)->generate($qrData);

        // View for toy details
        return view('qr_code', [
            'toy' => $toy,        // Pass the toy data to the view
            'qrCode' => $qrCode,  // Pass the generated QR code to the view
        ]);
    } else {
        return 'Toy not found';
    }
});
