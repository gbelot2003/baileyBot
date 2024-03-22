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

    protected function menu()
    {
        $this->bot->typesAndWaits(2);
        $this->say("Bienvenido *{$this->info['name']}* 🙋‍♂️🙋‍♂️🙋‍♂️");
        $this->bot->typesAndWaits(2);
        $this->say("*MENU PRINCIPAL*");
        $this->bot->typesAndWaits(2);
        $this->ask("Escriba *1* para *Cotizaciones* y *2* para *Busqueda por Nombre*", function(Answer $answer) {
            $seleccion = $answer->getText();
            if($seleccion === "1") {
                $this->bot->typesAndWaits(2);
                $this->bot->startConversation(new CotizacionesConversation($this->info));
            }
            if($seleccion === "2") {
                $this->bot->typesAndWaits(2);
                $this->bot->startConversation(new BusquedaPorNombreConversation($this->info));
            }
        });
    }

    public function run()
    {
        $this->menu();
    }
}
