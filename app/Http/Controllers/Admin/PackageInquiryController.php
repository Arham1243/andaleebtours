<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackageInquiry;
use Illuminate\Http\Request;

class PackageInquiryController extends Controller
{
    public function index()
    {
        $title = 'Package Inquiries';
        $inquiries = PackageInquiry::with(['package', 'package.category'])->orderBy('created_at', 'desc')->get();
        return view('admin.packages.inquiries.list', compact('inquiries', 'title'));
    }

    public function show(PackageInquiry $packageInquiry)
    {
        $title = 'Package Inquiry Details';
        $packageInquiry->load(['package', 'package.category']);
        return view('admin.packages.inquiries.details', compact('packageInquiry', 'title'));
    }

    public function destroy(PackageInquiry $packageInquiry)
    {
        $packageInquiry->delete();
        return redirect()->route('admin.package-inquiries.index')->with('notify_success', 'Package Inquiry deleted successfully!');
    }
}
