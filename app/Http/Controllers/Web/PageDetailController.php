<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Career\Career;
use Illuminate\Http\Request;
use App\Models\ServiceHasItem;
use App\Models\Department;
use App\Models\ContactBranch;
use App\Models\DepartmentHasItem;
use App\Models\Downloads\Download;
use App\Models\Team;
use App\Models\WhyChooseUs;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Program\ProgramList;
use App\Models\NewsEvent;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class PageDetailController extends Controller
{

    public function programItem(Request $request)
    {
        $programItemData = ProgramList::where('slug', $request->slug)
            ->where('is_active', true)
            ->with('activeFiles')
            ->firstOrFail();

        $pageName = "Program";
        $pageTitle = $programItemData->title ?? $pageName;

        return view('web.detail.program', compact('pageName', 'pageTitle', 'programItemData'));
    }

    public function newsAndEventItem(Request $request)
    {
        $itemData = NewsEvent::where('slug', $request->slug)
            ->where('is_published', true)
            ->firstOrFail();

        $itemDataRelated = NewsEvent::where('type', $itemData->type)
            ->where('is_published', true)
            ->where('id', '!=', $itemData->id)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        $pageName = "News & Event";
        $pageTitle = $itemData->title ?? $pageName;

        return view(
            'web.detail.news-and-event',
            compact('pageName', 'pageTitle', 'itemData', 'itemDataRelated'),
            [
                'seoModel' => new SEOData(
                    title: $pageTitle,
                ),
            ]
        );
    }

    public function downloadItem(Request $request)
    {
        $itemData = Download::where('slug', $request->slug)
            ->where('is_active', true)
            ->with('files')
            ->firstOrFail();

        $itemDataRelated = Download::where('is_active', true)
            ->where('id', '!=', $itemData->id)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        $pageName = "Download";
        $pageTitle = $itemData->title ?? $pageName;

        return view('web.detail.download', compact('pageName', 'pageTitle', 'itemData', 'itemDataRelated'));
    }

    public function careerItem(Request $request)
    {
        $itemData = Career::where('slug', $request->slug)
            ->where('is_active', true)
            ->with('applications')
            ->firstOrFail();

        $itemDataRelated = Career::where('department', $itemData->department)
            ->where('is_active', true)
            ->where('id', '!=', $itemData->id)
            ->take(3)
            ->get();

        $pageName = "Career";
        $pageTitle = $itemData->title ?? $pageName;

        return view('web.detail.career', compact('pageName', 'pageTitle', 'itemData', 'itemDataRelated'));
    }
    public function serviceItem(Request $request)
    {
        $serviceItemData = ServiceHasItem::where('slug', $request->slug)
            ->where('is_active', true)
            ->with('service') // Optional: if you need related service info
            ->firstOrFail();

        $pageName = "Facilities";
        $pageTitle = $serviceItemData->title ?? $pageName;

        return view('web.detail.service', compact('pageName', 'pageTitle', 'serviceItemData'));
    }

    public function contactBranch(Request $request)
    {
        $contactBranchData = ContactBranch::where('id', $request->slug)->firstOrFail();

        $pageName = "Contact";
        $pageTitle = $contactBranchData->name ?? $pageName;

        return view('web.detail.contactbranch', compact('pageName', 'pageTitle', 'contactBranchData'));
    }

    public function team(Request $request)
    {
        $team = Team::with('media')->where('slug', $request->slug)->first();
        $pageName = $team->designation ?? 'Team';
        $pageTitle = $team->name ?? $pageName;
        return view('web.detail.team', compact('pageTitle', 'team', 'pageName'));
    }
    public function whyChooseUs($slug)
    {
        $whyChooseUs = WhyChooseUs::findOrFail($slug);

        $pageName = "Why Choose Us";
        $pageTitle = $whyChooseUs->title ?? $pageName;
        return view('web.detail.whychooseus', compact('pageTitle', 'pageName', 'whyChooseUs'));
    }
    public function departmentListWithItem(Request $request)
    {
        $departmentData = Department::with([
            'items' => fn($q) => $q->where('is_active', true)
                ->orderBy('sort_order'),
        ])
            ->where('slug', $request->item)
            ->orderBy('sort_order')
            ->where('is_active', true)
            ->firstOrFail();

        $pageName = "Department";
        $pageTitle = $departmentData->title ?? $pageName;

        return view('web.detail.department-list', compact('pageName', 'pageTitle', 'departmentData'));
    }
    public function departmentItem(Request $request)
    {
        $department = DepartmentHasItem::where('slug', $request->slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Load members separately with pivot filters
        $department->load(['members' => function ($query) {
            $query->wherePivot('is_active', true) // ✅ filter pivot
                ->orderBy('department_members.sort_order', 'asc'); // ✅ order by actual pivot column
        }]);

        $pageName  = "Department";
        $pageTitle = $department->title ?? $pageName;

        return view('web.detail.department-item', compact('pageName', 'pageTitle', 'department'));
    }

    public function galleryItem(Request $request)
    {
        $galleryInfo = Gallery::where('slug', $request->slug)
            ->where('is_active', true)
            ->first();
        $galleryDatas = GalleryImage::where('gallery_id', $galleryInfo->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(16);

        $pageName = "Gallery";
        $pageTitle = $galleryInfo->title ?? $pageName;

        return view(
            'web.detail.gallery',
            compact(['pageName', 'pageTitle', 'galleryInfo', 'galleryDatas']),
            [
                'seoModel' => new SEOData(
                    title: $pageTitle,
                ),
            ]
        );
    }
}
