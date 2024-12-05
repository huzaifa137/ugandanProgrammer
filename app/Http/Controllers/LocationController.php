<?php

namespace App\Http\Controllers;

use App\Models\GenerateLink;
use Illuminate\Http\Request;
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

        return view('tracking.de-activate-track-link',compact(['Links']));
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

            AuditTrailController::register('TRACK LINK GENERATED', 'ADMIN Username: <b>' . Helper::full_name(Session('LoggedAdmin')) . '</b> Pasword: <b>*******</b>');


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
        $ipStatus = GenerateLink::where('id',$id)->value('gl_active_status');
        
        $post = GenerateLink::find($id);

        if($ipStatus == 0)
        {
            $post->gl_active_status = 1;
            AuditTrailController::register('TRACK LINK ACTIVATED', 'ADMIN Username: <b>' . Helper::full_name(Session('LoggedAdmin')) . '</b> Pasword: <b>*******</b>');

        }
        else
        {
            $post->gl_active_status = 0;
            AuditTrailController::register('TRACK LINK DE-ACTIVATED', 'ADMIN Username: <b>' . Helper::full_name(Session('LoggedAdmin')) . '</b> Pasword: <b>*******</b>');

        }
        $post->save();

        return back();

    }
}
