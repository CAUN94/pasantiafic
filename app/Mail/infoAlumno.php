<?php

namespace App\Mail;

use App\Pasantia;
use App\User;
use App\Empresa;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class infoAlumno extends Mailable
{
  use Queueable, SerializesModels;

  public $pasantia;
  public $user;
  public function __construct(Pasantia $pasantia, User $user)
  {
    $this->user = $user;
    $this->pasantia = $pasantia;
  }
  public function build()
  {
    return $this->subject('Correo pasos modificados alumno')->view('emails.infoAlumno');
  }
}
