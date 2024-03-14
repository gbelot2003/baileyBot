<?php

namespace App\Conversation\V2;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;


class ShowMenuConverstation extends Conversation
{

    protected $info;

    public function __construct($info)
    {
        $this->info = $info;
    }

    public function run()
    {
        $this->bot->typesAndWaits(2);
        $this->say("Hola {$this->info['name']}");
        $this->say("<strong>INICIO DE MENU PRINCIPAL</strong>");
        $this->bot->typesAndWaits(2);
        $this->ask("Presiona <strong>1</strong> para <strong>Cotizaciones</strong>", function(Answer $answer) {
            $seleccion = $answer->getText();
            if($seleccion === "1") {
                $this->bot->typesAndWaits(2);
            }
        });
    }
}
