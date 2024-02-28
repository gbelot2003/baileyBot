<?php

namespace App\Conversation;

use App\Models\Product;
use App\Mail\SendCotizacion;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;


class CotizacionCamasConversation extends Conversation
{
    protected $firstName;
    protected $email;


    public function __construct($firstName)
    {
        $this->firstName = $firstName;
    }

    public function cotizarCamas()
    {
        $countCamas = Product::where("tag", 'LIKE', "%camas%")->count();
        $this->bot->typesAndWaits(2);
        $this->say("Tenemos {$countCamas} tipos de camas a disposición en este momento");
        $this->bot->typesAndWaits(2);
        $this->ask("¿A que correo electronico le enviamos su cotización?", function (Answer $answer){

            $validator = Validator::make(['email' => $answer->getText()], [
                'email' => 'email',
            ]);

            if ($validator->fails()) {
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
