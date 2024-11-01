<?php

namespace Ninja\DeviceTracker\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ninja\DeviceTracker\Exception\DeviceNotFoundException;
use Ninja\DeviceTracker\Exception\FingerprintNotFoundException;
use Ninja\DeviceTracker\Exception\UnknownDeviceDetectedException;
use Ninja\DeviceTracker\Facades\DeviceManager;
use Ninja\DeviceTracker\Factories\DeviceIdFactory;

final readonly class DeviceTracker
{
    public function handle(Request $request, Closure $next)
    {
        if (DeviceManager::shouldRegenerate()) {
            DeviceManager::create();
            DeviceManager::attach();

            return $next($request);
        }

        if (!DeviceManager::tracked()) {
            try {
                if (config('devices.track_guest_sessions')) {
                    DeviceManager::track();
                    DeviceManager::create();

                    Log::info(sprintf('Device not found. Created new one with id %s', device_uuid()));
                } else {
                    $deviceUuid = DeviceIdFactory::generate();
                    $request->merge(['device_id' => $deviceUuid->toString()]);

                    Log::info(sprintf('Device not found. Tracking new one with id %s', $deviceUuid->toString()));
                }
            } catch (DeviceNotFoundException | FingerprintNotFoundException | UnknownDeviceDetectedException $e) {
                Log::info($e->getMessage());
                return $next($request);
            }
        }

        return $next($request);
    }
}
