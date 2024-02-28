<?php

namespace App\Conversation;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

class CotizacionConversation extends Conversation
{

    protected $firstName;


    public function __construct($firstName)
    {
        $this->firstName = $firstName;
    }

    public function initCotizacion()
    {
        $this->say("{$this->firstName}, Bienvenido al sistema de cotizaciones");
        $this->bot->typesAndWaits(2);
        $this->ask("Si desea cotizar camas, presione 1, Sillas presione 2, Miselaneos 3", function (Answer $answer){
            $this->bot->startConversation(new CotizacionCamasConversation($this->firstName));
        });
    }

    public function run()
    {
        $this->initCotizacion();
    }
}
