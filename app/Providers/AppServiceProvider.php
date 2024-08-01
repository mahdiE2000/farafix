<?php

namespace App\Providers;

use App\Http\Commands\TruncateFourTablesCommand;
use App\Repositories\BlogCategoryRepositoryInterface;
use App\Repositories\BlogRepositoryInterface;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\Eloquent\BlogCategoryRepository;
use App\Repositories\Eloquent\BlogRepository;
use App\Repositories\Eloquent\CityRepository;
use App\Repositories\Eloquent\ErrorCategoryRepository;
use App\Repositories\Eloquent\ErrorRepository;
use App\Repositories\Eloquent\ErrorBrandRepository;
use App\Repositories\Eloquent\ErrorItemsRepository;
use App\Repositories\Eloquent\ProductCategoryRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\RequestRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\ErrorItemsRepositoryInterface;
use App\Repositories\ErrorBrandRepositoryInterface;
use App\Repositories\ErrorRepositoryInterface;
use App\Repositories\ErrorCategoryRepositoryInterface;
use App\Repositories\ProductCategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\RequestRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            RequestRepositoryInterface::class,
            RequestRepository::class
        );
        $this->app->bind(
            CityRepositoryInterface::class,
            CityRepository::class
        );
        $this->app->bind(
            BlogRepositoryInterface::class,
            BlogRepository::class
        );
        $this->app->bind(
            BlogCategoryRepositoryInterface::class,
            BlogCategoryRepository::class
        );
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            ProductCategoryRepositoryInterface::class,
            ProductCategoryRepository::class
        );
        $this->app->bind(
            ErrorRepositoryInterface::class,
            ErrorRepository::class
        );
        $this->app->bind(
            ErrorItemsRepositoryInterface::class,
            ErrorItemsRepository::class
        );
        $this->app->bind(
            ErrorCategoryRepositoryInterface::class,
            ErrorCategoryRepository::class
        );

        $this->app->bind(
            ErrorBrandRepositoryInterface::class,
            ErrorBrandRepository::class
        );

        Route::macro('handler', function ($prefix) {
            $singular = Str::singular($prefix);
            $parameterName = Str::camel($singular);
            $name = Str::studly($singular);

            Route::get($prefix, 'Index' . $name);
            Route::post($prefix, 'Store' . $name);
            Route::put($prefix . '/{' . $parameterName . '}', 'Update' . $name);
            Route::delete($prefix . '/{' . $parameterName . '}', 'Destroy' . $name);
            Route::get($prefix . '/{' . $parameterName . '}', 'Show' . $name);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('send-code', function (Request $request) {
            return Limit::perMinute(2)->by( $request->input('cell_number') . $request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(6)->by($request->input('username') . $request->ip());
        });

        RateLimiter::for('verify-code', function (Request $request) {
            return Limit::perMinute(6)->by($request->ip());
        });
    }
}
