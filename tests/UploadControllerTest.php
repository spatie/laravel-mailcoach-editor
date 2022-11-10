<?php

namespace Spatie\MailcoachEditor\Tests;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Spatie\MailcoachEditor\Http\Controllers\EditorController;
use Spatie\MailcoachEditor\Models\Upload;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UploadControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->withExceptionHandling();
    }

    /** @test */
    public function it_uploads_files_and_returns_the_absolute_url()
    {
        $this->authenticate();

        $this
            ->postJson(action([EditorController::class, 'upload']), [
                'file' => UploadedFile::fake()->image('my-upload.jpg', 100, 100),
            ])
            ->assertSuccessful()->assertJson([
                'success' => 1,
                'file' => [
                    'url' => 'http://localhost/storage/1/conversions/my-upload-image.jpg',
                ],
            ]);

        $this->assertEquals(1, Upload::count());
        $this->assertEquals(1, Media::count());
        $this->assertEquals(1, Upload::first()->getMedia()->count());
    }

    /** @test */
    public function it_uploads_files_from_an_url()
    {
        $this->authenticate();

        $this
            ->postJson(action([EditorController::class, 'upload']), [
                'url' => 'https://placekitten.com/100/100',
            ])
            ->assertSuccessful()->assertJson([
                'success' => 1,
                'file' => [
                    'url' => 'http://localhost/storage/1/conversions/100-image.jpeg',
                ],
            ]);

        $this->assertEquals(1, Upload::count());
        $this->assertEquals(1, Media::count());
        $this->assertEquals(1, Upload::first()->getMedia()->count());
    }

    /** @test */
    public function it_must_be_an_image()
    {
        $this->authenticate();

        $this
            ->postJson(action([EditorController::class, 'upload']), [
                'file' => UploadedFile::fake()->create('my-upload.jpg', 100, 'text/csv'),
            ])
            ->assertStatus(422)->assertJsonValidationErrors('file');

        $this->assertEquals(0, Upload::count());
        $this->assertEquals(0, Media::count());
    }

    /** @test */
    public function it_will_not_allow_an_upload_if_the_guard_does_not_permit_it()
    {
        $this
            ->postJson(action([EditorController::class, 'upload']), [
                'file' => UploadedFile::fake()->image('my-upload.jpg', 100, 100),
            ])
            ->assertUnauthorized();
    }

    protected function authenticate(): void
    {
        Auth::login(new User());

        Gate::define('viewMailcoach', fn () => true);
    }
}
