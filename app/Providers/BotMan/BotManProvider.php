<?php

namespace App\Providers\BotMan;

use Illuminate\Support\ServiceProvider;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\BotMan;
use App\BotMan\ConfigParser;
use App\BotMan\Middleware\SlackUrlMiddleware;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class BotManProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(BotMan::class, function ($app) {
            $factory = $app->make(BotManFactory::class);

            return BotManFactory::create(config('bot.drivers'));
        });
    }

    public function boot(BotMan $bot, ConfigParser $parser)
    {
        $bot->setcontainer($this->app);
        $bot->middleware->received(new SlackUrlMiddleware());

        $parser->configure($bot);
    }
}
