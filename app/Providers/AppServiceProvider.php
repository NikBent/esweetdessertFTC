<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ContactSubmission;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Compose only the sidebar component view
        View::composer('components.admin.sidebar', function($view) {
            $count = ContactSubmission::whereNull('read_at')->count();
            $view->with('notificationCount', $count);
        });
    }

    public function register()
    {
        //
    }
}
