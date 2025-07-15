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
        ], 'claude-flux-docs');
    }
}