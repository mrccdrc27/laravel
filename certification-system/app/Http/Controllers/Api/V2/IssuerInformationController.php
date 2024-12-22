<?php

namespace App\Http\Controllers\Api\V2;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\V2\IssuerInformation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IssuerInformationController extends Controller
{
    public function index(Request $request)
    {
        try {

            $query = IssuerInformation::query();
            if ($request->has('search')) {
                $search = $request->search;
                $query->where('OrganizationName', 'LIKE', "%{$search}%")
                    ->orWhere('IssuerFirstName', 'LIKE', "%{$search}%")
                    ->orWhere('IssuerLastName', 'LIKE', "%{$search}%");
            }


            $issuers = $query->paginate($request->get('per_page', 10));

            return response()->json([
                'success' => true,
                'data' => $issuers->items(),
                'meta' => [
                    'total' => $issuers->total(),
                    'current_page' => $issuers->currentPage(),
                    'last_page' => $issuers->lastPage(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to retrieve issuers'], 500);
        }
    }


    public function store(Request $request)
    {

        // does not have a proper way of validation:


        $request->validate([
            'OrganizationName' => 'required|string|max:50',
            'IssuerFirstName' => 'required|string|max:50',
            'IssuerMiddleName' => 'nullable|string|max:50',
            'IssuerLastName' => 'required|string|max:50',
            'Logo' => 'required|file|mimes:png,jpg,jpeg|max:5120',
            'IssuerSignature' => 'required|file|mimes:png,jpg,jpeg|max:5120',
        ]);
    
        //binary convert Logo
        $logo = file_get_contents($request->file('Logo')->getRealPath());
        $logoData = unpack("H*hex", $logo);
        $logoData = '0x' . $logoData['hex'];
        //binary convert Signature
        $signature = file_get_contents($request->file('IssuerSignature')->getRealPath());
        $signatureData = unpack("H*hex", $signature);
        $signatureData = '0x' . $signatureData['hex'];

        $IssuerInformation = IssuerInformation::create([
            'OrganizationName' => $request->OrganizationName,
            'IssuerFirstName' => $request->IssuerFirstName,
            'IssuerMiddleName' => $request->IssuerMiddleName,
            'IssuerLastName' => $request->IssuerLastName,
            'Logo' => DB::raw("CONVERT(VARBINARY(MAX), {$logoData})"),
            'IssuerSignature' =>  DB::raw("CONVERT(VARBINARY(MAX), {$signatureData})"),
        ]);
    
        return response()->json(['success' => true, 'data' => $IssuerInformation], 201);
    }

    public function show($id)
    {
        try {
            $issuer = IssuerInformation::find($id);
            return response()->json(['success' => true, 'data' => $issuer]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Issuer not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to retrieve issuer'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $issuer = IssuerInformation::findOrFail($id);

            // Delete files
            if ($issuer->Logo) {
                Storage::disk('public')->delete($issuer->Logo);
            }
            if ($issuer->IssuerSignature) {
                Storage::disk('public')->delete($issuer->IssuerSignature);
            }

            $issuer->delete();

            return response()->json(['success' => true, 'message' => 'Issuer deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Issuer not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete issuer'], 500);
        }
    }


}
