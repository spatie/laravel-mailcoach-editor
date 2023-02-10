<?php

namespace Spatie\MailcoachEditor;

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\Mailcoach\Mailcoach;

class MailcoachEditorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('mailcoach-editor')
            ->hasViews()
            ->hasConfigFile();
    }

    public function bootingPackage()
    {
        Route::macro('mailcoachEditor', function (string $url = '') {
            Route::prefix($url)->group(function () {
                $middlewareClasses = config('mailcoach.middleware.web', []);

                Route::middleware($middlewareClasses)->prefix('')->group(__DIR__ . '/../routes/api.php');
            });
        });

        Livewire::component('mailcoach-editor::editor', Editor::class);

        Mailcoach::editorScript(Editor::class, 'https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest');
        Mailcoach::editorScript(Editor::class, 'https://cdn.jsdelivr.net/npm/@editorjs/header@latest');
        Mailcoach::editorScript(Editor::class, 'https://cdn.jsdelivr.net/npm/@editorjs/list@latest');
        Mailcoach::editorScript(Editor::class, 'https://cdn.jsdelivr.net/npm/@editorjs/image@latest');
        Mailcoach::editorScript(Editor::class, 'https://cdn.jsdelivr.net/npm/@editorjs/quote@latest');
        Mailcoach::editorScript(Editor::class, 'https://cdn.jsdelivr.net/npm/@editorjs/delimiter@latest');
        Mailcoach::editorScript(Editor::class, 'https://cdn.jsdelivr.net/npm/@editorjs/raw@latest');
        Mailcoach::editorScript(Editor::class, 'https://cdn.jsdelivr.net/npm/@editorjs/table@latest');
        Mailcoach::editorScript(Editor::class, 'https://cdn.jsdelivr.net/npm/@editorjs/code@latest');
        Mailcoach::editorScript(Editor::class, 'https://cdn.jsdelivr.net/npm/@editorjs/inline-code@latest');
        Mailcoach::editorScript(Editor::class, 'https://cdn.jsdelivr.net/npm/editorjs-button@1.0.4');
    }
}
