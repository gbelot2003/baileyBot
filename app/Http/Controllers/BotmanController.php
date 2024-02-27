<?php

namespace App\Http\Controllers;

use config;
use BotMan\BotMan\BotManFactory;
use BotMan\Drivers\Web\WebDriver;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use App\Conversation\OnbordingConversation;



class BotmanController extends Controller
{

    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        //$doctrineCacheDriver = new \Doctrine\Common\Cache\PhpFileCache('cache'); // 'cache' is the cache folder that you want to use

        $botman = BotManFactory::create([
            'config' => [
                'user_cache_time' => 30000,
                'conversation_cache_time' => 30000,
            ],
        ], new LaravelCache());

        DriverManager::loadDriver(WebDriver::class);

        $botman->hears('Hello', function($bot) {
            $bot->startConversation(new OnbordingConversation());
        });

        $botman->listen();

    }
}
