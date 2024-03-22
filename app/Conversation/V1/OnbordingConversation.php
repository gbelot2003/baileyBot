<?php

namespace App\Conversation\V1;

use Illuminate\Support\Facades\Validator;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

class OnbordingConversation extends Conversation
{
    protected $firstname;

    public function Welcome()
    {
        $this->ask('Para una mejor tu experiencia, ¿Podrias escribir tu nombre? Por favor!!', function(Answer $answer) {

            $validator = Validator::make(['name' => $answer->getText()], [
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->repeat('Ese no parece un nombre valido, intente de nuevo');
            }

            $this->firstname = $answer->getText();
            $this->bot->typesAndWaits(2);
            $this->say("Mucho gusto {$this->firstname}, ¿En que podemos ayudarte hoy?");
            $this->bot->typesAndWaits(2);
            $this->bot->startConversation(new ShowMenuConversation($this->firstname));
        });
    }



    public function run()
    {
        $this->Welcome();
    }
}
