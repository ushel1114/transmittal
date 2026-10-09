<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

it('keeps a signed-in user logged in after more than 30 minutes of inactivity', function () {
    Carbon::setTestNow('2026-10-07 12:00:00');
    Route::middleware('web')->get('/test-inactivity', function () {
        return response()->noContent();
    });

    try {
        $response = $this->withSession([
            'facebook_logged_in' => true,
            'facebook_last_activity' => Carbon::now()->subMinutes(31)->toDateTimeString(),
        ])->get('/test-inactivity');

        $response->assertNoContent();
        $response->assertSessionHas('facebook_logged_in', true);
        $response->assertSessionMissing('warning');
    } finally {
        Carbon::setTestNow();
    }
});

it('checks the admin activity timestamp instead of an older channel timestamp', function () {
    Carbon::setTestNow('2026-10-07 12:00:00');

    try {
        $response = $this->withSession([
            'admin_logged_in' => true,
            'admin_last_activity' => Carbon::now()->subMinutes(5)->toDateTimeString(),
            'officer_logged_in' => true,
            'officer_last_activity' => Carbon::now()->subMinutes(40)->toDateTimeString(),
        ])->postJson(route('update.activity'), [
            'channel' => 'admin',
            'away' => false,
        ]);

        $response->assertOk();
        $response->assertSessionHas('admin_logged_in', true);
        $response->assertSessionHas('officer_logged_in', true);
    } finally {
        Carbon::setTestNow();
    }
});
