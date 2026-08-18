<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Web\PageDetailController;
use App\Http\Controllers\Web\WelcomeController;
use App\Http\Controllers\Web\FormController;
use App\Http\Controllers\Web\NoticeController;
use App\Http\Controllers\Web\SearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/all-cache-clear', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('optimize');
    // $exitCode = Artisan::call('migrate');
    //$exitCode = Artisan::call('storage:link');
    return 'DONE';
})->name('all.clear');

// Route::get('/link-storage', function () {
//     $targetFolder = storage_path('app/public');
//     $targetFolder_or = base_path().'/storage/app/public';
//     $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
//     symlink($targetFolder, $linkFolder);
// });

Route::group(['as' => ''], function () {
    Route::group(['namespace' => 'App\Http\Controllers\Web'], function () {

        Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
        Route::get('/about/introduction', [WelcomeController::class, 'about'])->name('about');
        Route::get('/award-&-accolader', [WelcomeController::class, 'awardAccolader'])->name('award&accolader');
        Route::get('/facilities', [WelcomeController::class, 'service'])->name('service');
        Route::get('/contact', [WelcomeController::class, 'contact'])->name('contact');
        Route::get('/department', [WelcomeController::class, 'department'])->name('department');
        Route::get('/faqs', [WelcomeController::class, 'faqs'])->name('faqs');
        Route::get('/gallery/folder', [WelcomeController::class, 'gallery'])->name('gallery');
        Route::get('/gallery/video', [WelcomeController::class, 'galleryVideo'])->name('gallery.video');
        Route::get('/program', [WelcomeController::class, 'program'])->name('program');
        Route::get('/news-and-event', [WelcomeController::class, 'newsAndEvent'])->name('news-and-event');
        Route::get('/career', [WelcomeController::class, 'career'])->name('career');
        Route::get('/team', [WelcomeController::class, 'team'])->name('team');

        Route::get('/test-preparation/{slug}', [PageDetailController::class, 'testpreparation'])->name('testpreparation.detail');
        Route::get('/team/{slug}', [PageDetailController::class, 'team'])->name('team.detail');
        Route::get('/whychooseus/{slug}', [PageDetailController::class, 'whychooseus'])->name('whychooseus.detail');
        Route::get('/facilities/{slug}', [PageDetailController::class, 'serviceItem'])->name('service.item.detail');
        Route::get('/department/{item}', [PageDetailController::class, 'departmentListWithItem'])->name('department.detail');
        Route::get('/department/{item}/{slug}', [PageDetailController::class, 'DepartmentItem'])->name('department.item.detail');
        Route::get('/contact/branch/{slug}', [PageDetailController::class, 'contactBranch'])->name('contact.branch.detail');
        Route::get('/gallery/{slug}', [PageDetailController::class, 'galleryItem'])->name('gallery.item.detail');
        Route::get('/program/{slug}', [PageDetailController::class, 'programItem'])->name('program.item.detail');
        Route::get('/news-and-event/{slug}', [PageDetailController::class, 'newsAndEventItem'])->name('news-and-event.item.detail');
        Route::get('/download/{slug}', [PageDetailController::class, 'downloadItem'])->name('download.item.detail');
        Route::get('/career/{slug}', [PageDetailController::class, 'careerItem'])->name('career.item.detail');

        Route::post('/career/{slug}/apply', [FormController::class, 'careerItemApply'])->name('career.form.apply');
        Route::post('/send-email', [FormController::class, 'sendEmail'])->name('send.email');

        // services route
        Route::get('/services/new-home-builds', function () {
            return view('web.services.new-home-builds');
        })->name('services.new-home-builds');

        Route::get('/services/renovations-extensions', function () {
            return view('web.services.renovations-extensions');
        })->name('services.renovations-extensions');

        Route::get('/services/design-planning', function () {
            return view('web.services.design-planning');
        })->name('services.design-planning');

        Route::get('/services/project-management', function () {
            return view('web.services.project-management');
        })->name('services.project-management');

        Route::get('/search', [SearchController::class, 'searchAll'])->name('search.all');

        Route::group(['as' => 'notice.'], function () {
            Route::get('/notice/list', [NoticeController::class, 'latestList'])->name('latest.list');
            Route::get('/notice/detail/{slug}', [NoticeController::class, 'detail'])->name('detail');
        });

    });
});

Route::get('/appointment', [AppointmentController::class, 'create'])->name('appointment.create');
Route::post('/appointment/form', [AppointmentController::class, 'store'])->name('appointment.store');
// routes/web.php
Route::post('/validate-email', [AppointmentController::class, 'validateEmail'])->name('appointment.validate-email');

