<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Dompdf\Dompdf;
use Dompdf\Options;


class NotaServicioMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $datos;

    public function __construct($datos)
    {
        //
        $this->datos = $datos;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('ventas@vetlink.com', 'Ventas Vetlink'),
            subject: 'Nota de Servicio #',
        );
    }

    private function generatePdf($datos)
    {
        $pdf = new Dompdf();
        $pdfOptions = new Options();
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);
        $pdf->setOptions($pdfOptions);
        $html = view('pdf.notaservicio', $datos)->render();
        $pdf->loadHtml($html);
        $pdf->render();
        return $pdf->output();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $datos = [
            'nombre_cliente' => $this->datos['nombre_cliente'],
            'nombre_paciente' => $this->datos['nombre_paciente'],
            'total_servicio' => $this->datos['total_servicio'],
            'descripcion' => $this->datos['descripcion'],
            'fecha' => $this->datos['fecha'],
        ];

        // Generar el PDF
        $pdfOutput = $this->generatePdf($datos);

        // Adjuntar el PDF al correo electrónico
        return $this->view('emails.notaservicio')
                ->with($datos)
                ->attachData($pdfOutput, 'notaservicio.pdf', [
                    'mime' => 'application/pdf',
                ]);
    }
}
