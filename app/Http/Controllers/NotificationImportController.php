<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\NotificationImport;
use Maatwebsite\Excel\Facades\Excel;

class NotificationImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:2048',
        ]);

        try {
            Excel::import(new NotificationImport, $request->file('file'));
            return back()->with('success', 'Notifications imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error during import: ' . $e->getMessage());
        }
    }
}
