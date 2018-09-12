<?php

namespace App\Listeners;

use App\Events\UserWasCreated;
use App\Mail\LoginCredentials;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendLoginCredentials
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     //
    // }

    /**
     * Handle the event.
     *
     * @param  UserWasCreated  $event
     * @return void
     */
    public function handle(UserWasCreated $event)
    {
        // accion en respuesta al evento
        // Enviar el email con las credenciales del login
        // dd($event->user->toArray(), $event->password);
        // se puede enviar con send pero es recomendable queue
        Mail::to($event->user)->queue(
            new LoginCredentials($event->user, $event->password)
        );
    }
}
