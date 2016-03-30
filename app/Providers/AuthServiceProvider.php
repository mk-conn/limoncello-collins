<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Neomerx\LimoncelloIlluminate\Api\Policies\BoardPolicy;
use Neomerx\LimoncelloIlluminate\Api\Policies\CommentPolicy;
use Neomerx\LimoncelloIlluminate\Api\Policies\PostPolicy;
use Neomerx\LimoncelloIlluminate\Api\Policies\RolePolicy;
use Neomerx\LimoncelloIlluminate\Api\Policies\UserPolicy;
use Neomerx\LimoncelloIlluminate\Database\Models\Board;
use Neomerx\LimoncelloIlluminate\Database\Models\Comment;
use Neomerx\LimoncelloIlluminate\Database\Models\Post;
use Neomerx\LimoncelloIlluminate\Database\Models\Role;
use Neomerx\LimoncelloIlluminate\Database\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Board::class   => BoardPolicy::class,
        Comment::class => CommentPolicy::class,
        Post::class    => PostPolicy::class,
        Role::class    => RolePolicy::class,
        User::class    => UserPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
