<?php

namespace App\Conversation\V2;

use App\Models\Product;
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

    }

    public function run()
    {
        $this->iniciarCotizaciones();
    }
}
