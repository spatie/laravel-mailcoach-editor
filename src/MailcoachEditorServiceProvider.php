<?php

namespace Spatie\MailcoachEditor;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MailcoachEditorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mailcoach-editor');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/mailcoach/editor'),
            ], 'mailcoach-editor-views');

            if (!class_exists('CreateMailcoachEditorTables')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_mailcoach_editor_tables.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_mailcoach_editor_tables.php'),
                ], 'mailcoach-editor-migrations');
            }
        }

        Route::macro('mailcoachEditor', function (string $url = '') {
            Route::prefix($url)->group(function () {
                $middlewareClasses = config('mailcoach.middleware.web', []);

                Route::middleware($middlewareClasses)->prefix('')->group(__DIR__ . '/../routes/api.php');
            });
        });
    }
}
