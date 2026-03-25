<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\OrganizationStructure;
use App\Models\SiteSetting;

class AboutController extends Controller
{
    public function index()
    {
        return view('public.about.index');
    }

    public function structure()
    {
        $structures = OrganizationStructure::active()->ordered()->get();
        return view('public.about.structure', compact('structures'));
    }
}
