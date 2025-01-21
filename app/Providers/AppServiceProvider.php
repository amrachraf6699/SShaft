<?php

namespace App\Providers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        Schema::defaultStringLength(191);

        $factory->macro('api', function ($data = null, $code = null, $error = false, $message = null) {

            // Array response message
            $response_message = [
                200 => __('api.Successful operation'),
                // 201 => '',
                // 401 => '',
                // 403 => '',
                // 404 => '',
                500 => 'Internal Server Error!',
            ];

            return response()->json([
                'status' => [
                    'code'      => $code,
                    'error'     => $error, // true or false
                    'message'   => $message ?? $response_message[$code],
                ],
                'data'  => $data
            ], $code);
        });

        if (!request()->is('dashboard/*')) {
            Paginator::defaultView('vendor.pagination.albir');
        }
    }
}
