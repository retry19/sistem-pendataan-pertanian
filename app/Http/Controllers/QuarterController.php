<?php

namespace App\Http\Controllers;

use App\Quarter;
use Illuminate\Http\Request;

class QuarterController extends Controller
{
    public function index()
    {
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
