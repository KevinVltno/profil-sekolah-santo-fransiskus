<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanelLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_limits_attempts_from_one_ip(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('login.proses'), [
                'username' => "username-{$attempt}",
                'password' => 'invalid-password',
            ])->assertRedirect();
        }

        $this->post(route('login.proses'), [
            'username' => 'another-username',
            'password' => 'invalid-password',
        ])->assertTooManyRequests()
            ->assertHeader('Retry-After')
            ->assertSee('Terlalu banyak percobaan masuk.');

        $this->travel(1)->minutes();
        $this->post(route('login.proses'), [
            'username' => 'another-username',
            'password' => 'invalid-password',
        ])->assertRedirect();
    }

    public function test_login_limits_username_across_multiple_ips(): void
    {
        for ($attempt = 1; $attempt <= 10; $attempt++) {
            $this->withServerVariables(['REMOTE_ADDR' => "192.0.2.{$attempt}"])
                ->post(route('login.proses'), [
                    'username' => $attempt % 2 === 0 ? 'Guru' : 'guru',
                    'password' => 'invalid-password',
                ])->assertRedirect();
        }

        $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.20'])
            ->postJson(route('login.proses'), [
                'username' => 'guru',
                'password' => 'invalid-password',
            ])->assertTooManyRequests()->assertHeader('Retry-After');
    }

    public function test_valid_panel_credentials_still_log_in(): void
    {
        $admin = Admin::create([
            'nama' => 'Pengelola Sekolah',
            'username' => 'pengelola',
            'password' => 'password-yang-kuat',
        ]);

        $this->post(route('login.proses'), [
            'username' => $admin->username,
            'password' => 'password-yang-kuat',
        ])->assertRedirectToRoute('admin.dashboard');

        $this->assertAuthenticatedAs($admin, 'admin');
    }
}
