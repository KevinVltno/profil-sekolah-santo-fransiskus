<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Support\Upload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_teacher_profile_and_panels_render(): void
    {
        $this->get(route('guru'))->assertOk()->assertSee('Profil guru dan staf belum tersedia.');

        foreach (['admin' => 'Administrator', 'guru' => 'Guru'] as $role => $label) {
            $account = Admin::create([
                'nama' => $label,
                'username' => $role,
                'password' => 'password-for-testing',
            ]);
            $account->forceFill(['role' => $role])->save();

            $this->actingAs($account, 'admin')->get(route('admin.dashboard'))
                ->assertOk()
                ->assertSee($label);
        }
    }

    public function test_uploaded_image_is_served_from_database(): void
    {
        $file = new UploadedFile(public_path('img/guru-placeholder.webp'), 'guru.webp', 'image/webp', test: true);
        $path = Upload::simpan($file);

        $this->get('/'.$path)->assertOk()->assertHeader('Content-Type', 'image/webp')
            ->assertContent($file->getContent());

        Upload::hapus($path);
        $this->get('/'.$path)->assertNotFound();
    }
}
