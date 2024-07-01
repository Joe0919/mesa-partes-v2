<?php

require_once "../config/conexion.php";
require_once "../models/Persona.php";
require_once "../models/Usuario.php";
require_once "../models/Tramite.php";

$persona = new Persona();
$usuario = new Usuario();
$tramite = new Tramite();

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

// RECIBIR PARAMETROS DE FORMULARIO DE INGRESO DE TRAMITE
$idpersona = isset($_POST['idpersona']) ? trim($_POST['idpersona']) : '';
$ruc = isset($_POST['iruc']) ? trim($_POST['iruc']) : '';
$entidad = isset($_POST['ientidad']) ? strtoupper(trim($_POST['ientidad'])) : '';
$dni = isset($_POST['idni']) ? trim($_POST['idni']) : '';
$nombres = isset($_POST['inombre']) ? strtoupper(trim($_POST['inombre'])) : '';
$appat = isset($_POST['iappat']) ? strtoupper(trim($_POST['iappat'])) : '';
$apmat = isset($_POST['iapmat']) ? strtoupper(trim($_POST['iapmat'])) : '';
$cel = isset($_POST['icel']) ? trim($_POST['icel']) : '';
$direc = isset($_POST['idir']) ? strtoupper(trim($_POST['idir'])) : '';
$correo = isset($_POST['iemail']) ? trim($_POST['iemail']) : '';

$tipo = isset($_POST['itipo']) ? trim($_POST['itipo']) : '';
$nrodoc = isset($_POST['n_doc']) ? trim($_POST['n_doc']) : '';
$folios = isset($_POST['ifolios']) ? trim($_POST['ifolios']) : '';
$asunto = isset($_POST['iasunto']) ? strtoupper(trim($_POST['iasunto'])) : '';
$archivo = isset($_FILES['idfile']) ? $_FILES['idfile'] : '';


// PARAMETROS PARA ACCION DE ACEPTAR, DERIVAR O RECHAZAR UN TRAMITE
$origen = (isset($_POST['iorigen'])) ? $_POST['iorigen'] : '';
$destino = (isset($_POST['idestino'])) ? $_POST['idestino'] : '';
$descripcion = (isset($_POST['idescripcion'])) ?  strtoupper(trim($_POST['idescripcion'])) : '';

