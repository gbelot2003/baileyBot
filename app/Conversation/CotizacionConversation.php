<?php

namespace App\Conversation;

use App\Mail\SendCotizacion;
use App\Models\Product;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;
use Illuminate\Support\Facades\Mail;

class CotizacionConversation extends Conversation
{

    protected $firstName;


    public function __construct($firstName)
    {
        $this->firstName = $firstName;
    }

    public function initCotizacion()
    {
        $this->say("{$this->firstName}, Bienvenido al sistema de cotizaciones");
        $this->ask("Si desea cotizar camas, presione 1, Sillas presione 2, Miselaneos 3", function (Answer $answer){
            $this->cotizarCamas();
        });
    }

    public function cotizarCamas()
    {
        $countCamas = Product::where("tag", 'LIKE', "%camas%")->count();
        $this->say("Tenemos {$countCamas} tipos de camas a disposición en este momento");
        $this->ask("¿Te enviamos un listado por correo?, presiona 1 para confirmar", function (Answer $answer){
            $respuesta = $answer->getText();
            if($respuesta == 1){
                $this->sendCotizacionCama();
            }
        });
    }

    public function sendCotizacionCama()
    {
        $getCamas = Product::where("tag", 'LIKE', "%camas%")->get();
        Mail::to("tester@tester.com")->send(new SendCotizacion($getCamas, $this->firstName));
        $this->say("Se ha enviado el listado de productos a tu correo");
    }

    public function run()
    {
        $this->initCotizacion();
    }
}
