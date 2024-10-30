<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class ReportGenerator
{
    private $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Activamos visualización de imágenes
        $options->set('defaultFont', 'Helvetica'); // Asignamos la fuente
        $this->dompdf->setOptions($options);
    }

    public function createReport($arrInst, $data, $entidad, $orientacion, $AlignFila, $descripcion = '')
    {
        // Cargar HTML
        ob_start();
        require_once 'public/templates/bodyReport.php';
        $html = ob_get_clean();

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper("A4", $orientacion);
        $this->dompdf->render();

        // Agregar el script para el número de página
        $canvas = $this->dompdf->getCanvas();
        $fontMetrics = $this->dompdf->getFontMetrics();
        $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
        if ($orientacion === 'portrait') {
            $top = 810;
            $left = 275;
        } else {
            $top = 560;
            $left = 390;
        }
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($font, $top, $left) {
            $canvas->text($left, $top, "Página $pageNumber de $pageCount", $font, 10);
        });

        $pdf = $this->dompdf->stream('Reporte ' . $entidad . '.pdf', array('Attachment' => false)); // Desactivamos descarga por defecto y nombre de archivo
        exit;
    }
}
