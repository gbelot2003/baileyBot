<?php

namespace App\Conversation;

use Illuminate\Support\Facades\Validator;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

class OnbordingConversation extends Conversation
{
    protected $firstname;

    public function Welcome()
    {
        $this->ask('Para una mejor atención,¿Cual es su nombre completo?', function(Answer $answer) {
           // \Log::info($answer);

            $validator = Validator::make(['name' => $answer->getText()], [
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->repeat('Ese no parece un nombre valido, intente de nuevo');
            }

            $this->firstname = $answer->getText();
            $this->say("Mucho gusto {$this->firstname}, ¿En que podemos ayudarte hoy?");
            $this->bot->startConversation(new ShowMenuConversation($this->firstname));
        });
    }



    public function run()
    {
        $this->Welcome();
    }
}
