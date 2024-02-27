<?php

namespace App\Conversation;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

class ShowMenuConversation extends Conversation
{

    protected $firstName;

    public function __construct($firstName)
    {
        $this->firstName = $firstName;
    }

    public function showMenu()
    {
        $this->ask("Presiona 1 para Cotizaciones, 2 para envio de mensaje a gerencia", function(Answer $answer) {
            $seleccion = $answer->getText();
            if($seleccion === "1") {

                $this->bot->startConversation(new CotizacionConversation($this->firstName));
            }
        });
    }

    public function run()
    {
        $this->showMenu();
    }
}
