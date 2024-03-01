<?php

namespace App\Conversation;

use App\Models\Product;
use App\Mail\SendCotizacion;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
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
        $attachment = new Image($this->item->image_url, $this->item->name);
        $message = OutgoingMessage::create("código <strong>{$this->item->id}</strong>")
                        ->withAttachment($attachment);
        $this->bot->reply($message);
        $this->bot->typesAndWaits(2);
        $this->envioPorEmail();
    }

    protected function envioPorEmail()
    {
        $this->bot->typesAndWaits(2);
        $this->ask("¿Enviamos la cotización de este producto por correo? <strong>marque 1</strong> o regresamos al Menu Principal, <strong>marque 2</strong>", function (Answer $answer){
            $respuesta = $answer->getText();
            if($respuesta == 1) {
                $this->getEmail();
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

    public function getEmail()
    {
        $this->ask("Perfecto, le enviaremos la cotización a su correo, escriba la <strong>dirección electrónica</strong> por favor:", function (Answer $answer){
            $validator = Validator::make(['email' => $answer->getText()], [
                'email' => 'email',
            ]);

            if($validator->fails()) {
                $this->bot->typesAndWaits(2);
                return $this->repeat('Ese no parece un correo valido, intente de nuevo');
            }

            $this->email = $answer->getText();
            $this->confirmarCorreo();
        });
    }

    public function confirmarCorreo()
    {
        $this->bot->typesAndWaits(2);
        $this->ask("¿Te enviamos un listado por correo?, presiona 1 para confirmar", function (Answer $answer){
            $respuesta = $answer->getText();
            if($respuesta == 1){
                $this->sendCotizacionCama();
            } else {
                $this->bot->typesAndWaits(2);
                $this->say("Se ha detenido el proceso, consulanos cualquier otra pregunta!!!");
                $this->bot->typesAndWaits(2);
                $this->bot->startConversation(new ShowMenuConversation($this->firstName));
            }
        });
    }

    public function sendCotizacionCama()
    {
        $items = [];
        array_push($items, $this->item);
        Mail::to($this->email)->send(new SendCotizacion($items, $this->firstName));
        $this->bot->typesAndWaits(2);
        $this->say("Se ha enviado el listado de productos a tu correo");
        $this->bot->typesAndWaits(2);
        $this->say("Cualquier otra pregunta estamos para servirte...");
        $this->bot->startConversation(new ShowMenuConversation($this->firstName));
        $this->bot->typesAndWaits(2);
        $this->say("Se ha enviado el listado de productos a tu correo");
        $this->bot->typesAndWaits(2);
        $this->say("Cualquier otra pregunta estamos para servirte...");
        $this->bot->startConversation(new ShowMenuConversation($this->firstName));
    }

    public function run()
    {
        $this->verDetalleProducto();
    }
}
