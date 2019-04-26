<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class mail_cierreCaja extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $envio;
    public function __construct($envio)
    {
        
        $this->envio=$envio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fecha=$this->envio["fecha"];
        $hora=$this->envio["hora"];
        $archivos=$this->envio["archivos"];

        //asunto
        $email=$this->subject("Cierre del ".$fecha." ".$hora)
            ->from('resmirador@gmail.com','Rest. El Mirador')
            ->view('mails.mail_cierre');
 

        //agregando los archivos adjuntos
        foreach($archivos as $archivo){  
            $email->attach($archivo["path"],[
                'as' => $archivo["nombre"]
            ]); 
        }



        return $email;
    }
}
