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
        $this->bot->typesAndWaits(2);
        $this->say("<strong>INICIO DE MENU PRINCIPAL</strong>");
        $this->bot->typesAndWaits(2);
        $this->ask("Presiona <strong>1</strong> para <strong>Cotizaciones</strong>", function(Answer $answer) {
            $seleccion = $answer->getText();
            if($seleccion === "1") {
                $this->bot->typesAndWaits(2);
                $this->bot->startConversation(new CotizacionConversation($this->firstName));
            }
        });
    }

    public function run()
    {
        $this->showMenu();
    }
}
