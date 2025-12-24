<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert;

class AlertController extends Controller
{
    public function index()
    {
        // Mark all unread alerts as read
        Alert::where('is_read', false)->update(['is_read' => true]);

        // Use pagination instead of get()
        $alerts = Alert::latest()->paginate(10);

        return view('admin.alerts.index', compact('alerts'));
    }

    public function destroy(Alert $alert)
    {
        $alert->delete();

        return redirect()->route('admin.alerts.index')->with('success', 'Alert deleted successfully.');
    }
}
