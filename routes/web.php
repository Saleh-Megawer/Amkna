<?php

use App\Http\Controllers\Client\Auth\LoginController;
use App\Http\Controllers\Client\Auth\LogoutController;
use App\Http\Controllers\Client\Auth\RegisterController;
use App\Http\Controllers\Client\Auth\ResetPasswordController;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\DealController;
use App\Http\Controllers\Client\EmailVerificationController;
use App\Http\Controllers\Client\InterestController;
use App\Http\Controllers\Client\OwnerAssociation\OwnerAssociationController;
use App\Http\Controllers\Client\OwnerAssociation\OwnerAssociationPollController;
use App\Http\Controllers\Client\OwnerAssociation\OwnerAssociationRequestController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Main\HomeController;
use App\Http\Controllers\Main\PropertyController;
use App\Http\Controllers\Main\PropertyFilterController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Route::group(
//     ['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
//     function () {
//     }
// );


Route::name('main.')->group(function () {

    /* Home */
    Route::get('', [HomeController::class, 'index']);
    Route::get('faqs', [HomeController::class, 'faqs'])->name('faqs');
    Route::get('about-us', [HomeController::class, 'about'])->name('about-us');
    Route::get('privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::post('register-marketer', [HomeController::class, 'registerMarketer'])->name('register-marketer');

    /*
            |
            | contact
            |
            */
    Route::controller(ContactController::class)->group(function () {
        Route::prefix('contact')->group(function () {
            Route::get('', 'index')->name('contact-us');
            Route::post('store', 'store')->name('contact.store');
        });
    });

    /*
            | Properties | Filter
            */
    Route::name('properties.')->group(function () {

        Route::controller(PropertyController::class)->group(function () {
            Route::get('properties', 'index')->name('index'); // All
            Route::get('property/{slug}', 'show')->name('show');
            // Store interest
            Route::post('properties/{property:uuid}/interests', 'storeInterest')->name('interests.store');
        }); // End properties

        // Filter
        Route::controller(PropertyFilterController::class)->prefix('filters')->name('filters.')->group(function () {
            Route::get('locations', 'searchLocations')->name('locations');    // Autocomplete
            Route::get('properties', 'filterProperties')->name('properties'); // Main filter
        });

    });

    /**
     *
     *
     *
     *
     *
     */
    Route::middleware(['guest:client'])->group(function () { // If Guest

        Route::name('clients.')->group(function () {

            /*
                    |
                    | Reset Password
                    |
                    */
            Route::controller(ResetPasswordController::class)->prefix('client')->group(function () {
                // صفحة طلب إعادة تعيين كلمة المرور (إدخال البريد)
                Route::get('password/reset', 'showLinkRequestForm')->name('password.request');
                // إرسال رابط إعادة التعيين للبريد
                Route::post('password/email', 'sendResetLinkEmail')->name('password.email');
                // صفحة إعادة تعيين كلمة المرور (مع token)
                Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
                // حفظ كلمة المرور الجديدة
                Route::post('password/reset', 'reset')->name('password.update');
            });

            Route::controller(LoginController::class)->name('login.')->prefix('login')->group(function () {
                Route::get('', 'index')->name('index');
                Route::post('attempt', 'login')->name('attempt');
            });

            Route::controller(RegisterController::class)->name('register.')->prefix('register')->group(function () {
                Route::get('', 'index')->name('index');
                Route::post('', 'store')->name('store');
            });

        }); // clients

    }); // guest

    Route::middleware(['clientAuth'])->group(function () {

        /* Prefix For Open Clients Routes */
        Route::prefix(clientPrefix())->name('clients.')->group(function () {

            Route::get('', [DashboardController::class, 'index']);

            Route::controller(EmailVerificationController::class)->group(function () {
                Route::prefix('email')->name('email.')->group(function () {
                    // إرسال رابط التحقق
                    Route::post('verify-send', 'send')->name('verify.send');

                    // التحقق من الرابط
                    Route::get('verify/{client}/{hash}', 'verify')
                        ->middleware('signed')
                        ->name('verify');
                });
            });

            Route::controller(InterestController::class)->group(function () {
                Route::prefix('interests')->name('interests.')->group(function () {
                    Route::get('', 'index')->name('index');
                });
            });

            Route::controller(DealController::class)->group(function () {
                Route::prefix('deals')->name('deals.')->group(function () {
                    Route::get('', 'index')->name('index');
                });
            });

            ///
            Route::controller(ProfileController::class)->group(function () {
                Route::prefix('profile')->name('profile.')->group(function () {
                    Route::get('', 'index')->name('index');
                    Route::post('update', 'update')->name('update');
                    Route::post('update-password', 'updatePassword')->name('update_password');
                });
            });

            /*
                    | Owner Association
                    */
            Route::prefix('owner-associations')->name('owner-associations.')->group(function () {

                // قائمة الاتحادات
                Route::controller(OwnerAssociationController::class)->group(function () {
                    // عرض كل الاتحادات
                    Route::get('', 'index')->name('index');
                    // تفاصيل اتحاد
                    Route::get('{uuid}', 'show')->name('show');
                    // طلبات اتحاد معين
                    Route::get('{uuid}/requests', 'requests')->name('show.requests');
                });

                // Requests
                Route::controller(OwnerAssociationRequestController::class)->prefix('requests')->name('requests.')->group(function () {
                    // عرض كل الطلبات
                    Route::get('', 'index')->name('index');

                    // إنشاء طلب جديد
                    Route::get('{ownerAssociationUuid}/create', 'create')->name('create');
                    Route::post('{ownerAssociationUuid}/store', 'store')->name('store');

                    // عرض طلب
                    Route::get('{uuid}', 'show')->name('show');

                    // إضافة رد
                    Route::post('{uuid}/reply', 'addReply')->name('reply');

                    // إلغاء الطلب
                    Route::patch('{uuid}/cancel', 'cancel')->name('cancel');

                });

            });

            Route::controller(OwnerAssociationPollController::class)->prefix('owner-association-polls')->name('owner-association.polls.')->group(function () {
                // عرض كل التصويتات
                Route::get('', 'index')->name('index');

                // عرض تصويت معين
                Route::get('{uuid}', 'show')->name('show');

                // إرسال الصوت
                Route::post('{uuid}/vote', 'vote')->name('vote');
            });

            // Logout
            Route::post('logout', [LogoutController::class, 'logout'])->name("logout");
        });

    });

}); // Name ( main. )
