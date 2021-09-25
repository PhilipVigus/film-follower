<?php

use App\Http\Livewire\Tag;
use App\Http\Livewire\Tags;
use Laravel\Fortify\Features;
use App\Http\Livewire\Ignored;
use App\Http\Livewire\Reviewed;
use App\Http\Livewire\Shortlist;
use Laravel\Jetstream\Jetstream;
use App\Http\Livewire\ToShortlist;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers as Controllers;
use Laravel\Fortify\Http\Controllers as AuthControllers;
use Laravel\Jetstream\Http\Controllers\Livewire as AuthLivewireControllers;

Route::get('/', function () {
    return redirect(route('to-shortlist'));
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/get-trailers', Controllers\GetTrailersController::class)->name('get-trailers');

Route::middleware(['auth'])->group(function () {
    Route::get('/to-shortlist', ToShortlist::class)->name('to-shortlist');
    Route::get('/shortlist', Shortlist::class)->name('shortlist');
    Route::get('/reviewed', Reviewed::class)->name('reviewed');
    Route::get('/ignored', Ignored::class)->name('ignored');
    Route::get('/tags/{tag:slug}', Tag::class)->name('tag');
    Route::get('/tags', Tags::class)->name('tags');
});

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    $enableViews = config('fortify.views', true);

    // Authentication...
    if ($enableViews) {
        Route::get('/login', [AuthControllers\AuthenticatedSessionController::class, 'create'])
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('login')
        ;
    }

    $limiter = config('fortify.limiters.login');
    $twoFactorLimiter = config('fortify.limiters.two-factor');
    $verificationLimiter = config('fortify.limiters.verification', '6,1');

    Route::post('/login', [AuthControllers\AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:' . config('fortify.guard'),
            $limiter ? 'throttle:' . $limiter : null,
        ]))
    ;

    Route::post('/logout', [AuthControllers\AuthenticatedSessionController::class, 'destroy'])
        ->name('logout')
    ;

    // Password Reset...
    if (Features::enabled(Features::resetPasswords())) {
        if ($enableViews) {
            Route::get('/forgot-password', [AuthControllers\PasswordResetLinkController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('password.request')
            ;

            Route::get('/reset-password/{token}', [AuthControllers\NewPasswordController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('password.reset')
            ;
        }

        Route::post('/forgot-password', [AuthControllers\PasswordResetLinkController::class, 'store'])
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('password.email')
        ;

        Route::post('/reset-password', [AuthControllers\NewPasswordController::class, 'store'])
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('password.update')
        ;
    }

    // Registration...
    if (Features::enabled(Features::registration())) {
        if ($enableViews) {
            Route::get('/register', [AuthControllers\RegisteredUserController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('register')
            ;
        }

        Route::post('/register', [AuthControllers\RegisteredUserController::class, 'store'])
            ->middleware(['guest:' . config('fortify.guard')])
        ;
    }

    // Email Verification...
    if (Features::enabled(Features::emailVerification())) {
        if ($enableViews) {
            Route::get('/email/verify', [AuthControllers\EmailVerificationPromptController::class, '__invoke'])
                ->middleware(['auth:' . config('fortify.guard')])
                ->name('verification.notice')
            ;
        }

        Route::get('/email/verify/{id}/{hash}', [AuthControllers\VerifyEmailController::class, '__invoke'])
            ->middleware(['auth:' . config('fortify.guard'), 'signed', 'throttle:' . $verificationLimiter])
            ->name('verification.verify')
        ;

        Route::post('/email/verification-notification', [AuthControllers\EmailVerificationNotificationController::class, 'store'])
            ->middleware(['auth:' . config('fortify.guard'), 'throttle:' . $verificationLimiter])
            ->name('verification.send')
        ;
    }

    // Profile Information...
    if (Features::enabled(Features::updateProfileInformation())) {
        Route::middleware(['isNotGuest'])->put('/user/profile-information', [AuthControllers\ProfileInformationController::class, 'update'])
            ->middleware(['auth:' . config('fortify.guard')])
            ->name('user-profile-information.update')
        ;
    }

    // Passwords...
    if (Features::enabled(Features::updatePasswords())) {
        Route::put('/user/password', [AuthControllers\PasswordController::class, 'update'])
            ->middleware(['auth:' . config('fortify.guard')])
            ->name('user-password.update')
        ;
    }

    // Password Confirmation...
    if ($enableViews) {
        Route::get('/user/confirm-password', [AuthControllers\ConfirmablePasswordController::class, 'show'])
            ->middleware(['auth:' . config('fortify.guard')])
            ->name('password.confirm')
        ;
    }

    Route::get('/user/confirmed-password-status', [AuthControllers\ConfirmedPasswordStatusController::class, 'show'])
        ->middleware(['auth:' . config('fortify.guard')])
        ->name('password.confirmation')
    ;

    Route::post('/user/confirm-password', [AuthControllers\ConfirmablePasswordController::class, 'store'])
        ->middleware(['auth:' . config('fortify.guard')])
    ;

    // Two Factor Authentication...
    if (Features::enabled(Features::twoFactorAuthentication())) {
        if ($enableViews) {
            Route::get('/two-factor-challenge', [AuthControllers\TwoFactorAuthenticatedSessionController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('two-factor.login')
            ;
        }

        Route::post('/two-factor-challenge', [AuthControllers\TwoFactorAuthenticatedSessionController::class, 'store'])
            ->middleware(array_filter([
                'guest:' . config('fortify.guard'),
                $twoFactorLimiter ? 'throttle:' . $twoFactorLimiter : null,
            ]))
        ;

        $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
            ? ['auth:' . config('fortify.guard'), 'password.confirm']
            : ['auth:' . config('fortify.guard')];

        Route::post('/user/two-factor-authentication', [AuthControllers\TwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.enable')
        ;

        Route::delete('/user/two-factor-authentication', [AuthControllers\TwoFactorAuthenticationController::class, 'destroy'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.disable')
        ;

        Route::get('/user/two-factor-qr-code', [AuthControllers\TwoFactorQrCodeController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.qr-code')
        ;

        Route::get('/user/two-factor-recovery-codes', [AuthControllers\RecoveryCodeController::class, 'index'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.recovery-codes')
        ;

        Route::post('/user/two-factor-recovery-codes', [AuthControllers\RecoveryCodeController::class, 'store'])
            ->middleware($twoFactorMiddleware)
        ;
    }
});

Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
    if (Jetstream::hasTermsAndPrivacyPolicyFeature()) {
        Route::get('/terms-of-service', [AuthLivewireControllers\TermsOfServiceController::class, 'show'])->name('terms.show');
        Route::get('/privacy-policy', [AuthLivewireControllers\PrivacyPolicyController::class, 'show'])->name('policy.show');
    }

    Route::group(['middleware' => ['auth', 'verified']], function () {
        // User & Profile...
        Route::middleware(['isNotGuest'])->get('/user/profile', [AuthLivewireControllers\UserProfileController::class, 'show'])
            ->name('profile.show')
        ;

        // API...
        if (Jetstream::hasApiFeatures()) {
            Route::get('/user/api-tokens', [AuthLivewireControllers\ApiTokenController::class, 'index'])->name('api-tokens.index');
        }

        // Teams...
        if (Jetstream::hasTeamFeatures()) {
            Route::get('/teams/create', [AuthLivewireControllers\TeamController::class, 'create'])->name('teams.create');
            Route::get('/teams/{team}', [AuthLivewireControllers\TeamController::class, 'show'])->name('teams.show');
            Route::put('/current-team', [AuthLivewireControllers\CurrentTeamController::class, 'update'])->name('current-team.update');

            Route::get('/team-invitations/{invitation}', [AuthLivewireControllers\TeamInvitationController::class, 'accept'])
                ->middleware(['signed'])
                ->name('team-invitations.accept')
            ;
        }
    });
});
