<?php

namespace Spatie\MailcoachEditor\Tests;

use CreateMailcoachEditorTables;
use CreateMailcoachTables;
use CreateMediaTable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Mailcoach\MailcoachServiceProvider;
use Spatie\MailcoachEditor\MailcoachEditorServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Spatie\\Mailcoach\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        Route::mailcoachEditor('mailcoachEditor');

        $this->withoutExceptionHandling();
    }

    protected function getPackageProviders($app)
    {
        return [
            MediaLibraryServiceProvider::class,
            MailcoachServiceProvider::class,
            MailcoachEditorServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');

        include_once __DIR__.'/../../../vendor/spatie/laravel-mailcoach/database/migrations/create_mailcoach_tables.php.stub';
        (new CreateMailcoachTables())->up();

        include_once __DIR__ . '/../database/migrations/create_mailcoach_editor_tables.php.stub';
        (new CreateMailcoachEditorTables())->up();

        include_once __DIR__.'/../../../vendor/spatie/laravel-mailcoach/database/migrations/create_media_table.php.stub';
        (new CreateMediaTable())->up();
    }
}
