<?php

namespace App\Http\Controllers;

use App\Quarter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuarterController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('quarters_management_access'), 403);
        
        $quarters = Quarter::all();

        return view('quarters', compact('quarters'));
    }

    public function active(Quarter $quarter, Request $request)
    {
        $quarter->is_active = true;
        $quarter->save();

        Quarter::where('id', '!=', $quarter->id)->update([
            'is_active' => false,
        ]);

        return redirect()->back();
    }
}
