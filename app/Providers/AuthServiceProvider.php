<?php

namespace App\Providers;

use App\MailTemplate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }

    public function registerPolicies()
    {
        Gate::define('view-all-mail', function ($user) {
            return $user->inRole('administrator');
        });
        Gate::define('create-user', function ($user) {
            return $user->hasAccess(['create-user']);
        });
        Gate::define('update-user', function ($user) {
            return $user->hasAccess(['update-user']);
        });
        Gate::define('deactivate-user', function ($user) {
            return $user->hasAccess(['update-user']);
        });
        Gate::define('delete-user', function ($user) {
            return $user->hasAccess(['update-user']);
        });
        Gate::define('create-mail', function ($user) {
            return $user->hasAccess(['create-mail']);
        });
        Gate::define('update-mail', function ($user, MailTemplate $mailTemplate) {
            return $user->hasAccess(['update-mail']) or $user->id == $mailTemplate->user_id;
        });
        Gate::define('schedule-mail', function ($user, MailTemplate $mailTemplate) {
            return $user->hasAccess(['update-mail']) or $user->id == $mailTemplate->user_id;
        });
        Gate::define('delete-mail', function ($user, MailTemplate $mailTemplate) {
            return $user->hasAccess(['update-mail']) or $user->id == $mailTemplate->user_id;
        });
    }
}
