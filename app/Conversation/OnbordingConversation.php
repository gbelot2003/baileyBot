<?php

namespace App\Conversation;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

class OnbordingConversation extends Conversation
{
    protected $firstname;
    protected $email;

    public function Welcome()
    {
        $this->ask('Para una mejor atención,¿Cual es su nombre completo?', function(Answer $answer) {
            // Save result
            $this->firstname = $answer->getText();

            $this->say("Mucho gusto {$this->firstname}, ¿En que podemos ayudarte hoy?");
            $this->showMenu();
        });
    }

    public function showMenu()
    {
        $this->ask("Presiona 1 para Cotizaciones, 2 para envio de mensaje a gerencia", function(Answer $answer) {
            $seleccion = $answer->getText();
            if($seleccion === "1") {

                $this->bot->startConversation(new CotizacionConversation($this->firstname));
            }
        });
    }

    public function run()
    {
        $this->Welcome();
    }
}
