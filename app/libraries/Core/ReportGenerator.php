<?php

require_once 'vendor/autoload.php';

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

    public function createReport($data, $entidad, $orientacion, $AlignFila, $descripcion = '', $padding = '')
    {
        // Configurar márgenes
        $this->dompdf->set_option('margin_top', 20);
        $this->dompdf->set_option('margin_bottom', 20);
        $this->dompdf->set_option('margin_left', 10);
        $this->dompdf->set_option('margin_right', 10);

        // Cargar HTML
        ob_start();
        require_once 'public/templates/bodyReport.php';
        $html = ob_get_clean();

        $this->dompdf->loadHtml($html); // Cargar el HTML en memoria
        $this->dompdf->setPaper("A4", $orientacion); // Tipo de hoja y orientación
        $this->dompdf->render(); // Generar el PDF en el navegador
        $this->dompdf->stream('Reporte ' . $entidad . '.pdf', array('Attachment' => false)); // Desactivamos descarga por defecto y nombre de archivo
        exit;
    }
}
