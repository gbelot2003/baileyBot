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
        $this->say("Puede <strong>introducir el nombre del producto</strong> que esta buscando.");
        $this->bot->typesAndWaits(2);
        $this->say('Puede ingresar 1 para cotizar las <strong>Camas</strong> displonibles.');
        $this->bot->typesAndWaits(2);
        $this->say('Puede ingresar 2 para cotizar las <strong>Sillas</strong> disponibles.');
        $this->bot->typesAndWaits(2);
        $this->say('Puede ingresar 3 para cotizar productos <strong>miselaneos disponibles</strong>.');
        $this->bot->typesAndWaits(2);
        $this->ask("Tambien puede presionar 4 para regresar al menu principal:", function (Answer $answer){

            $respuesta = $answer->getText();

            if($respuesta === '1') {
                $this->bot->startConversation(new CotizacionCamasConversation($this->firstName));
            }

            if($respuesta === '4') {
                $this->bot->startConversation(new ShowMenuConversation($this->firstName));
            }

        });
    }

    public function run()
    {
        $this->initCotizacion();
    }
}
