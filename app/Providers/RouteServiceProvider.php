<?php

namespace App\Providers;

use App\Models\Member;
use App\Models\Role;
use App\Models\ShopOutlet;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $apiNamespace = 'App\Http\Controllers\Api';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::model('user', \App\Models\User::class);


        Route::model('outlet', ShopOutlet::class);
        Route::model('category', \App\Models\Category::class);
        Route::model('product', \App\Models\Product::class);
        Route::model('discount', \App\Models\Discount::class);
        Route::model('order', \App\Models\Order::class);
        Route::model('customer_type', \App\Models\CustomerType::class);

        parent::boot();

        Route::bind('employee', function ($value) {
            return User::withTrashed()->where('id', $value)->first()->hasRole(Role::CASHIER)
                ? User::withTrashed()->where('id', $value)->first()
                : new ModelNotFoundException();
        });

        Route::bind('member', function($value) {
            return Member::withTrashed()->find($value) ?? new ModelNotFoundException();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->apiNamespace)
             ->group(base_path('routes/api.php'));
    }
}
