<?php

namespace App\Conversation\V2;
use App\Models\Product;
use App\Mail\SendCotizacion;
use Illuminate\Support\Facades\Mail;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Conversations\Conversation;

class BusquedaPorNombreConversation extends Conversation
{
    protected $info;
    protected $products;

    public function __construct($info)
    {
        $this->info = $info;
        $this->products = new Product();
    }

    protected function searchByName()
    {
        $this->ask("Ingrese la palabra clave con la que desea hacer la busqueda.", function (Answer $answer){
            $seleccion = $answer->getText();

            $items = Product::where("name","like","%{$seleccion}%")->get();
            $count = $items->count();
            if( $count > 0){
                $this->printResults($items);
            } else {
                $this->repeat("No hay resultados similares a la palabra que busca, pruebe con otro termino");
            }
        });
    }

    protected function printResults($items)
    {
        foreach ($items as $item) {
            $this->bot->typesAndWaits(2);
            $attachment = new Image($item->image_url);
            $message = OutgoingMessage::create("{$item->name} - código *{$item->id}*")->withAttachment($attachment);
            $this->bot->reply($message);
        }

        $this->ask("Puedo enviar por correo electrónico la cotización, para esto *marque 1*", function(Answer $answer) use ($items){
            $respuesta = $answer->getText();
            if($respuesta == '1'){
                \Log::info($this->info);
                $this->say("Perfecto, te envio la cotización a su correo *{$this->info['email']}*");
                $this->bot->typesAndWaits(2);
                Mail::to($this->info['email'])->send(new SendCotizacion($items, $this->info['name']));
                $this->say("Se ha enviado el listado de productos a tu correo");
                $this->bot->typesAndWaits(2);
                $this->say("Cualquier otra pregunta estamos para servirte...");
                $this->bot->typesAndWaits(2);
                $this->bot->startConversation(new ShowMenuConverstation($this->info));
            }
        });
    }

    protected function sendMail($items) {
        $this->say("Perfecto, te envio la cotización a su correo *{$this->info['email']}*");
        $this->bot->typesAndWaits(2);
        Mail::to($this->info['email'])->send(new SendCotizacion($items, $this->info['name']));
        $this->say("Se ha enviado el listado de productos a tu correo");
        $this->bot->typesAndWaits(2);
        $this->say("Cualquier otra pregunta estamos para servirte...");
        $this->bot->typesAndWaits(2);
        $this->bot->startConversation(new ShowMenuConverstation($this->info));
    }

    public function run()
    {
        $this->searchByName();
    }
}
