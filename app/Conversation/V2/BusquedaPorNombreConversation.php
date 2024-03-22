<?php

namespace App\Conversation\V2;
use App\Models\Product;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Conversations\Conversation;

class BusquedaPorNombreConversation extends Conversation
{
    private $info;
    private $products;

    public function __construct($info)
    {
        $this->info = $info;
        $this->products = new Product();
    }

    protected function searchByName()
    {
        $this->ask("Ingrese la palabra clave con la que desea hacer la busqueda.", function (Answer $answer){
            $seleccion = $answer->getText();
            \Log::info("seleccion " . $seleccion);

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
    }

    public function run()
    {
        $this->searchByName();
    }
}
