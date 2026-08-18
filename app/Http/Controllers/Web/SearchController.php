<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Career\Career;
use App\Models\Downloads\Download;
use App\Models\NewsEvent;
use App\Models\Notice;
use App\Models\Program\ProgramList;
use Illuminate\Http\Request;


class SearchController extends Controller
{
    public function searchAll(Request $request)
    {
        $query = trim($request->input('query'));

        if (!$query) {
            return redirect()->back()->with([
                'message' => 'Search failed. Please enter a search term.',
                'alert-type' => 'error',
            ]);
        }

        $query = str_replace(['%', '_'], '', $query);

        try {
            $results = [
                'programs' => ProgramList::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orderBy('sort_order', 'desc')
                    ->where('is_active', true)
                    ->limit(10)
                    ->get(),

                'downloads' => Download::where('title', 'LIKE', "%{$query}%")
                    ->with('files')
                    ->orderBy('sort_order', 'desc')
                    ->where('is_active', true)
                    ->limit(10)
                    ->get(),

                'careers' => Career::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('department', 'LIKE', "%{$query}%")
                    ->orderBy('sort_order', 'desc')
                    ->where('is_active', true)
                    ->limit(10)
                    ->get(),

                'news' => NewsEvent::where('type', 'news')
                    ->where('title', 'LIKE', "%{$query}%")
                    ->orderBy('sort_order', 'desc')
                    ->where('is_published', true)
                    ->limit(10)
                    ->get(),

                'events' => NewsEvent::where('type', 'event')
                    ->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('event_location', 'LIKE', "%{$query}%")
                    ->orderBy('sort_order', 'desc')
                    ->where('is_published', true)
                    ->limit(10)
                    ->get(),

                'notices' => Notice::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orderBy('sort_order', 'desc')
                    ->where('is_active', true)
                    ->limit(10)
                    ->get(),
            ];
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Search failed. Something went wrong.',
                'alert-type' => 'error',
            ]);
        }

        $pageName = "Search Results for ";
        $subPageName = '"' . $query . '"';

        return view('web.search.results', compact('pageName', 'subPageName', 'results', 'query'));
    }
}
