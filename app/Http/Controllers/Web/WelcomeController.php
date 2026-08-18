<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutUs;
use App\Models\Career\Career;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Department;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\Contact;
use App\Models\Counter;
use App\Models\WhyChooseUs;
use App\Models\Faq;
use App\Models\Emergency;
use App\Models\Gallery;
use App\Models\GalleryVideo;
use App\Models\NewsEvent;
use App\Models\Program\ProgramCategory;
use App\Models\Program\ProgramList;
use App\Models\Slider;
use App\Models\TimeTable;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class WelcomeController extends Controller
{
    public function index()
    {
        $partnerDatas = Partner::where('is_active', true)->orderBy('sort_order')->get();

        $counterData = Counter::where('is_active', true)->latest()->first();

        $programData = ProgramList::where('is_active', true)->orderBy('sort_order')->get();

        $serviceDatas = Service::with([
            'items' => fn($q) => $q->where('is_active', true)->orderBy('sort_order')->take(6),
        ])->orderBy('sort_order')->where('is_active', true)->first();

        $newseventDatas = NewsEvent::where('is_published', true)->orderBy('sort_order')->take(3)->get();

        $testimonialDatas = Testimonial::where('is_active', true)->orderBy('sort_order')->take(4)->get();

        $teamDatas = Team::where('is_active', true)->where('has_message', true)->orderBy('sort_order')->get();

        $sliderDatas = Slider::where('is_active', true)->orderBy('sort_order')->get();

        $pageName = "Welcome";

        return view(
            'web.layouts.welcome',
            compact(
                'pageName',
                'counterData',
                'teamDatas',
                'programData',
                'serviceDatas',
                'partnerDatas',
                'newseventDatas',
                'testimonialDatas',
                'sliderDatas',
                
            ),
            [
                'seoModel' => new SEOData(
                    title: config('app.name', 'EDI Construction'),
                ),
            ]
        );
    }

    public function about()
    {
        $aboutData = AboutUs::with('achievements')->first();

        $pageName = "Know us better";

        $subPageName = $aboutData?->title ?? 'About Us';

        return view('web.page.about', compact('pageName', 'subPageName', 'aboutData'));
    }

    public function program()
    {
        $programDatas = ProgramCategory::with([
            'programs' => fn($q) => $q->where('is_active', true)->orderBy('sort_order'),
        ])->orderBy('sort_order')->where('is_active', true)->get();

        $pageName = "Programs We Offer";

        return view('web.page.program', compact('pageName', 'programDatas'));
    }

    public function newsAndEvent()
    {
        $newsAndEventDatas = NewsEvent::orderBy('sort_order', 'desc')->where('is_published', true)->paginate(7);

        $pageName = "News & Events";

        return view(
            'web.page.news-and-event',
            compact('pageName', 'newsAndEventDatas'),
            [
                'seoModel' => new SEOData(
                    title: $pageName,
                ),
            ]
        );
    }

    public function career()
    {
        $listDatas = Career::orderBy('sort_order')->where('is_active', true)->paginate(7);

        $pageName = "Career Opportunities";

        return view('web.page.career', compact('pageName', 'listDatas'));
    }

    public function service()
    {
        $serviceDatas = Service::with([
            'extras' => fn($q) => $q->where('is_active', true)->orderBy('sort_order'),
            'items' => fn($q) => $q->where('is_active', true)->orderBy('sort_order'),
        ])->orderBy('sort_order')->where('is_active', true)->first();

        $pageName = "Facilities We Provide";

        return view('web.page.service', compact('pageName', 'serviceDatas'));
    }

    // public function contact()
    // {
    //     $contactData = Contact::with([
    //         'socialMedia' => fn($q) => $q->orderBy('sort_order'),
    //         'branches' => fn($q) => $q->orderBy('sort_order')
    //     ])->first();
    //     $emergencyData = Emergency::where('is_active', true)
    //         ->orderBy('sort_order')
    //         ->get();

    //     $today = date('l');
    //     $timetable = Timetable::where('is_active', true)
    //         ->orderBy('sort_order')
    //         ->get()
    //         ->groupBy('day');


    //     $pageName = "Get in touch";

    //     return view('web.page.contact', compact('pageName', 'contactData', 'emergencyData', 'timetable', 'today'));
    // }

    public function contact()
{
    $contactData = Contact::with([
        'socialMedia' => fn($q) => $q->orderBy('sort_order'),
        'branches' => fn($q) => $q->orderBy('sort_order')
    ])->first();

    $emergencyData = Emergency::where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    $today = date('l');

    $timetable = Timetable::where('is_active', true)
        ->orderBy('sort_order')
        ->get()
        ->groupBy('day');

    $pageName = "Get in touch";

    return view(
        'web.page.contact',
        compact(
            'pageName',
            'contactData',
            'emergencyData',
            'timetable',
            'today'
        ),
        [
            'seoModel' => new SEOData(
                title: $pageName,
            ),
        ]
    );
}

    public function team()
    {
        $teamDatas = Team::where('is_active', true)->orderBy('sort_order')->get();
        $pageName = "Meet the creative minds behind our success";
        return view('web.page.team', compact(['pageName', 'teamDatas']));
    }

    public function department()
    {
        $departmentData = Department::with([
            'items' => fn($q) => $q->where('is_active', true)->orderBy('sort_order'),
        ])->orderBy('sort_order')->where('is_active', true)->get();

        $pageName = "Department";

        return view('web.page.department', compact('pageName', 'departmentData'));
    }

    public function faqs()
    {
        $faqDatas = Faq::orderBy('sort_order')
            ->where('is_active', true)
            ->get();

        $pageName = "FAQs";
        $subPageName = "Everything You Need to Know";
        return view(
            'web.page.faqs',
            compact(['pageName', 'subPageName', 'faqDatas']),
            [
                'seoModel' => new SEOData(
                    title: $pageName,
                ),
            ]
        );
    }

    public function gallery()
    {
        $galleryFolder = Gallery::with('images')->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(12);

        $pageName = "Memories in Frames";

        $subPageName = 'Explore Our Gallery';
        return view(
            'web.page.gallery',
            compact('pageName', 'subPageName', 'galleryFolder'),
            [
                'seoModel' => new SEOData(
                    title: $pageName,
                ),
            ]
        );
    }

    public function galleryVideo()
    {
        $galleryVideos = GalleryVideo::where('is_active', true)
            ->orderBy('sort_order', 'desc')
            ->paginate(8);

        $pageName = "Glimpses of Excellence";

        $subPageName = 'Stories in Motion';
        return view(
            'web.page.gallery-video',
            compact('pageName', 'subPageName', 'galleryVideos'),
            [
                'seoModel' => new SEOData(
                    title: $pageName,
                ),
            ]
        );
    }
}
