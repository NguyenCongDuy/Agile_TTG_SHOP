<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Contact;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap(); 

        View::composer('layout.blocks.aside', function ($view) {
            $unprocessedContactsCount = Contact::where('is_processed', false)->count();
            $view->with('unprocessedContactsCount', $unprocessedContactsCount);
        });
    }
}

