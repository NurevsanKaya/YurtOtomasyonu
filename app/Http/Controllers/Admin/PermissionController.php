<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Models\Permission;

class PermissionController
{
    public function index()
    {
        $leaves = Permission::with('user')->latest()->get();

        return view('admin.Permission.index', compact('leaves'));
    }

    public function approve($id)
    {
        $leave = Permission::findOrFail($id);
        $leave->status = 'approved';
        $leave->save();

        return back()->with('success', 'İzin onaylandı.');
    }

    public function reject($id)
    {
        $leave = Permission::findOrFail($id);
        $leave->status = 'rejected';
        $leave->save();

        return back()->with('error', 'İzin reddedildi.');
    }

}
