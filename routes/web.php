<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Subscriptions\PlanController;
use App\Http\Livewire\Subscription\PlanSelectionComponent;
use App\Http\Livewire\Subscription\ManageSubscriptionComponent;
use App\Http\Livewire\Subscription\SubscriptionStatusComponent;
use App\Http\Livewire\Authentication\Login\SimpleLoginComponent;
use App\Http\Livewire\Subscription\SubscriptionCheckoutComponent;
use App\Http\Livewire\Authentication\Register\SimpleRegisterComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return redirect()->route('app.home');
})->name('home');


Route::group(['prefix' => 'dashboard', 'as' => 'app.', 'middleware' => ['web','auth', 'subscribe']], function () {

    Route::get('home', function () {
        return view('pages.dashboard');
    })->name('home');

    // Route::get('user', function () {
    //     return view('pages.user');
    // })->name('user');

     Route::group(
        ['prefix' => 'settings', 'as' => 'setting.'],
        function () {


             Route::get(
                'my-profile',
                function () {
                        return view('pages.profile');
                    }
            )->name('my-profile');
            
            Route::get(
                'change-password',
                function () {
                        return view('pages.change-password');
                    }
            )->name('change-password');

        }
    );

    Route::get('user', function () {
        return view('pages.user');
    })->name('user');

});


Route::group(['prefix' => 'authentication', 'as' => 'auth.', 'middleware' => 'web'], function () {

    Route::post('logout', function () {
        Illuminate\Support\Facades\Auth::logout();
        return redirect()->route('login');
    })->name('logout');
});

Route::group(['prefix' => 'authentication', 'middleware' => 'guest'], function () {

    Route::get('login', App\Http\Livewire\Authentication\Login\SimpleLoginComponent::class)->name('login');
    Route::get('register',  App\Http\Livewire\Authentication\Register\SimpleRegisterComponent::class)->name('register');
});

// Route::middleware(['auth'])->group(function () {
//     Route::get('/subscription/plans', PlanSelectionComponent::class)->name('subscription.plans');
//     // Route::get('/subscription/checkout/{planId}', SubscriptionCheckoutComponent::class)->name('subscription.checkout');

//     Route::view('subscription/checkout/{planId}', 'pages.checkout')->name('subscription.checkout');



//     Route::get('/subscription/status', SubscriptionStatusComponent::class)->name('subscription.status');
//     Route::get('/subscription/manage', ManageSubscriptionComponent::class)->name('subscription.manage');
// });

Route::middleware("auth")->group(function () {
    Route::get('plans', [PlanController::class, 'index'])->name("plans.index");
    Route::get('plans/{slug}', [PlanController::class, 'show'])->name("plans.show");
    Route::post('subscription', [PlanController::class, 'subscription'])->name("subscription.create");
});
