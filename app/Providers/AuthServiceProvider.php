<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Post::class =>PostPolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-post' ,[PostPolicy::class,'update']);
        Gate::define('delete-post', [PostPolicy::class,'delete']);
        Gate::define('subscribe-user', [UserPolicy::class,'subscribe']);
        Gate::define('edit-comment', function (User $user,$comment){
            return $comment->user->id ===$user->id;
        });
        Gate::define('delete-comment', function (User $user,$comment){
            return $comment->user->id ===$user->id;
        });
    }
}
