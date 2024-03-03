<?php

namespace App\Mail;

use App\Pasantia;
use App\User;
use App\Empresa;
use App\Proyecto;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class proyectoAlumno extends Mailable
{
  use Queueable, SerializesModels;

  public $pasantia;
  public $user;
  public $proyecto;
  public function __construct(Pasantia $pasantia, User $user, Proyecto $proyecto)
  {
    $this->user = $user;
    $this->pasantia = $pasantia;
    $this->proyecto = $proyecto;
  }
  public function build()
  {
    return $this->subject('Notificacion de cambios en proyecto de pasantía')->view('emails.proyectoAlumno');
  }
}
