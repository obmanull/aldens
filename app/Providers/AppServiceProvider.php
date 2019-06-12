<?php

namespace App\Providers;

use App\Services\Sms\ArraySender;
use App\Services\Sms\SmsRu;
use App\Services\Sms\SmsSender;
use Illuminate\Contracts\Foundation\Application;
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
        $this->app->singleton(SmsSender::class, function (Application $app) {
            $config = $app->make('config')->get('sms');

            switch ($config['driver']){
                case 'sms.ru':
                    $params = $config['drivers']['sms.ru'];
                    return new SmsRu($params['app_id'], $params['url']);
                case 'array':
                    return new ArraySender();
                default:
                    throw new \InvalidArgumentException('Undefined SMS driver '.$config['driver']);
            }

            return new SmsRu(config('sms.app_id'), config('sms.url', 'https://sms.ru/sms/send'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
