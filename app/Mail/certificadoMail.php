<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class certificadoMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = PDF::loadView('pasantia/certificado', $this->data);

        return $this->subject('Certificado Pasantía')->view('emails.certificadoPasantia')->attachData($pdf->output(), 'Certificado Pasantía ' . $this->data['nombre'] . ".pdf", [
            'mime' => 'application/pdf',
        ]);
    }
}