$bdr = (isset($_POST['bdr'])) ? $_POST['bdr'] : '';

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$expediente = (isset($_POST['expediente'])) ? $_POST['expediente'] : '';
$anio = (isset($_POST['anio'])) ? $_POST['anio'] : '';
$area = (isset($_POST['area'])) ? $_POST['area'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
$idarea = (isset($_POST['idarea'])) ? $_POST['idarea'] : '';
$idderivacion = (isset($_POST['idderivacion'])) ? $_POST['idderivacion'] : '';


$accion = (isset($_POST['accion'])) ? $_POST['accion'] : '';

switch ($opcion) {
    case 1:
        // Consultar todos los datos
        $data = $tramite->listarTramites();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 2:
        // Crear nuevo registro y guardar archivo PDF

        $a = "../../public/"; // Salir del directorio actual 

        $ruta = "files/docs/"; // Prefijo de la ruta

        $ruta_aux = $a . $ruta; //Unimos la ruta para verificar existencia

        $expediente = $tramite->generarNroExpediente(); //Consulamos nuevo expediente para el nombre del doc

        $file_tmp_name = $archivo['tmp_name'];  // Obtener archivo temporal del input
        $new_name_file = $a . $ruta . $expediente . '_' . date('Y') . '_' . $dni . '.pdf'; // Crear nombre del doc
        $nuevo = $ruta . $expediente . '_' . date('Y') . '_' . $dni . '.pdf'; //Nombre para el registro de la BD

        // Verificar si el directorio existe para crearlo
        if (!file_exists($ruta_aux)) {
            mkdir($ruta_aux);
        }

        // Copiamos el archivo al directorio
        if (move_uploaded_file($file_tmp_name, $new_name_file)) {

            $data = $persona->verificarPersonaDNI($dni);

            // Si la persona no esta registrada
            if ($data == 0) {
                // Registramos a la persona nos devuelve el ID
                $idpersona = $persona->crearNuevaPersona($dni, $appat, $apmat, $nombres, $correo, $cel, $direc, $ruc, $entidad);
            } else {
                //Editamos datos de la persona  nos devuelve el ID
                $idpersona = $persona->editarPersona($correo, $cel, $direc, $idpersona);
            }

            $data = false;

            // Registramos el tramite y guardamos el ID registrado
            $iddocumento = $tramite->registrarDatos("documento", "null,?,?,?,?,'PENDIENTE',?,?,?,'8'", [$expediente, $nrodoc, $folios, $asunto, $nuevo, $idpersona, $tipo]);
            //Registramos en el historial
            $data = $tramite->registrarDatos("historial", "null,sysdate(),?,?,'DERIVADO','SECRETARÍA','INGRESO DE NUEVO TRÁMITE'", [$expediente, $dni]);

            if ($data) {

                //Registramos el registro en la tabla derivacion
                $ultimoID = $tramite->registrarDatos("derivacion", "null, sysdate(),'EXTERIOR','8',?,''", [$iddocumento]);
                //Consultamos los datos del tramite registrado para enviar el email
                $data = $tramite->consultarTramitexExpediente(
                    "idderivacion ID, nro_expediente,dc.iddocumento doc, nro_doc,folios, estado, tipodoc, asunto, dni,
                    concat(nombres,' ',ap_paterno,' ',ap_materno) Datos, ruc_institu, institucion, area,
                    date_format(fechad, '%d/%m/%Y') Fecha, descripcion",
                    [$ultimoID],
                    "idderivacion=?"
                );
                //Importamos la clase PHPMailer
                require_once("../../vendor/phpmailer/phpmailer/src/clsMail.php");

                $enviarEmail = new clsMail();

                // Creamos el cuerpo del EMAIL
                $bodyHTML = <<<HTML
                    <html>
                        <head>
                            <title> Trámite Registrado</title>
                            <style>
                                *{
                                    padding:0;
                                    margin:0;
                                    box-sizing: content-box;
                                }
                                body{
                                    font-family: -apple-system, BlinkMacSystemFont, Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                                }
                                h1 {
                                    font-size: 1.6rem;
                                    padding: 12px;
                                    color: #fff;
                                    margin: 0;
                                }

                                h2 {
                                    font-size: 1.4rem;
                                    margin: 0;
                                    color: yellow;
                                }
                                #titu{
                                    background-color: #1f618d;
                                    text-align: center;
                                    height: 105px;
                                }
                                #table{
                                    margin: 0 auto;
                                    width: 60%;
                                    max-width: 600px;
                                }
                                .title_table{
                                    text-align:center;
                                    color: white;	
                                    font-size: 1.4rem;
                                    height: 50px;
                                    padding: 0;
                                    background-color: #8c0505;
                                    }
                                #tableDoc{
                                    margin:16px 0;
                                }
                                #tableDoc tr{
                                    text-align:center;
                                    font-size:19px;
                                }
                                
                                #tableDoc td{
                                    color: #063a6b;
                                }
                                .p_name{
                                    margin: 10px 0;
                                }
                            </style>
                        </head>

                        <body>
                            <div id="titu">
                                <h1>HOSPITAL ANTONIO CALDAS DOMÍNGUEZ - POMABAMBA</h1>
                                <h2>MESA DE PARTES VIRTUAL</h2>
                            </div>

                            <p class="p_name">Estimado(a): <b>{ $nombres } { $appat } { $apmat }</b></p><hr>
                            <p class="p_name">Se le envía este email por parte de la <b>Mesa de Partes Virtual</b> del <b>Hospital Antonio Caldas Domínguez - Pomabamba.</b>
                            <br>Para informarle que su trámite a sido enviado por lo que se le da a conocer información del trámite recepcionado:
                            </p>


                            <div id="table">
                                <table width="100%" border="1" cellspacing="0" cellpadding="5" id="tableDoc">
                                    <tr>
                                        <th colspan="2" class="title_table">
                                            DATOS DEL DOCUMENTO</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 40%;">EXPEDIENTE</th>
                                        <td>{ $data[0]['nro_expediente'] }</td>
                                    </tr>
                                    <tr>
                                        <th>N°. DOCUMENTO</th>
                                        <td>{ $data[0]['nro_doc'] }</td>
                                    </tr>
                                    <tr>
                                        <th>TIPO</th>
                                        <td>{ $data[0]['tipodoc'] }</td>
                                    </tr>
                                    <tr>
                                        <th>REMITENTE</th>
                                        <td>{ $data[0]['Datos'] }</td>
                                    </tr>
                                    <tr>
                                        <th>FECHA</th>
                                        <td>{ $data[0]['Fecha'] }</td>
                                    </tr>
                                </table>
                            </div>

                            <p>Puede realizar el seguimiento de su trámite puede ingresar a la plataforma de la <b>Mesa de Partes Virtual</b> en la pestaña <b><i>Seguimiento</i></b>
                            <br>Saludos cordiales
                            <br><b>HOSPITAL ANTONIO CALDAS DOMÍNGUEZ - POMABAMBA</b>
                            </p>

                            <p style="color: #094A8A;">_______________________________<br>
                            <b>OFICINA DE SISTEMAS Y TELECOMUNICACIONES - HACDP</b> <br>
                            <b>Contáctos:</b> 043-4510028<br>
                            <b>Dirección:</b> Carretera Norte KM 1 S/N - Huajtchacra<br>
                            <b>Plataforma Web:</b> 
                            </p>
                        </body>
                    </html>
                HTML;

                //Ejecutamos el envio de email
                $enviado =  $enviarEmail->metEnviar("MESA DE PARTES VIRTUAL - HACDP", "Usuario", "$correo", "TRÁMITE ENVIADO", $bodyHTML);

                //Consultamos e imprimimos los datos del registro realizado
                $data = '<label><b>Expediente</b>&nbsp;: ' . $data[0]['nro_expediente'] . '</label><br>' .
                    '<label><b>Nro. Documento</b>&nbsp;: ' . $data[0]['nro_doc'] . '</label><br>' .
                    '<label><b>Tipo</b>&nbsp;: ' . $data[0]['tipodoc'] . '</label><br>' .
                    '<label><b>Remitente</b>&nbsp;: ' . $data[0]['Datos'] . '</label><br>' .
                    '<label><b>Fecha</b>&nbsp;: ' . $data[0]['Fecha'] . '</label>' .
                    '<label><b>Fecha</b>&nbsp;: ' . $enviado . '</label>';
            } else {
                $data = 'Error no se guardo en el historial';
            }
        } else {
            $data = 'ERROR AL GUARDAR EL ARCHIVO';
        }
        echo $data;
        break;
    case 3:
        // Consultar por Expediente
        $data = $tramite->consultarTramitexExpediente(
            "idderivacion ID, nro_expediente,dc.iddocumento doc, nro_doc,folios,
            estado, tipodoc, asunto, dni, concat(nombres,' ',ap_paterno,' ',ap_materno) Datos, ruc_institu, institucion, archivo, area, 
            date_format(fechad, '%d/%m/%Y') Fecha, descripcion",
            [$expediente],
            "nro_expediente=?"
        );
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 4:
        // Consultar Tipos de Documentos
        $data = $tramite->consultarTabla("*", "tipodoc", "", []);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 5:
        // Consultar todos los tramites del area
        $data = $tramite->listarTramites("where area=? and estado=? and idubi=?", [$area, $estado, $idarea]);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 6:
        // Controlar si se Acepta o Rechaza un Tramite
        if ($accion === 'ACEPTAR') {
            //Cambiamos el estado del documento a aceptado
            $tramite->editarDatos("documento", "estado = 'ACEPTADO'", [$id], "iddocumento = ?");
            //Guardamos la Aceptacion en el historial del doc
            $data = $tramite->registrarDatos("historial", "null,sysdate(),?,?,'ACEPTADO',?,?", [$expediente, $dni, $origen, $descripcion]);
        } else if ($accion === 'RECHAZAR') {

            //Validamos si en SECRETARIA se rechaza el tramite 
            if ($origen === 'SECRETARIA') {
                //No es necesario Derivar a Secretaria, solo se rechaza

                //Colocamos la descripcion por la que se esta Rechazando
                $tramite->editarDatos("derivacion", "descripcion = ? ", [$descripcion, $idderivacion], "idderivacion = ?");

                //Guardamos el Rechazo en el historial del doc
                $tramite->registrarDatos("historial", "null,sysdate(),?,?,'RECHAZADO',?,?", [$expediente, $dni, $origen, $descripcion]);
            } else {
                // Se cumple que es otra area

                //Derivamos el Tramite a Secretaria
                $tramite->registrarDatos("derivacion", "null,sysdate(),?,(SELECT idarea from area where area='SECRETARIA'),?,?", [$origen, $id, $descripcion]);

                //Guardamos el Rechazo en el historial del doc
                $tramite->registrarDatos("historial", "null,sysdate(),?,?,'RECHAZADO',?,?", [$expediente, $dni, $origen, $descripcion]);

                //Guardamos la Derivacion a SECRETARIA en el historial 
                $tramite->registrarDatos("historial", "null,sysdate(),?,?,'DERIVADO','SECRETARIA',?", [$expediente, $dni, $descripcion]);
            }
            //Cambiamos el estado del documento a RECHAZADO
            $data = $tramite->editarDatos("documento", "estado = 'RECHAZADO'", [$id], "iddocumento = ?");
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 7:
        // Consultar Areas Destino
        $data = $tramite->consultarTabla(
            "ae.idareainstitu ID, cod_area, area",
            "institucion i inner join areainstitu ae on ae.idinstitucion = i.idinstitucion inner join area a on a.idarea=ae.idarea",
            "where area != ?",
            [$area]
        );
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 8:
        // Controlar si se Deriva o Archiva un Tramite
        if ($accion === '1') {

            //Derivamos el Tramite al Area Destino
            $tramite->registrarDatos("derivacion", "null,sysdate(),?,?,?,?", [$origen, $destino, $id, $descripcion]);

            //Cambiamos el estado  a PENDIENTE ya actualizamos la ubicacion del doc
            $tramite->editarDatos("documento", "estado = 'PENDIENTE', idubi=?", [$destino, $id], "iddocumento = ?");

            //Guardamos la Derivacion en el historial 
            $tramite->registrarDatos(
                "historial",
                "null,sysdate(),?,?,'DERIVADO',
            (SELECT area from area a, areainstitu e where a.idarea=e.idarea and idareainstitu=?),?",
                [$expediente, $dni, $destino, $descripcion]
            );
            $data = "DERIVADO";
        } else if ($accion === '2') {

            //Cambiamos el estado  a ARCHIVADO ya actualizamos la ubicacion del doc
            $tramite->editarDatos("documento", "estado = 'ARCHIVADO'", [$id], "iddocumento = ?");

            //Guardamos la Archivacion en el historial 
            $tramite->registrarDatos(
                "historial",
                "null,sysdate(),?,?,'ARCHIVADO',?,?",
                [$expediente, $dni, $origen, $descripcion]
            );

            $data = "Archivado";
        }

        echo json_encode($accion, JSON_UNESCAPED_UNICODE);
        break;
    case 9:
        // Consultar todos los tramites enviados desde el area
        $data = $tramite->listarTramites("where origen=?", [$area]);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 10:
        // Busqueda por Expediente, DNI y año
        $data = $tramite->consultarTramitexExpediente(
            "idderivacion ID, nro_expediente,dc.iddocumento doc, nro_doc,folios, estado, tipodoc, asunto, dni,
            concat(nombres,' ',ap_paterno,' ',ap_materno) Datos, ruc_institu, institucion, archivo, area,
            date_format(fechad, '%d/%m/%Y') Fecha, descripcion",
            [$expediente, $anio, $dni],
            "nro_expediente=? and date_format(fechad, '%Y')=? and dni=?"
        );
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 11:
        // CONSULTAMOS LOS DATOS EN LA TABLA HISTORIAL
        $resultado = $tramite->consultarTabla(
            "idhistorial, accion, area, date_format(fecha, '%d/%m/%Y') fecha, time_format(fecha, '%H:%i:%s %p') hora, descrip",
            "historial",
            "where expediente=? and date_format(fecha, '%Y')=? and dni=?",
            [$expediente, $anio, $dni]
        );

        // EMPEZAMOS A DIBUJAR LA LINEA DE TIEMPO DEL TRAMITE
        print <<<HTML
                <div class="timeline" id="div_historial">
                    <div class="time-label">
                        <span class="bg-red">HISTORIAL DEL TRÁMITE: </span>
                    </div>
                    <div class="time-label">
                        <span class="bg-green">EXPEDIENTE <b>{$expediente}</b></span>
                    </div>
                HTML;
        // VALIDAMOS EL ESTADO DEL TRAMITE PARA CONDICIONAR EL ICONO A DIBUJAR
        foreach ($resultado as $data) {
            switch ($data['accion']) {
                case 'DERIVADO':
                    $icono = <<<HTML
                            <i class="fas fa-arrow-circle-right bg-yellow"></i> 
                         HTML;
                    $preposicion = "a";
                    break;
                case 'ACEPTADO':
                    $icono = <<<HTML
                            <i class="fas fa-check bg-green"></i> 
                         HTML;
                    $preposicion = "en";
                    break;
                case 'RECHAZADO':
                    $icono = <<<HTML
                            <i class="fas fa-remove-format bg-red"></i>
                         HTML;
                    $preposicion = "en";
                    break;
                case 'ARCHIVADO':
                    $icono = <<<HTML
                            <i class="fas fa-save bg-blue"></i> 
                         HTML;
                    $preposicion = "en";
                    break;
            }
            // AGREGAMOS EL ICONO AL CODIGO REPETIDO
            print <<<HTML
                    <div>
                        {$icono}
                        <div class="timeline-item">
                            <span style="font-size:18px" class="time"><i class="fas fa-clock"></i> {$data['hora']}</span>
                            <h3 style="font-size:18px" class="timeline-header">El trámite fue <b class="text-primary">{$data['accion']}</b> {$preposicion}
                                <b class="text-primary">{$data['area']}</b> el <b class="text-muted">{$data['fecha']}</b></h3>
                            <div style="font-size:15px" class="timeline-body">
                                {$data['descrip']}
                            </div>
                        </div>
                    </div>
        HTML;
        }
        // CERRAMOS EL DIV DE LA LINEA DE TIEMPO
        print <<<HTML
                <div>
                    <i class="fas fa-clock bg-gray"></i>
                </div>
            </div>
            HTML;
        break;

    case 12:
        $data = $tramite->consultarTabla(
            "distinct date_format(fechad,'%Y') dato",
            "derivacion",
        );
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 13:

        if ($anio === '') {
            $data = $tramite->consultarTabla(
                "distinct date_format(fechad,'%m') dato",
                "derivacion",
            );
        } else {
            $data = $tramite->consultarTabla(
                "distinct date_format(fechad,'%m') dato",
                "derivacion",
                "where date_format(fechad,'%Y')=?",
                [$anio]
            );
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    default:
        echo "OPCION NO VALIDA" . $opcion;
        break;
}
