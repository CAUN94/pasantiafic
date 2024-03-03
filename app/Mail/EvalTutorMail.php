<?php

namespace App\Mail;

use App\Pasantia;
use App\User;
use App\Empresa;
use App\EvalTutor;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class evalTutorMail extends Mailable{
  use Queueable, SerializesModels;

	public $pasantia;
	public $user;
	public $empresa;
	public $evalTutor;
  public function __construct(Pasantia $pasantia, User $user, Empresa $empresa, EvalTutor $evalTutor){
		$this->user = $user;
		$this->pasantia = $pasantia;
		$this->empresa = $empresa;
		$this->evalTutor = $evalTutor;

  }
  public function build(){
    return $this->subject('Correo evaluación pasantía')->view('emails.evalTutor');
  }
}
