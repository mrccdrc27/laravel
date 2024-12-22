<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\IssuerInformation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
        try {
            $validated = $request->validate(
                [
                    'OrganizationName' => 'required|string|max:50',
                    'IssuerFirstName' => 'required|string|max:50',
                    'IssuerMiddleName' => 'nullable|string|max:50',
                    'IssuerLastName' => 'required|string|max:50',
                    'Logo' => 'required|file|mimes:png,jpg,jpeg|max:5120',
                    'IssuerSignature' => 'required|file|mimes:png,jpg,jpeg|max:5120'
                ]
            );

            if ($request->hasFile('Logo')) {
                $validated['Logo'] = file_get_contents($request->file('Logo'));
            }

            if ($request->hasFile('IssuerSignature')) {
                $validated['IssuerSignature'] = file_get_contents($request->file('IssuerSignature'));
            }

            $issuer = IssuerInformation::create($validated);

            return response()->json(['success' => true, 'data' => $issuer], 201);

        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to create issuer'], 500);


        }
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
    public function update(Request $request, $id)
    {
        try {
            $issuer = IssuerInformation::findOrFail($id);

            $validated = $request->validate(
                [
                    'OrganizationName' => 'required|string|max:50',
                    'IssuerFirstName' => 'required|string|max:50',
                    'IssuerMiddleName' => 'nullable|string|max:50',
                    'IssuerLastName' => 'required|string|max:50',
                    'Logo' => 'required|file|mimes:png,jpg,jpeg|max:5120',
                    'IssuerSignature' => 'required|file|mimes:png,jpg,jpeg|max:5120'
                ]
            );
            // Handle file replacements
            if ($request->hasFile('Logo')) {
                if ($issuer->Logo) {
                    Storage::disk('public')->delete($issuer->Logo);
                }
                $validated['Logo'] = $request->file('Logo')->store('issuer_logos', 'public');
            }
            if ($request->hasFile('IssuerSignature')) {
                if ($issuer->IssuerSignature) {
                    Storage::disk('public')->delete($issuer->IssuerSignature);
                }
                $validated['IssuerSignature'] = $request->file('IssuerSignature')->store('issuer_signatures', 'public');
            }
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
