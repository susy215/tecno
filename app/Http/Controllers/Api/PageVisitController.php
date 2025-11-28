<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;
use Illuminate\Http\Request;

class PageVisitController extends Controller
{
    public function store(Request $request)
    {
        $page = $request->input('page');
        $visit = PageVisit::firstOrCreate(['page' => $page]);
        $visit->increment('count');
        return response()->json(['success' => true]);
    }

    public function topPages()
    {
        return PageVisit::orderBy('count', 'desc')->take(10)->get();
    }

    public function getCount(Request $request)
    {
        $page = $request->input('page');
        $visit = PageVisit::where('page', $page)->first();
        return response()->json(['count' => $visit ? $visit->count : 0]);
    }

    public function getTotalCount()
    {
        $total = PageVisit::sum('count');
        return response()->json(['total' => $total]);
    }
}
