<?php

namespace App\Jobs;

use App\Pasantia;
use App\User;
use App\Empresa;
use App\EvalTutor;
use App\Mail\EvalTutorMail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class QueueEmailJob implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $pasantia;
	public $user;
	public $empresa;
	public $evalTutor;

	/**
  * Create a new job instance.
  *
  * @return void
  */
	public function __construct(Pasantia $pasantia, User $user, Empresa $empresa, EvalTutor $evalTutor){
		$this->user = $user;
		$this->pasantia = $pasantia;
		$this->empresa = $empresa;
		$this->evalTutor = $evalTutor;
  }

	/**
  * Execute the job.
  *
  * @return void
  */
  public function handle() {
		Mail::to($this->user->email)->send(new evalTutorMail($this->pasantia, $this->user, $this->empresa, $this->evalTutor));
  }
}
