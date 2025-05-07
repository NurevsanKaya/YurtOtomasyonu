<?php

namespace App\Http\Controllers\Admin;

use App\Models\Visitor;

class VisitorController
{
    public function index()
    {
        $visitors = Visitor::with('student.user')->latest()->get(); // öğrenci ve kullanıcı bilgisi ile birlikte çek
        return view('admin.Visitor.index', compact('visitors'));
    }
    public function approve($id)
    {
        $visitor = Visitor::findOrFail($id);
        $visitor->visit_approval = true;
        $visitor->save();

        return redirect()->back()->with('success', 'Ziyaret onaylandı.');
    }
    public function reject($id)
    {
        $visitor = Visitor::findOrFail($id);
        $visitor->visit_approval = false;
        $visitor->save();

        return redirect()->back()->with('error', 'Ziyaret reddedildi.');
    }

}
