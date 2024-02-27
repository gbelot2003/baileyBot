<?php

namespace App\Conversation;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

class OnbordingConversation extends Conversation
{
    protected $firstname;

    public function Welcome()
    {
        $this->ask('Para una mejor atención,¿Cual es su nombre completo?', function(Answer $answer) {
            // Save result
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
