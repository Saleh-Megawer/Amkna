<?php

use App\Http\Controllers\Dashboard\Admin\AdminController;
use App\Http\Controllers\Dashboard\Admin\PortfolioController;
use App\Http\Controllers\Dashboard\Admin\ProfileController;
use App\Http\Controllers\Dashboard\Auth\ForgetController;
use App\Http\Controllers\Dashboard\Auth\LoginController;
use App\Http\Controllers\Dashboard\Auth\LogoutController;
use App\Http\Controllers\Dashboard\Auth\ResetPasswordController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\Crm\Client\ClientController;
use App\Http\Controllers\Dashboard\Crm\Client\ClientNoteController;
use App\Http\Controllers\Dashboard\Crm\Deal\DealAttachmentController;
use App\Http\Controllers\Dashboard\Crm\Deal\DealChatController;
use App\Http\Controllers\Dashboard\Crm\Deal\DealController;
use App\Http\Controllers\Dashboard\Crm\Deal\DealFollowUpController;
use App\Http\Controllers\Dashboard\FaqsController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\InterestController;
use App\Http\Controllers\Dashboard\MailBox\MailboxController;
use App\Http\Controllers\Dashboard\MailBox\MailReplyController;
use App\Http\Controllers\Dashboard\NeighborhoodController;
use App\Http\Controllers\Dashboard\NotificationsController;
use App\Http\Controllers\Dashboard\OwnerAssociation\OwnerAssociationController;
use App\Http\Controllers\Dashboard\OwnerAssociation\OwnerAssociationPollController;
use App\Http\Controllers\Dashboard\OwnerAssociation\OwnerAssociationRequestController;
use App\Http\Controllers\Dashboard\OwnerAssociation\OwnerAssociationUnitController;
use App\Http\Controllers\Dashboard\Pages\About\AboutController;
use App\Http\Controllers\Dashboard\Pages\HomePageController;
use App\Http\Controllers\Dashboard\PrivacyController;
use App\Http\Controllers\Dashboard\Property\FinishingTypeController;
use App\Http\Controllers\Dashboard\Property\PropertyAattachmentsController;
use App\Http\Controllers\Dashboard\Property\PropertyAmenityController;
use App\Http\Controllers\Dashboard\Property\PropertyController;
use App\Http\Controllers\Dashboard\Property\PropertyFacadeController;
use App\Http\Controllers\Dashboard\Property\PropertyFeatureController;
use App\Http\Controllers\Dashboard\Property\PropertyTypeController;
use App\Http\Controllers\Dashboard\Property\PropertyUnitsController;
use App\Http\Controllers\Dashboard\Rental\RentalContractController;
use App\Http\Controllers\Dashboard\Rental\RentalExpenseController;
use App\Http\Controllers\Dashboard\Rental\RentalPaymentController;
use App\Http\Controllers\Dashboard\Rental\RentalStatisticsController;
use App\Http\Controllers\Dashboard\RoleAndPermission\PermissionController;
use App\Http\Controllers\Dashboard\RoleAndPermission\RoleController;
use App\Http\Controllers\Dashboard\Settings\GeneralController;
use Illuminate\Support\Facades\Route;

// Guest
Route::middleware('guest:admin')->group(function () {

    Route::controller(LoginController::class)->group(function () {
        Route::get(adminPrefix(), 'index');
        Route::post(adminPrefix(), 'login')->name("admin.login");
    });

    Route::controller(ForgetController::class)->group(function () {
        Route::get('forgot-passowrd', 'showLinkRequestForm')->name('password.request');
        Route::post('forgot-password', 'sendResetLinkEmail')->name('password.email');
    });

    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('reset-password/{token}', 'showResetForm')->name('password.reset');
        Route::post('reset-password', 'reset')->name('password.update');
    });

});

