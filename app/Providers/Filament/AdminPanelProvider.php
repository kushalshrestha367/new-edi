<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;
use Filament\Navigation\NavigationGroup;
use Outerweb\FilamentImageLibrary\Filament\Plugins\FilamentImageLibraryPlugin;
use Firefly\FilamentBlog\Blog;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->profile(isSimple: false)
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('18rem')
            ->login()
            // ->passwordReset()
            ->darkMode(true)
            // ->breadcrumbs(true)
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('CMS Management'),
                NavigationGroup::make()
                    ->label('Media Management'),
                NavigationGroup::make()
                    ->label('Career Management'),
                NavigationGroup::make()
                    ->label('Appointments Management'),
                NavigationGroup::make()
                    ->label('Department Management'),
                NavigationGroup::make()
                    ->label('Blog'),
                NavigationGroup::make()
                    ->label('User Management'),
                NavigationGroup::make()
                    ->label('Configuration'),
            ])
            
            // ->brandName('Saffron Infosys Pvt Ltd')
            ->brandName(config('app.name') . " Panel")
            ->brandLogo(fn() => view('filament.logo'))
            ->favicon(asset('favicon.ico'))
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 4,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),

                GlobalSearchModalPlugin::make(),
                FilamentImageLibraryPlugin::make(),
                Blog::make()
            ])
            ->globalSearch(true)
            ->spa()
            // ->viteTheme('resources/css/app.css')
        ;
    }
}
