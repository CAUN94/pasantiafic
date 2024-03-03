<?php

namespace App\Jobs;

use App\Pasantia;
use App\User;
use App\Empresa;
use App\EvalTutor;
use App\Proyecto;
use App\Mail\emailSend;
use Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class QueueEmailJob implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $mailSubject;
	public $mailView;
  public $pasantia;
	public $user;
	public $empresa;
	public $evalTutor;
	public $proyecto;

	/**
  * Create a new job instance.
  *
  * @return void
  */
  public function __construct($mailSubject, $mailView, Pasantia $pasantia = null, User $user = null, Empresa $empresa = null, EvalTutor $evalTutor = null, Proyecto $proyecto = null) {
		$this->mailSubject = $mailSubject;
		$this->mailView = $mailView;
		$this->user = $user;
		$this->pasantia = $pasantia;
		$this->empresa = $empresa;
		$this->evalTutor = $evalTutor;
		$this->proyecto = $proyecto;
  }

	/**
  * Execute the job.
  *
  * @return void
  */
  public function handle() {
		Mail::to($this->user->email)->send(new emailSend($this->mailSubject, $this->mailView, $this->pasantia, $this->user, $this->empresa, $this->evalTutor, $this->proyecto));
  }
}
