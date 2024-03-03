<?php

namespace App\Mail;

use App\Pasantia;
use App\User;
use App\Empresa;
use App\EvalTutor;
use App\Proyecto;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class emailSend extends Mailable
{
  use Queueable, SerializesModels;

	public $mailSubject;
	public $mailView;
  public $pasantia;
	public $user;
	public $empresa;
	public $evalTutor;
	public $proyecto;

  public function __construct($mailSubject, $mailView, Pasantia $pasantia = null, User $user = null, Empresa $empresa = null, EvalTutor $evalTutor = null, Proyecto $proyecto = null) {
		$this->mailSubject = $mailSubject;
		$this->mailView = $mailView;
		$this->user = $user;
		$this->pasantia = $pasantia;
		$this->empresa = $empresa;
		$this->evalTutor = $evalTutor;
		$this->proyecto = $proyecto;
  }
  public function build()
  {
    return $this->subject($this->mailSubject)->view($this->mailView);
  }
}
