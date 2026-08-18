<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class NoticeController extends Controller
{
    public function latestList()
    {
        $data_lists = Notice::where('is_active', True)
            ->orderBy('id', 'DESC')

            ->paginate(10);
        $page_name = "Notice";
        return view(
            'web.notice.list',
            compact(['data_lists', 'page_name']),
            [
                'seoModel' => new SEOData(
                    title: $page_name,
                ),
            ]
        );
    }

    public function detail(Request $request)
    {
        $data_list = Notice::where('slug', $request->slug)->first();

        $pageName = "Notice";
        $pageTitle = $data_list->title ?? $pageName;

        if (!$data_list) {
            return abort(404);
        }

        return view(
            'web.notice.detail',
            compact(['pageName', 'pageTitle', 'data_list']),
            [
                'seoModel' => new SEOData(
                    title: $pageTitle,
                ),
            ]
        );
    }
}