Route::prefix(adminPrefix())->group(function () {

    /**
     * Admin Middleware
     */
    Route::middleware(['AdminAuth'])->group(function () {

        /*
        | Settings
        */
        Route::prefix('settings')->name('settings.')->group(function () {

            Route::prefix('general')->name('general.')->controller(GeneralController::class)->group(function () {
                Route::get('', 'index');
                Route::post('', 'store')->name('store');
            });

        });

        /*
        | Pages
        */
        Route::prefix('pages')->name('pages.')->group(function () {

            Route::prefix('about')->name('about.')->controller(AboutController::class)->group(function () {
                Route::get('', 'index');
                Route::post('update', 'update')->name('update');
            });

            Route::prefix('home')->name('home.')->controller(HomePageController::class)->group(function () {
                Route::get('', 'index');
                Route::post('update', 'update')->name('update');

                //
                Route::get('', 'index');
                Route::post('headerSliderAttech', 'headerSliderAttech')->name('headerSliderAttech');
                Route::post('headerSliderDeleteSingle', 'headerSliderDeleteSingle')->name('headerSliderDeleteSingle');
                Route::post('headerSliderRankUp', 'headerSliderRankUp')->name('headerSliderRankUp');
                Route::post('headerStoreTitleDesc', 'headerStoreTitleDesc')->name('headerStoreTitleDesc');
            });

        });

        // Route::prefix('home-page')->group(function () {
        //     Route::get('', 'homePage');
        //     Route::post('headerSliderAttech', 'headerSliderAttech')->name('headerSliderAttech');
        //     Route::post('headerSliderDeleteSingle', 'headerSliderDeleteSingle')->name('headerSliderDeleteSingle');
        //     Route::post('headerSliderRankUp', 'headerSliderRankUp')->name('headerSliderRankUp');

        //     //

        //     Route::post('headerStoreTitleDesc', 'headerStoreTitleDesc')->name('headerStoreTitleDesc');

        //     //

        //     Route::post('solutionsColors', 'solutionsColors')->name('solutionsColors');
        //     //

        //     Route::post('partnersColors', 'partnersColors')->name('partnersColors');
        //     //

        //     Route::post('industriesColors', 'industriesColors')->name('industriesColors');
        //     Route::post('logoColors', 'logoColors')->name('logoColors');
        //     Route::post('mapsColors', 'mapsColors')->name('mapsColors');
        // });
        //  });

        // ====================================
        // Rental Management Routes
        // ====================================
        Route::prefix('rental')->name('rental.')->group(function () {

            // Rental Contracts
            Route::prefix('contracts')->name('contracts.')->group(function () {
                Route::controller(RentalContractController::class)->group(function () {
                    Route::get('', 'index')->name('index');                         // Done
                    Route::get('create', 'create')->name('create');                 // Done
                    Route::post('store', 'store')->name('store');                   // Done
                    Route::get('show/{rentalContract:uuid}', 'show')->name('show'); // Done
                    Route::get('edit/{rentalContract:uuid}', 'edit')->name('edit');
                    Route::patch('update/{contract:uuid}', 'update')->name('update');
                    Route::patch('change-status/{contract:uuid}', 'changeStatus')->name('change-status');
                    Route::delete('destroy/{rentalContract:uuid}', 'destroy')->name('destroy');
                    //
                    Route::get('search-properties', 'searchProperties')->name('search-properties');
                });
            });

            // Rental Payments
            Route::prefix('payments')->name('payments.')->group(function () {
                Route::controller(RentalPaymentController::class)->group(function () {
                    // Route::get('{contractId}', 'index')->name('index');
                    Route::get('modal/{scheduleId}', 'getPaymentModal')->name('modal');
                    Route::post('store/{scheduleId}', 'store')->name('store');
                    // Route::post('cancel/{scheduleId}', 'cancel')->name('cancel');
                });
            });

            // Rental Expenses
            Route::prefix('expenses')->name('expenses.')->group(function () {
                Route::controller(RentalExpenseController::class)->group(function () {
                    Route::get('{contractId}', 'index')->name('index');
                    Route::get('create/{contractId}', 'create')->name('create');
                    Route::post('store/{contractId}', 'store')->name('store');
                    Route::delete('destroy/{expenseId}', 'destroy')->name('destroy');
                });
            });

            // Rental Statistics
            Route::prefix('statistics')->name('statistics.')->group(function () {
                Route::controller(RentalStatisticsController::class)->group(function () {
                    Route::get('', 'index')->name('index');
                    Route::get('contract-report/{contractId}', 'contractReport')->name('contract-report');
                });
            });

        }); // rental

        // ====================================
        // Financial Management Routes
        // ====================================
        Route::prefix('financial')->name('financial.')->group(function () {

            // Financial Reports
            /**
             * HASH IN 2026-3-2
             */
            // Route::prefix('reports')->name('reports.')->group(function () {
            //     Route::controller(FinancialReportController::class)->group(function () {
            //         Route::get('', 'index')->name('index');
            //         Route::get('contract/{contractId}', 'contractReport')->name('contract');
            //         Route::post('export', 'export')->name('export');
            //     });
            // });

        }); // financial

        Route::controller(NotificationsController::class)
            ->prefix('notifications')
            ->name('notifications.')->group(function () {
            //
            Route::get('count', 'notificationsCount')->name('count');
        }); // End notifications

        /*
        | owner associations
        */
        Route::prefix('owner-associations')->name('owner-associations.')->group(function () {

            Route::name('requests.')->controller(OwnerAssociationRequestController::class)->group(function () {

                Route::get('requests', 'allRequests')->name('all-requests');

                Route::prefix('{ownerAssociation:uuid}/requests/')->group(function () {

                    Route::get('', 'index')->name('index');
                    //
                    Route::get('{requestId}/show', 'show')->name('show');
                    Route::post('{requestId}', 'edit')->name('edit');
                    Route::patch('{requestId}', 'update')->name('update');
                    Route::delete('{requestId}', 'destroy')->name('destroy');
                    //
                    Route::patch('{requestId}/update-status', 'updateStatus')->name('update-status');
                    Route::patch('{requestId}/verify-payment', 'verifyPayment')->name('verify-payment');

                    // Replies Routes
                    Route::post('{requestId}/replies', 'storeReply')->name('replies.store');
                    Route::delete('{requestId}/replies/{replyId}', 'destroyReply')->name('replies.destroy');

                    // Attachments Routes
                    Route::get('{requestId}/attachments/{attachmentId}/download', 'downloadAttachment')->name('attachments.download');
                    Route::delete('{requestId}/attachments/{attachmentId}', 'destroyAttachment')->name('attachments.destroy');
                    //
                    Route::post('{requestId}/assign', 'assign')->name('assign');

                }); // end all requests with uuid

            }); // requests

            Route::controller(OwnerAssociationController::class)->group(function () {
                // All
                Route::get('', 'index')->name('index');
                // Store
                Route::post('store', 'store')->name('store');
                // update
                Route::patch('{ownerAssociation:uuid}', 'update')->name('update');
                // Show
                Route::get('{ownerAssociation:uuid}', 'show')->name('show');
                //
                Route::delete('{ownerAssociation:uuid}/destroy', 'destroy')->name('destroy');

            });

            Route::name('units.')->controller(OwnerAssociationUnitController::class)->group(function () {
                // Create
                Route::get('{ownerAssociation}/units/create', 'create')->name('create');
                // Store
                Route::post('{ownerAssociation:uuid}/units/store', 'store')->name('store');
                // Edit
                //Route::get('units/{unit}/edit', 'edit')->name('edit');
                // Update
                //  Route::patch('units/{unit}/update', 'update')->name('update');
                Route::patch('{ownerAssociation:uuid}/units/{unit}/update', 'update')->name('update');

                // Destroy
                Route::delete('{ownerAssociation:uuid}/units/{unit}/destroy', 'destroy')->name('destroy');
                // Route::post('{ownerAssociation:uuid}/units/{unit}', 'edit')->name('edit'); // get row

            });

            Route::name('polls.')->controller(OwnerAssociationPollController::class)->group(function () {
                //
                Route::post('{ownerAssociation:uuid}/polls/store', 'store')->name('store');
                //
                Route::post('{ownerAssociation:uuid}/polls/{poll}', 'edit')->name('edit');
                //
                Route::patch('{ownerAssociation:uuid}/polls/{poll}/update', 'update')->name('update');
                //
                Route::delete('{ownerAssociation:uuid}/polls/{poll}/destroy', 'destroy')->name('destroy');
            }); // polls

        });

        /**
         * CRM
         * - clients
         * - deals
         */
        Route::prefix('crm')->name('crm.')->group(function () {

            Route::controller(InterestController::class)->prefix('interests')->name('interests.')->group(function () {
                // All
                Route::get('', 'index')->name('index');
                Route::get('{interest:uuid}/details', 'details')->name('details');
                Route::post('update-status', 'updateStatus')->name('update-status');
                //
                Route::post('store-deal', 'storeDeal')->name('store-deal');
                //
                Route::post('assign/{interest:uuid}', 'assign')->name('assign');
                //
                Route::post('assign/{interest:uuid}', 'assign')->name('assign');
                //
                // Route::get('notifications/count', 'getUnreadCount')->name('notifications.count');

            }); // End

            Route::prefix('clients')->name('clients.')->group(function () {

                Route::controller(ClientController::class)->group(function () {
                    // index
                    Route::get('', 'index')->name('index');
                    Route::get('show/{client:uuid}', 'show')->name('show');
                    Route::get('create', 'create')->name('create');

                    Route::get('analytics', 'analytics')->name('analytics');

                    Route::post('store', 'store')->name("store");

                    // edit
                    Route::get('edit/{uuid}', 'edit')->name('edit');
                    Route::patch('update/{client:uuid}', 'update')->name("update");
                    Route::patch('change-status', 'changeStatus')->name("change-status");

                    //
                    Route::get('search-by-name-or-phone', 'searchByNameOrPhone')->name('search-by-name-or-phone');
                    //
                    // Route::post('assign/{client:uuid}', 'assign')->name('assign');
                    //
                    Route::delete('destroy/{client:uuid}', 'destroy')->name("destroy");
                });

                Route::controller(ClientNoteController::class)->name('notes.')->group(function () {
                    Route::post('store/{client:uuid}', 'store')->name("store");
                    Route::post('update/{client}/{clientNote?}', 'update')->name("update");
                    //
                    Route::post('get-note/{client?}/{clientNote?}', 'getNote')->name("getNote");
                    Route::delete('destroy/{client}/{clientNote}', 'destroy')->name("destroy");
                }); // notes

            }); //

            Route::controller(DealController::class)->prefix('deals')->name('deals.')->group(function () {

                // index
                Route::get('', 'index')->name('index');
                Route::get('analytics', 'analytics')->name('analytics');

                // store
                Route::post('store', 'store')->name('store');
                // edit
                Route::get('edit/{deal:uuid}', 'edit')->name('edit');
                Route::patch('update/{deal:uuid}', 'update')->name("update");
                //
                Route::post('match-properties', 'getMatchProperties')->name('match-properties');
                //
                Route::post('add-property', 'addProperty')->name('add-property');
                Route::post('remove-property', 'removeProperty')->name('remove-property');
                Route::post('show-linked-properties', 'showLinkedProperties')->name('show-linked-properties');
                //
                Route::post('update-status/{deal:uuid}', 'updateStatus')->name('update-status');
                //
                Route::post('assign/{deal:uuid}', 'assign')->name('assign');

            }); // deals

            Route::controller(DealChatController::class)->prefix('deals/{deal:uuid}')->name('deals.chats.')->group(function () {
                Route::post('chats/store', 'store')->name('store');
                Route::get('chats/{chat}/show', 'show')->name('show');
                Route::patch('chats/{chat}/update', 'update')->name('update');
                Route::delete('chats/{chat}/delete', 'destroy')->name('delete');
            });

            Route::controller(DealAttachmentController::class)->prefix('deals')->name('deals.attachments.')->group(function () {
                Route::post('{deal:uuid}/attachments/store', 'store')->name('store');
                Route::get('attachments/{attachment}/show', 'show')->name('show');
                Route::delete('{deal:uuid}/attachments/{attachment}/delete', 'destroy')->name('delete');
                Route::get('attachments/{attachment}/download', 'download')->name('download');
            });

            Route::controller(DealFollowUpController::class)->prefix('deals')->name('deals.follow-ups.')->group(function () {
                Route::get('follow-ups', 'index')->name('index');
                Route::post('{deal:uuid}/follow-ups/store', 'store')->name('store');
                Route::get('{deal:uuid}/follow-ups/{followUp}/show', 'show')->name('show');
                Route::patch('{deal:uuid}/follow-ups/{followUp}/update', 'update')->name('update');
                Route::delete('{deal:uuid}/follow-ups/{followUp}/delete', 'destroy')->name('delete');
                Route::patch('{deal:uuid}follow-ups/{followUp}/mark-completed', 'markCompleted')->name('mark-completed');
            });

        }); // End CRM

        /**
         * Properties
         * - types
         * - facades
         */
        Route::prefix('properties')->name('properties.')->group(function () {

            Route::controller(PropertyController::class)->group(function () {
                // All
                Route::get('', 'index')->name('index');
                // Create
                //  Route::get('create', 'create')->name("create");
                Route::post('store', 'store')->name("store");

                Route::patch('upload-main-image', 'uploadMainImage')->name("upload-main-image");

                // Update
                Route::get('edit/{property:uuid}', 'edit')->name("edit");
                Route::patch('update/{property:uuid}', 'update')->name("update");

                // Destroy
                Route::delete('destroy', 'destroy')->name('destroy');
                //
            });

            Route::controller(PropertyUnitsController::class)->prefix('{property:uuid}/units')->name('units.')->group(function () {
                Route::get('', 'index')->name('index');
                Route::post('store', 'store')->name('store');
                Route::get('{unit}', 'show')->name('show');
                Route::patch('{unit}', 'update')->name('update');
                Route::delete('{unit}', 'destroy')->name('destroy');
            });

            Route::controller(PropertyAattachmentsController::class)->name('attachments.')->group(function () {
                Route::post('store-attachment', 'store')->name('store');
                Route::delete('destroy-attachment', 'destroy')->name('destroy');
                Route::post('get', 'get')->name('get');
            });

            Route::controller(FinishingTypeController::class)->prefix('finishing-types')->name('finishing.')->group(function () {
                // All
                Route::get('', 'index')->name('index');
                // Create
                Route::post('store', 'store')->name("store");
                // Update
                Route::patch('update', 'update')->name("update");
                // Destroy
                Route::delete('destroy', 'destroy')->name('destroy');
            });

            Route::controller(PropertyAmenityController::class)->prefix('amenities')->name('amenities.')->group(function () {
                // All
                Route::get('', 'index')->name('index');
                // Create
                Route::post('store', 'store')->name("store");
                // Update
                Route::patch('update', 'update')->name("update");
                // Destroy
                Route::delete('destroy', 'destroy')->name('destroy');
            });

            Route::controller(PropertyFeatureController::class)->prefix('features')->name('features.')->group(function () {
                // All
                Route::get('', 'index')->name('index');
                // Create
                Route::post('store', 'store')->name("store");
                // Update
                Route::patch('update', 'update')->name("update");
                // Destroy
                Route::delete('destroy', 'destroy')->name('destroy');
            });

            Route::prefix('types')->name('types.')->controller(PropertyTypeController::class)->group(function () {
                // All
                Route::get('', 'index')->name('index');
                // Create
                Route::post('store', 'store')->name("store");
                // Update
                Route::patch('update', 'update')->name("update");
                // Destroy
                Route::delete('destroy', 'destroy')->name('destroy');
            }); // Property Types

            Route::prefix('facades')->name('facades.')->controller(PropertyFacadeController::class)->group(function () {
                // All
                Route::get('', 'index')->name('index');
                // Create
                Route::post('store', 'store')->name("store");
                // Update
                Route::patch('update', 'update')->name("update");
                // Destroy
                Route::delete('destroy', 'destroy')->name('destroy');
            }); // Property Facades

        });

        /*
        | Neighborhoods
        */
        Route::controller(NeighborhoodController::class)->group(function () {
            Route::prefix('neighborhoods')->group(function () {
                // All
                Route::get('', 'index')->name('neighborhoods.index');
                // Create
                Route::post('store', 'store')->name("neighborhoods-store");
                //
                Route::patch('update', 'update')->name("neighborhoods-update");
                // Destroy
                Route::delete('destroy', 'destroy')->name('neighborhoods-destroy');
                //
                Route::post('get', 'getNeighborhoodsByCity')->name("neighborhoods.byCity");
            });
        });

        /*
        | Cities
        */
        Route::controller(CityController::class)->group(function () {
            Route::prefix('cities')->group(function () {
                // All
                Route::get('', 'index')->name('cities.index');
                // Create
                Route::post('store', 'store')->name("cities-store");
                // Update
                Route::patch('update', 'update')->name("cities-update");
                // Destroy
                Route::delete('destroy', 'destroy')->name('cities-destroy');
            });
        });

        /*
        |
        | privacy
        |
         */
        Route::controller(PrivacyController::class)->group(function () {
            Route::prefix('privacy')->group(function () {
                // All
                Route::get('', 'index');
                Route::post('store-update', 'storeUpdate')->name("privacy-store-update");
            });
        });

        /*
        |
        | Faqs
        |
         */
        Route::controller(FaqsController::class)->group(function () {
            Route::prefix('faqs')->group(function () {
                // All
                Route::get('', 'index');

                // Create
                Route::get('create', 'create');
                Route::post('store', 'store')->name("faqs-store");

                // // Update
                Route::get('edit/{id}', 'edit');
                Route::patch('update', 'update')->name("faqs-update");

                // Actions
                Route::delete('destroy', 'destroy')->name('faqs-destroy');
            });
        });

        /*
        |
        | Roles & Permissions
        |
        */
        Route::controller(PermissionController::class)->group(function () {
            Route::prefix('permissions')->group(function () {
                Route::post('update', 'update')->name("update-permissions");
                Route::get('{id}', 'index');
            });
        });

        Route::controller(RoleController::class)->group(function () {
            Route::prefix('roles')->group(function () {
                Route::get('', 'index');
                Route::post('store', 'store')->name("store-role");
                Route::post('update', 'update')->name("update-role");
                Route::delete('destroy', 'destroy')->name('role-destroy');
            });
        });

        // Logout
        Route::post('logout', [LogoutController::class, 'logout'])->name("logout");

        // Home
        Route::controller(HomeController::class)->group(function () {
            Route::get('home', 'index')->name('dashboard');
        });

        /*
        |
        | Mailbox
        |
        */
        Route::prefix('mail')->group(function () {

            Route::controller(MailboxController::class)->group(function () {
                Route::get('', 'index');
                Route::get('read/{id}', 'show');
                Route::post('actions', 'multiActions')->name('mail-multi-actions');
                Route::post('load-latest', 'loadLatest');
            });

            // Reply
            Route::controller(MailReplyController::class)->group(function () {
                Route::post('reply', 'store')->name('reply-mail');
                Route::get('show/reply/{id}', 'show');
            });
        });

        /*
        |
        | Admins & Profile
        |
         */
        Route::prefix('profile')->group(function () { // Admin Profile

            // If Just URL ( profile ) => go to edit
            Route::get('', function () {
                return redirect(adminUrl('profile/edit'));
            }); // Show Profile

            // Profile
            Route::controller(ProfileController::class)->group(function () {

                Route::get('show/{id?}', 'show'); // Show Profile
                Route::get('edit', 'edit');

                // Update
                Route::patch('update-personal-data', 'updatePersonalData')->name('update-personal-data');
                Route::patch('change-password', 'changeProfilePassword')->name('change-profile-password');

                /**
                 * Not Complate
                 */
                Route::post('experience', 'experience')->name('experience');
                /**
                 * Not Complate
                 */

                Route::patch('update-avatar', 'updateProfileAvatar')->name('update-profile-avatar');
                Route::patch('update-cover', 'updateProfileCover')->name('update-profile-cover');

                /**
                 * Not Complate
                 */
                // Delete Experience
                Route::delete('delete-experience', 'destroyExperience');

                Route::delete('delete-admin', 'deleteAdmin')->name('deleteAdmin');
                /**
                 * Not Complate
                 */

                // Verified Email
                Route::post('verify-email', 'sendMailForVerifyEmail')->name('sendMailForVerifyEmail');
                Route::get('verified-email/{token}', 'verifiedEmail');

                                                                                                     // Forgot Password
                Route::post('forgot-password', 'forgotPassword');                                    // Send Mail
                Route::get('reset-password/{token}', 'resetPasswordView');                           // View To Reset
                Route::patch('reset-password', 'resetPasswordUpdate')->name('reset-admin-password'); // Update

                // Update Roles
                Route::patch('change-roles', 'changeRoles')->name('change-roles');
            });

            // Portfolio
            Route::controller(PortfolioController::class)->group(function () {
                Route::patch('portfolio-update', 'update')->name('portfolio-update');
            });
        });

        Route::prefix('admins')->group(function () {

            Route::controller(AdminController::class)->group(function () {
                Route::get('', 'index');
                Route::post('search', 'search')->name("admin-search");
                // Create New Admin
                Route::get('create', 'create')->name("admin-create");
                Route::post('store', 'store')->name("create-admin");
                // marketer
                Route::post('marketer/reject', 'reject')->name("marketer.reject");
                Route::post('marketer/approve', 'approve')->name("marketer.approve");
                // Status
                Route::patch('closed-account', 'closedAccount')->name("closed-admin-account");
                Route::patch('active-account', 'activeAccount')->name("active-admin-account");

                // Global Actions From Admins By Owner
                Route::middleware('role:' . owner())->group(function () {
                    Route::delete('destroy', 'destroy')->name("delete-admin");
                });
            });

            Route::middleware('role:' . owner())->group(function () {
                // Edit
                Route::get('edit/{id}', [ProfileController::class, 'edit']);
                // Chnage Other Admin Password By Owner
                Route::patch('change-admin-password', [AdminController::class, 'changeAdminPassword'])->name("change-admin-password");
            });
        });

    }); // AdminAuth

}); // end adminPrefix()
