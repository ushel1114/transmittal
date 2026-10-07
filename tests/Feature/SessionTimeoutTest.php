<?php

use Carbon\Carbon;

it('returns an inactive user to the landing page with a timeout notice', function () {
    Carbon::setTestNow('2026-10-07 12:00:00');

    try {
        $response = $this->withSession([
            'facebook_logged_in' => true,
            'facebook_last_activity' => Carbon::now()->subMinutes(31)->toDateTimeString(),
        ])->get(route('welcome'));

        $response->assertRedirect(route('welcome'));
        $response->assertSessionHas('warning', 'Due to inactivity, your account was logged out. Please log in again.');
        $response->assertSessionMissing('facebook_logged_in');
    } finally {
        Carbon::setTestNow();
    }
});

it('returns an inactivity redirect for expired background activity requests', function () {
    Carbon::setTestNow('2026-10-07 12:00:00');

    try {
        $response = $this->withSession([
            'facebook_logged_in' => true,
            'facebook_last_activity' => Carbon::now()->subMinutes(31)->toDateTimeString(),
        ])->postJson(route('update.activity'), [
            'channel' => 'Facebook',
            'away' => false,
        ]);

        $response->assertUnauthorized();
        $response->assertJsonPath('redirect', route('welcome'));
        $response->assertSessionHas('warning', 'Due to inactivity, your account was logged out. Please log in again.');
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
