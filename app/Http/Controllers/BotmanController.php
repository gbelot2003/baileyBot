<?php

namespace App\Http\Controllers;

use config;
use BotMan\BotMan\BotManFactory;
use BotMan\Drivers\Web\WebDriver;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use App\Conversation\V2\OnbordingConversation;



class BotmanController extends Controller
{

    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = BotManFactory::create([
            'config' => [
                'user_cache_time' => 30000,
                'conversation_cache_time' => 30000,
            ],
        ], new LaravelCache());

        DriverManager::loadDriver(WebDriver::class);

        $botman->hears('{message}', function($bot, $message) {
            $bot->startConversation(new OnbordingConversation());
        });

        $botman->listen();

    }
}
