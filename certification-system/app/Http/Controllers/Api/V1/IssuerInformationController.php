<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\IssuerInformation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IssuerInformationController extends Controller
{
    public function index(Request $request)
    {
        try {

            $query = IssuerInformation::query();
            if ($request->has('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('OrganizationName', 'LIKE', "%{$search}%")
                        ->orWhere('IssuerFirstName', 'LIKE', "%{$search}%")
                        ->orWhere('IssuerLastName', 'LIKE', "%{$search}%");
                });
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
            $validated = $request->validate([
                'OrganizationName' => 'required|string|max:50|unique:issuer_information',
                'IssuerFirstName' => 'required|string|max:50',
                'IssuerMiddleName' => 'nullable|string|max:50',
                'IssuerLastName' => 'required|string|max:50',
                'Logo' => 'required|file|mimes:png,jpg,jpeg|max:5120',
                'IssuerSignature' => 'required|file|mimes:png,jpg,jpeg|max:5120'
            ]);

            DB::beginTransaction();
            try {
                // Handle Logo upload
                if ($request->hasFile('Logo')) {
                    $filename = Str::slug($validated['OrganizationName']) . '_logo_' . time() . '.' .
                        $request->file('Logo')->extension();

                    Storage::disk('public')->putFileAs(
                        'issuer_information/logos',
                        $request->file('Logo'),
                        $filename
                    );

                    $validated['Logo'] = 'issuer_information/logos/' . $filename;
                }

                // Handle Signature upload
                if ($request->hasFile('IssuerSignature')) {
                    $filename = Str::slug($validated['OrganizationName']) . '_signature_' . time() . '.' .
                        $request->file('IssuerSignature')->extension();

                    Storage::disk('public')->putFileAs(
                        'issuer_information/signatures',
                        $request->file('IssuerSignature'),
                        $filename
                    );

                    $validated['IssuerSignature'] = 'issuer_information/signatures/' . $filename;
                }

                $issuer = IssuerInformation::create($validated);
                DB::commit();

                return response()->json(['success' => true, 'data' => $issuer], 201);
            } catch (\Exception $e) {
                DB::rollBack();
                // Clean up any uploaded files
                if (isset($validated['Logo'])) {
                    Storage::disk('public')->delete($validated['Logo']);
                }
                if (isset($validated['IssuerSignature'])) {
                    Storage::disk('public')->delete($validated['IssuerSignature']);
                }
                throw $e;
            }

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create issuer',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $issuer = IssuerInformation::with('certifications')->findOrFail($id);
            return response()->json(['success' => true, 'data' => $issuer]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Issuer not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to retrieve issuer'], 500);
        }
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $issuer = IssuerInformation::findOrFail($id);

            $validated = $request->validate([
                'OrganizationName' => 'required|string|max:50|unique:issuer_information,OrganizationName,' . $id . ',IssuerID',
                'IssuerFirstName' => 'required|string|max:50',
                'IssuerMiddleName' => 'nullable|string|max:50',
                'IssuerLastName' => 'required|string|max:50',
                'Logo' => 'sometimes|required|file|mimes:png,jpg,jpeg|max:5120',
                'IssuerSignature' => 'sometimes|required|file|mimes:png,jpg,jpeg|max:5120'
            ]);

            $oldLogo = $issuer->Logo;
            $oldSignature = $issuer->IssuerSignature;
            $newLogoPath = null;
            $newSignaturePath = null;

            try {        
                // Handle Logo update
                if ($request->hasFile('Logo')) {
                    $filename = Str::slug($validated['OrganizationName']) . '_logo_' . time() . '.' .
                        $request->file('Logo')->extension();

                    Storage::disk('public')->putFileAs(
                        'issuer_information/logos',
                        $request->file('Logo'),
                        $filename
                    );

                    $newLogoPath = 'issuer_information/logos/' . $filename;
                    $validated['Logo'] = $newLogoPath;
                }

                // Handle Signature update
                if ($request->hasFile('IssuerSignature')) {
                    $filename = Str::slug($validated['OrganizationName']) . '_signature_' . time() . '.' .
                        $request->file('IssuerSignature')->extension();

                    Storage::disk('public')->putFileAs(
                        'issuer_information/signatures',
                        $request->file('IssuerSignature'),
                        $filename
                    );

                    $newSignaturePath = 'issuer_information/signatures/' . $filename;
                    $validated['IssuerSignature'] = $newSignaturePath;
                }

                $issuer->update($validated);

                // Delete old files
                if ($newLogoPath && $oldLogo) {
                    Storage::disk('public')->delete($oldLogo);
                }
                if ($newSignaturePath && $oldSignature) {
                    Storage::disk('public')->delete($oldSignature);
                }

                DB::commit();
                return response()->json(['success' => true, 'data' => $issuer]);

            } catch (\Exception $e) {
                // Clean up any new files if there was an error
                if ($newLogoPath) {
                    Storage::disk('public')->delete($newLogoPath);
                }
                if ($newSignaturePath) {
                    Storage::disk('public')->delete($newSignaturePath);
                }
                throw $e;
            }

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Issuer not found'], 404);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update issuer',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $issuer = IssuerInformation::findOrFail($id);

            if ($issuer->certifications()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete issuer with existing certifications'
                ], 409);
            }

            $logoPath = $issuer->Logo;
            $signaturePath = $issuer->IssuerSignature;

            $issuer->delete();

            // Delete associated files after successful database deletion
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            if ($signaturePath) {
                Storage::disk('public')->delete($signaturePath);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Issuer deleted successfully']);

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Issuer not found'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false, 
                'message' => 'Failed to delete issuer',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Display the issuer details on a web page.
     *
     * @param int $id The ID of the issuer.
     * @return \Illuminate\View\View The rendered view of the issuer details page.
     */
    public function showDetails($id)
    {
        $issuer = IssuerInformation::findOrFail($id);
        return view('issuers.details', ['issuer' => $issuer]);
    }

    /**
     * Serve the issuer's logo image.
     *
     * @param int $id The ID of the issuer
     * @return \Illuminate\Http\Response
     */

    public function getLogo($id)
    {
        try {
            $issuer = IssuerInformation::findOrFail($id);

            /* Storage::disk('public')->exists($issuer->Logo) checks if the file specified exists in the public storage disk
             Returns error response if file does not exist 
             */
            if (!$issuer->Logo || !Storage::disk('public')->exists($issuer->Logo)) { // Points to storage/app/public
                return response()->json([
                    'success' => false,
                    'message' => 'Logo not found'
                ], 404);
            }

            /*  storage_path('app/public/issuer_logos/example-logo.png') generates the absolute path
                $issuer->Logo contains issuer_logos/logo.jpg
            */
            return response()->file(  // Generates HTTP response that streams file content to client as downloadable or viewable file
                storage_path('app/public/' . $issuer->Logo) // Resolves to storage/app/public/[logo filename]
            );

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Issuer not found'
            ], 404);
        }
    }

    /**
     * Serve the issuer's signature image.
     *
     * @param int $id The ID of the issuer
     * @return \Illuminate\Http\Response
     * 
     */
    public function getSignature($id)
    {
        try {
            $issuer = IssuerInformation::findOrFail($id);

            if (!$issuer->IssuerSignature || !Storage::disk('public')->exists($issuer->IssuerSignature)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Signature not found'
                ], 404);
            }

            /*  storage_path('app/public/issuer_logos/example-logo.png') generates the absolute path
                $issuer->Logo contains issuer_logos/logo.jpg
            */
            return response()->file(  // Generates HTTP response that streams file content to client as downloadable or viewable file
                storage_path('app/public/' . $issuer->IssuerSignature) // Resolves to storage/app/public/[signature filename]
            );
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Issuer not found'
            ], 404);
        }
    }

    /* Call with:

    JS:
    const logoUrl = `api/v1/issuers/${IssuerId}/logo`;
    const signatureUrl = `api/v1/issuers/${IssuerId}/signature`;

    HTML:
    <img src="/api/v1/issuers/123/logo" alt="Issuer Logo">
    <img src="/api/v1/issuers/123/signature" alt="Issuer Signature">

    */



}
