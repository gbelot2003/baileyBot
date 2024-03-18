<?php

namespace App\Conversation\V2;

use Illuminate\Support\Facades\Validator;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;


class OnbordingConversation extends Conversation
{
    protected $info = [];

    public function welcome()
    {
        $this->bot->typesAndWaits(2);
        $this->bot->reply('Benvenido a nuestro sistema de atención');
        $this->bot->typesAndWaits(2);
        $this->askForName();
    }


    public function askForName()
    {
        $this->say('Para una mejor tu experiencia, podrias facilitarnos la siguiente información!!');
        $this->bot->typesAndWaits(2);
        $this->ask(' ¿Podrias escribir tu nombre? Por favor!!', function(Answer $answer) {
            $validator = Validator::make(['name' => $answer->getText()], [
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->repeat('Ese no parece un nombre valido, intente de nuevo');
            }

            $this->info['name'] = $answer->getText();
            $this->bot->typesAndWaits(1);
            $this->askForEmail();
        });

    }

    public function askForEmail()
    {
        $this->ask('un correo electrónico al cual contactarte por favor!!', function(Answer $answer) {
            $validator = Validator::make(['email' => $answer->getText()], [
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return $this->repeat('Ese no parece un correo valido, intente de nuevo!!');
            }

            $this->info['email'] = $answer->getText();
            $this->bot->startConversation(new ShowMenuConverstation($this->info));
        });
    }

    public function run()
    {
        $this->welcome();
    }
}
