<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\Officer;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class SessionTimeout
{
    private const INACTIVITY_TIMEOUT_MINUTES = 30;

    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $sessionChannel = $this->sessionChannelForRequest($request);

        if ($sessionChannel) {
            [$loginKey, $lastActivityKey, $logoutChannel] = $sessionChannel;

            if (! $request->session()->get($loginKey)) {
                return $next($request);
            }

            $lastActivity = $request->session()->get($lastActivityKey);
            $now = Carbon::now();

            if (! $lastActivity) {
                $request->session()->put($lastActivityKey, $now);
            } else {
                $lastActivity = Carbon::parse($lastActivity);
                if ($now->greaterThanOrEqualTo($lastActivity->copy()->addMinutes(self::INACTIVITY_TIMEOUT_MINUTES))) {
                    $this->performAutoLogout($request, $logoutChannel);

                    $message = 'Due to inactivity, your account was logged out. Please log in again.';
                    $request->session()->invalidate();
                    $request->session()->flash('warning', $message);

                    if ($request->expectsJson()) {
                        return response()->json([
                            'message' => $message,
                            'redirect' => route('welcome'),
                        ], 401);
                    }

                    return redirect()->route('welcome');
                }
            }

            $isAwayUpdate = $request->routeIs('update.activity') && $request->boolean('away');
            if (! $isAwayUpdate) {
                $request->session()->put($lastActivityKey, $now);
            }
        }

        return $next($request);
    }

    /**
     * Resolve the channel whose session activity should be checked for this request.
     *
     * @return array{string, string, string}|null
     */
    private function sessionChannelForRequest(Request $request): ?array
    {
        $channels = [
            'OD' => ['officer_logged_in', 'officer_last_activity', 'OD'],
            'Email' => ['email_logged_in', 'email_last_activity', 'Email'],
            'Facebook' => ['facebook_logged_in', 'facebook_last_activity', 'Facebook'],
            'admin' => ['admin_logged_in', 'admin_last_activity', 'admin'],
        ];

        if ($request->routeIs('update.activity', 'auto.logout')) {
            $requestedChannel = $request->input('channel');

            return $channels[$requestedChannel] ?? null;
        }

        $requestPath = $request->path();
        $refererPath = parse_url((string) $request->header('referer'), PHP_URL_PATH) ?: '';
        foreach ([$requestPath, $refererPath] as $path) {
            if (str_starts_with($path, 'admin')) {
                return $channels['admin'];
            }

            if (str_starts_with($path, 'officer-of-the-day')) {
                return $channels['OD'];
            }

            if (str_starts_with($path, 'email-handler')) {
                return $channels['Email'];
            }

            if (str_starts_with($path, 'facebook-handler')) {
                return $channels['Facebook'];
            }
        }

        $mostRecentChannel = null;
        $mostRecentActivity = null;

        foreach ($channels as $channel) {
            [$loginKey, $lastActivityKey] = $channel;
            if (! $request->session()->get($loginKey)) {
                continue;
            }

            $lastActivity = $request->session()->get($lastActivityKey);
            $activityAt = $lastActivity ? Carbon::parse($lastActivity) : Carbon::now();

            if (! $mostRecentActivity || $activityAt->greaterThan($mostRecentActivity)) {
                $mostRecentActivity = $activityAt;
                $mostRecentChannel = $channel;
            }
        }

        return $mostRecentChannel;
    }

    /**
     * Perform auto logout by setting user as inactive in database
     */
    private function performAutoLogout(Request $request, string $channel): void
    {
        switch ($channel) {
            case 'OD':
                $officerName = $request->session()->get('officer_name');
                if ($officerName) {
                    Officer::where('name', $officerName)->update([
                        'active' => false,
                        'last_activity' => Carbon::now(),
                    ]);
                }
                break;
            case 'Facebook':
                // Facebook users don't have database records, just clear session
                break;
            case 'Email':
                $emailUserName = $request->session()->get('email_user_name');
                if ($emailUserName) {
                    Officer::where('name', $emailUserName)->update([
                        'active' => false,
                        'last_activity' => Carbon::now(),
                    ]);
                }
                break;
            case 'admin':
                $adminUsername = $request->session()->get('admin_username');
                if ($adminUsername) {
                    Admin::where('username', $adminUsername)->update([
                        'active' => false,
                        'last_activity' => Carbon::now(),
                    ]);
                }
                break;
        }
    }
}
