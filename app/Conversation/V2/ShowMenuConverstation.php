<?php

namespace App\Conversation\V2;

use BotMan\BotMan\Messages\Incoming\Answer;
use App\Conversation\V2\CotizacionesConversation;
use BotMan\BotMan\Messages\Conversations\Conversation;


class ShowMenuConverstation extends Conversation
{

    protected $info;

    public function __construct($info)
    {
        $this->info = $info;
    }

    public function menu()
    {
        $this->bot->typesAndWaits(2);
        $this->say("Bienvenido <strong>{$this->info['name']}</strong> 🙋‍♂️🙋‍♂️🙋‍♂️");
        $this->bot->typesAndWaits(2);
        $this->say("<strong>MENU PRINCIPAL</strong>");
        $this->bot->typesAndWaits(2);
        $this->ask("Presiona <strong>1</strong> para <strong>Cotizaciones</strong>", function(Answer $answer) {
            $seleccion = $answer->getText();
            if($seleccion === "1") {
                $this->bot->typesAndWaits(2);
                $this->bot->startConversation(new CotizacionesConversation($this->info));
            }
        });
    }

    public function run()
    {
        $this->menu();
    }
}
