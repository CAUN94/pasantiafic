<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Defensa;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function downloadICS($id)
    {
        $defensa = Defensa::findOrFail($id);

        $icsContent = $this->generateICSContent($defensa);
        $filename = "defensa-{$id}.ics";

        return response($icsContent)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function generateICSContent($defensa)
    {

        $startDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $defensa->fecha." ".$defensa->hora);
        $endDateTime = clone $startDateTime;
        $endDateTime->modify('+1 hours');  // Añade una hora para el evento

        

    

        // Formatea las fechas para el estándar iCalendar
        $icsStart = $startDateTime->format('Ymd\THis');
        $icsEnd = $endDateTime->format('Ymd\THis');

        // Genera el contenido del archivo .ics
        $icsData = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nBEGIN:VEVENT\r\n";
        $icsData .= "DTSTART:{$icsStart}\r\n";
        $icsData .= "DTEND:{$icsEnd}\r\n";
        $icsData .= "SUMMARY:Defensa {$defensa->id}\r\n";  // Título del evento
        $icsData .= "DESCRIPTION:{$defensa->comentario}\r\n";  // Comentario de la agenda
        // Agrega más información según sea necesario
        $icsData .= "END:VEVENT\r\nEND:VCALENDAR";

        return $icsData;
    }

}
