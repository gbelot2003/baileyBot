<?php

namespace App\Conversation\V2;

use App\Models\Product;
use App\Mail\SendCotizacion;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
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

            if($respuesta == 1){
                $valor = 'camas';
            } elseif($respuesta == 2){
                $valor = 'sillas';
            } elseif($respuesta == 3){
                $valor = 'miselaneos';
            } elseif($respuesta == 4){
                $this->showMenu($this->info);
            } else {
                $this->bot->typesAndWaits(2);
                return $this->repeat('Esta no parece una valida, intente de nuevo');
            }

            $this->getResults($valor);

        });
    }


    protected function getResults($value)
    {
        $products = $this->products->where('tag', 'like', "%{$value}%")->get();
        $count = $products->count();
        $this->bot->typesAndWaits(2);
        $this->say("Quieres cotizar nuestras <strong>{$value}</strong>, tenemos {$count} a disposición.");
        $this->bot->typesAndWaits(2);
        $this->listItems($products);
    }

    protected function getDetails()
    {
        $this->ask("Si desea mas detalle de algun producto, marque el <strong>numero de Código</strong> se enviara un correo electrónico con las especificaciones, si no escriba <strong>0</strong> para regresar al menu principal.", function (Answer $answer){

            $respuesta = $answer->getText();

            $id = (int) $respuesta;

            if($id === 0){
                $this->showMenu($this->info);
            }

            $item = $this->products->where('id', '=', $id)->get();
            $this->sendDetails($item);
        });
    }


    protected function sendDetails($item)
    {
        Mail::to($this->info['email'])->send(new SendCotizacion($item, $this->info['name']));
        $this->bot->typesAndWaits(2);
        $this->say("Se ha enviado el listado de productos a tu correo");
        $this->bot->typesAndWaits(2);
        $this->say("Cualquier otra pregunta estamos para servirte...");
        $this->bot->startConversation(new ShowMenuConverstation($this->info));
    }

    protected function listItems($items)
    {
        foreach($items as $item){
            $this->bot->typesAndWaits(3);
            $attachment = new Image($item->image_url);
            $message = OutgoingMessage::create("{$item->name} - código <strong>{$item->id}</strong>")
                ->withAttachment($attachment);

            $this->bot->reply($message);
        }

        $this->getDetails();
    }

    protected function showMenu($info)
    {
        $this->bot->startConversation(new ShowMenuConverstation($info));
    }

    public function run()
    {
        $this->iniciarCotizaciones();
    }
}
