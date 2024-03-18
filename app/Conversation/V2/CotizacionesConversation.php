<?php

namespace App\Conversation\V2;

use App\Models\Product;
use App\Conversation\V2\ShowMenuConversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;


class CotizacionesConversation extends Conversation
{
    protected $info;
    protected $products;

    public function __construct($info) {
        $this->info = $info;
        $this->products = new Product();
    }


    public function iniciarCotizaciones() {

        $this->say("<strong>{$this->info['name']}</strong>, Bienvenido al </strong>Sistema de Cotizaciones</strong>");
        $this->bot->typesAndWaits(2);
        $this->say('Puede ingresar 1 para cotizar las <strong>Camas</strong> displonibles.');
        $this->bot->typesAndWaits(2);
        $this->say('Puede ingresar 2 para cotizar las <strong>Sillas</strong> displonibles.');
        $this->bot->typesAndWaits(2);
        $this->say('Puede ingresar 3 para cotizar las <strong>Miselaneos</strong> displonibles.');
        $this->bot->typesAndWaits(2);
        $this->ask("Tambien puede presionar 4 para regresar al menu principal:", function (Answer $answer){

            $respuesta = $answer->getText();

            if($respuesta === '1') {
                $this->bot->startConversation(new CotizacionCamasConversation($this->info));
            }

            if($respuesta === '2') {
                $this->bot->startConversation(new CotizacionSillasConversation($this->$this->info('Message');));
            }

            if($respuesta === '3') {
                $this->bot->startConversation(new CotizarMiselaneosConversation($this->info));
            }

            if($respuesta === '4') {
                $this->bot->startConversation(new ShowMenuConversation($this->info));
            }

        });
    }

    public function run()
    {
        $this->iniciarCotizaciones();
    }
}
