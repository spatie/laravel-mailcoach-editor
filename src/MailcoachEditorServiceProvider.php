<?php

namespace Spatie\MailcoachEditor;

use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MailcoachEditorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('mailcoach-editor')
            ->hasViews()
            ->hasAssets()
            ->hasConfigFile()
            ->hasMigration('create_mailcoach_editor_tables');
    }

    public function bootingPackage()
    {
        Route::macro('mailcoachEditor', function (string $url = '') {
            Route::prefix($url)->group(function () {
                $middlewareClasses = config('mailcoach.middleware.web', []);

                Route::middleware($middlewareClasses)->prefix('')->group(__DIR__ . '/../routes/api.php');
            });
        });
    }
}
