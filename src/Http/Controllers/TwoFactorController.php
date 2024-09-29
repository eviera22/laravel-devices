<?php

namespace Ninja\DeviceTracker\Http\Controllers;

use Config;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ninja\DeviceTracker\Events\Google2FAFailed;
use Ninja\DeviceTracker\Events\Google2FASuccess;
use Ninja\DeviceTracker\Models\Session;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;

/**
 * @authenticated
 */
final class TwoFactorController extends Controller
{
    public function code(Request $request): RedirectResponse|JsonResponse
    {
        $user = auth(Config::get('devices.auth_guard'))->user();

        if (!$user->google2faEnabled()) {
            return response()->json(['message' => 'Two factor authentication is not enabled for current user'], 400);
        }

        return response()->json([
            'svg' => $user->google2faQrCode("svg"),
            'base64' => $user->google2faQrCode("base64"),
        ]);
    }

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidCharactersException
     * @throws SecretKeyTooShortException
     */
    public function verify(Request $request): RedirectResponse|JsonResponse
    {
        $user = auth(Config::get('devices.auth_guard'))->user();

        if (!$user->google2faEnabled()) {
            return response()->json(['message' => 'Two factor authentication is not enabled for current user'], 400);
        }

        $code = $request->input('code');
        if (!$code) {
            return response()->json(['message' => 'Authenticator code is required'], 400);
        }

        $valid = app(Google2FA::class)
            ->verifyKeyNewer(
                secret: $user->google2fa->secret(),
                key: $code,
                oldTimestamp: $user->google2fa->last_sucess_at->timestamp ?? 0
            );

        if ($valid !== false) {
            $user->google2fa->success();
            Google2FASuccess::dispatch($user);

            return response()->json(['message' => 'Two factor authentication successful']);
        } else {
            Google2FAFailed::dispatch($user);
            return response()->json(['message' => 'Two factor authentication failed'], 400);
        }
    }

    public function disable(Request $request): JsonResponse
    {
        $user = auth(Config::get('devices.auth_guard'))->user();

        if (!$user->google2faEnabled()) {
            return response()->json(['message' => 'Two factor authentication is not enabled for current user'], 400);
        }

        $user->google2fa->disable();

        return response()->json(['message' => 'Two factor authentication disabled for current user']);
    }

    public function enable(Request $request): JsonResponse
    {
        $user = auth(Config::get('devices.auth_guard'))->user();

        if ($user->google2faEnabled()) {
            return response()->json(['message' => 'Two factor authentication already for current user']);
        }

        $user->enable2fa(
            secret: app(Google2FA::class)->generateSecretKey()
        );

        return response()->json(['message' => 'Two factor authentication enabled for current user']);
    }
}