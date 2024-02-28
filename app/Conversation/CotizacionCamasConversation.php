<?php

namespace App\Conversation;

use Log;
use App\Models\Product;
use App\Mail\SendCotizacion;
use PHPUnit\Framework\Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Conversations\Conversation;

class CotizacionCamasConversation extends Conversation
{
    protected $firstName;
    protected $email;
    protected $productos;


    public function __construct($firstName)
    {
        $this->firstName = $firstName;
        $this->productos = new Product();
    }

    public function cotizarCamas()
    {
        $countCamas = $this->productos->where("tag", 'LIKE', "%camas%")->count();
        $itemsCamas = $this->productos->where("tag", "LIKE", "%camas%")->get();

        $this->bot->typesAndWaits(2);
        $this->say("Tenemos {$countCamas} tipos de camas a disposición en este momento");
        $this->bot->typesAndWaits(2);
        $this->ask('Si desea le puedo mostrar las camas disponibles para ello, <strong>marque 1</strong> o le puedo enviar por correo electrónico la cotización, para esto <strong>marque 2</strong>', function (Answer $answer) use ($itemsCamas){
            $respuesta = $answer->getText();
            if($respuesta == '1'){
                $this->listarProductos($itemsCamas);
            }

            if($respuesta == '2'){
                $this->getEmail();
            }
        });
    }

    protected function listarProductos($items)
    {
        foreach($items as $item) {
            $this->bot->typesAndWaits(3);
            $attachment = new Image($item->image_url);

            $message = OutgoingMessage::create("{$item->name} - código <strong>{$item->id}</strong>")
                        ->withAttachment($attachment);

            $this->bot->reply($message);
        }
        $this->bot->typesAndWaits(2);
        $this->verDetalles();
    }

    protected function verDetalles()
    {
        $this->ask("Si desea el detalle de algun producto, marque el <strong>numero de Código</strong>, si no escriba <strong>menu</strong> para regresar al menu principal.", function (Answer $answer){
            $respuesta = $answer->getText();

            if($respuesta == "menu"){
                $this->bot->startConversation(new ShowMenuConversation($this->firstName));
            }

            $id = (int) $respuesta;
            $item = $this->productos->findOrFail($id);
            $this->bot->startConversation(new DetalleProductosConversation($this->firstName, $item));
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
        $getCamas = Product::where("tag", 'LIKE', "%camas%")->get();
        Mail::to($this->email)->send(new SendCotizacion($getCamas, $this->firstName));
        $this->bot->typesAndWaits(2);
        $this->say("Se ha enviado el listado de productos a tu correo");
        $this->bot->typesAndWaits(2);
        $this->say("Cualquier otra pregunta estamos para servirte...");
        $this->bot->startConversation(new ShowMenuConversation($this->firstName));
    }

    public function run()
    {
        $this->cotizarCamas();
    }
}
