<?php

namespace App\Providers;

use App\Models\AboutUs;
use Illuminate\Support\ServiceProvider;
use App\Models\Setup;
use App\Models\Contact;
use App\Models\Notice;
use App\Models\Team;
use App\Models\Department;
use App\Models\Downloads\Download;
use App\Models\Emergency;
use App\Models\Slider;
use App\Models\ServiceHasItem;
use App\Models\Hero;
use Illuminate\Http\Request;
use Firefly\FilamentBlog\Models\Setting;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Request $request): void
    {
        Builder::defaultStringLength(191);

        View::composer('web.layouts.app', function ($view) {
            if (isset($view->getData()['seoModel'])) {
                return;
            }

            foreach ($view->getData() as $value) {
                if (is_object($value) && in_array(HasSEO::class, class_uses_recursive($value))) {
                    $view->with('seoModel', $value);
                    return;
                }
            }
        });

        collect([
            'Post',
            'Category',
            'Tag',
            'SeoDetail',
            'Comment',
            'NewsLetter',
            'ShareSnippet',
            'Setting',
        ])->each(fn($model) => Gate::policy(
            "Firefly\\FilamentBlog\\Models\\{$model}",
            "App\\Policies\\{$model}Policy"
        ));

        // Image Library page permission
        // Gate::define('image_library', function ($user) {
        //     return $user->hasPermissionTo('page_ImageLibrary');
        // });

        view()->composer(['web.layouts.app', 'web.layouts.header', 'web.layouts.header-side'], function ($view) use ($request) {
            $view->with('site_setting', Setup::getSetupData($request));
            $view->with('site_contact', Contact::getContactData($request));

            $setting = Setting::query()->first();
            $view->with('blog_quick_links', $setting?->quick_links ?? []);
            $view->with('blog_setting', $setting ?? []);

            // $view->with('site_notices', Notice::getNoticeData($request));

            $view->with('app_about', AboutUs::query()->first());
        });

        view()->composer([
            'filament-blog::layouts.app',
            'filament-blog::components.header',
            'filament-blog::components.header-category',
            'filament-blog::components.blog',
            'filament-blog::components.comment',
            'filament-blog::blogs.show',
        ], function ($view) use ($request) {
            $view->with('site_setting', Setup::getSetupData($request));
        });

        view()->composer(['web.layouts.nav'], function ($view) use ($request) {
            $view->with('site_team', Team::getTeamData($request));
            $view->with('site_emergency', Emergency::getEmergencyData($request));
            $view->with('site_service_items', ServiceHasItem::getServiceHasItemData($request));
            $view->with('download_items', Download::getDownloadDatas($request));
            $view->with('department_isEmpty', Department::exists());
        });

        // view()->composer(['web.layouts.slider'], function ($view) use ($request) {
        //     $view->with('site_slider', Slider::getSliderData($request));
        //     $view->with('site_notices', Notice::getNoticeData($request));
        // });

        view()->composer(['web.welcome'], function ($view) use ($request) {
            $view->with('site_setting_first', Setup::getSetupData($request));
            $view->with('site_slider', Slider::getSliderData($request));
            $view->with('notice_list_data', Notice::getNoticeLatestList($request));
            $view->with('notice_pop', Notice::getNoticePopList($request));

            // blog
            $setting = Setting::query()->first();
            $view->with('affiliated_with', $setting?->affiliated_with ?? []);
            $view->with('site_title', $setting?->title ?? []);
        });

        // view()->composer(['web.welcome'], function ($view) use ($request) {
        //     $setting = Setting::query()->first();
        //     $view->with('blog_setting', $setting ?? []);
        // });

        view()->composer(['web.layouts.hero'], function ($view) use ($request) {
            $view->with('hero_section', Hero::query()->where('is_active', true)->latest()->first());
        });
    }
}
