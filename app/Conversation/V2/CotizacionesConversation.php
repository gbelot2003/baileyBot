<?php

namespace App\Conversation\V2;

use App\Models\Product;
use App\Mail\SendCotizacion;
use Illuminate\Support\Facades\Mail;
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

        $message = "Puede ingresar *1* para cotizar las *Camas*," . PHP_EOL;
        $message .= "*2* para cotizar las *Sillas* " . PHP_EOL;
        $message .= "y *3* para cotizar las *Miselaneos* displonibles.";

        $this->say("*{$this->info['name']}*, Bienvenido al *Sistema de Cotizaciones*");
        $this->bot->typesAndWaits(2);
        $this->say($message);
        $this->bot->typesAndWaits(2);
        $this->ask("Tambien puede presionar *4* para regresar al menu principal:", function (Answer $answer){

            $respuesta = (int) $answer->getText();

            if($respuesta == 1){
                $valor = 'camas';
                $this->getResults($valor);
            } elseif($respuesta == 2){
                $valor = 'sillas';
                $this->getResults($valor);
            } elseif($respuesta == 3){
                $valor = 'miselaneos';
                $this->getResults($valor);
            } elseif ($respuesta == 4){
                $this->bot->startConversation(new ShowMenuConverstation($this->info));
            } else {
                $message = "Esa opción no se encuentra registrada.";
                $message .= "Puede ingresar *1* para cotizar las *Camas*," . PHP_EOL;
                $message .= "*2* para cotizar las *Sillas* " . PHP_EOL;
                $message .= "y *3* para cotizar las *Miselaneos* displonibles.";

                $this->repeat($message);
            }
        });
    }


    protected function getResults($value)
    {
        $products = $this->products->where('tag', 'like', "%{$value}%")->get();
        $count = $products->count();
        $this->bot->typesAndWaits(2);
        $this->say("Quieres cotizar nuestras *{$value}*, tenemos {$count} a disposición.");
        $this->bot->typesAndWaits(2);
        $this->listItems($products);
    }

    protected function getDetails()
    {
        $this->ask("Si desea mas detalle de algun producto, marque el *numero de Código* se enviara un correo electrónico con las especificaciones, si no escriba *0* para regresar al menu principal.", function (Answer $answer){

            $respuesta = $answer->getText();

            $id = (int) $respuesta;

            if($id === 0){
                $this->showMenu($this->info);
            } else {
                $item = $this->products->where('id', '=', $id)->get();
                $this->sendDetails($item);
            }


        });
    }


    protected function sendDetails($item)
    {
        Mail::to($this->info['email'])->send(new SendCotizacion($item, $this->info['name']));
        $this->bot->typesAndWaits(2);
        $this->say("Se ha enviado el listado de productos a tu correo, Cualquier otra pregunta estamos para servirte...");
        $this->bot->startConversation(new ShowMenuConverstation($this->info));
    }

    protected function listItems($items)
    {
        foreach($items as $item){
            $this->bot->typesAndWaits(2);
            $attachment = new Image($item->image_url);
            $message = OutgoingMessage::create("{$item->name} - código *{$item->id}*")->withAttachment($attachment);

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
