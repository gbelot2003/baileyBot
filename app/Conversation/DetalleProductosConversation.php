<?php

namespace App\Conversation;

use App\Mail\SendCotizacion;
use Illuminate\Support\Facades\Mail;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Conversations\Conversation;

class DetalleProductosConversation extends Conversation
{
    protected $firstName;
    protected $email;
    protected $item;

    public function __construct($firstName, $item)
    {
        $this->firstName = $firstName;
        $this->item = $item;
    }

    protected function verDetalleProducto()
    {
        $attachment = new Image($this->item->image_url);
        $message = OutgoingMessage::create("{$this->item->name} - código <strong>{$this->item->id}</strong>")
                        ->withAttachment($attachment);
        $this->bot->reply($message);
        $this->say($this->item->description);
        $this->say($this->item->price);
        $this->envioPorEmail();
    }


    protected function envioPorEmail()
    {
        $this->bot->typesAndWaits(2);
        $this->ask("¿Enviamos la cotización de este producto por correo? <strong>marque 1</strong> o regresamos al Menu Principal, <strong>marque 2</strong>", function (Answer $answer){
            $respuesta = $answer->getText();
            if($respuesta == 1) {
                Mail::to($this->email)->send(new SendCotizacion($this->item, $this->firstName));
                $this->bot->typesAndWaits(2);
                $this->say("Se ha enviado el listado de productos a tu correo");
                $this->bot->typesAndWaits(2);
                $this->say("Cualquier otra pregunta estamos para servirte...");
                $this->bot->startConversation(new ShowMenuConversation($this->firstName));
            }

            if($respuesta == 2) {
                $this->bot->typesAndWaits(2);
                $this->bot->startConversation(new ShowMenuConversation($this->firstName));
            }

            $this->bot->fallback(function($bot) {
                $bot->repeat('Lo siento no entendí ese comando, repita la opción por favor!!!');
            });

        });
    }


    public function run()
    {
        $this->verDetalleProducto();
    }
}
