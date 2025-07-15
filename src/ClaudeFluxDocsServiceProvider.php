<?php

namespace PeterVanDijck\ClaudeFluxDocs;

use Illuminate\Support\ServiceProvider;

class ClaudeFluxDocsServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/claude-flux.md' => base_path('claude-flux.md'),
            __DIR__.'/../resources/claude-laravel.md' => base_path('claude-laravel.md'),
            __DIR__.'/../resources/claude.md' => base_path('claude.md'),
        ], 'claude-flux-docs');
    }
}