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
$idper = isset($_POST['idpersona']) ? trim($_POST['idpersona']) : '';
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
$origen = (isset($_POST['origen'])) ? $_POST['origen'] : '';
$destino = (isset($_POST['destino'])) ? $_POST['destino'] : '';
$descripcion = (isset($_POST['descrip'])) ? $_POST['descrip'] : '';


$bdr = (isset($_POST['bdr'])) ? $_POST['bdr'] : '';

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$expediente = (isset($_POST['expediente'])) ? $_POST['expediente'] : '';
$año = (isset($_POST['año'])) ? $_POST['año'] : '';
$area = (isset($_POST['area'])) ? $_POST['area'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
$idarea = (isset($_POST['idarea'])) ? $_POST['idarea'] : '';
$idder = (isset($_POST['idder'])) ? $_POST['idder'] : '';


switch ($opcion) {
    case 1:
        // Consultar todos los datos
        $data = $tramite->listarTramites();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 2:
        // Crear nuevo registro

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

                // Registramos a la persona
                $data = $persona->crearNuevaPersona($dni, $appat, $apmat, $nombres, $correo, $cel, $direc, $ruc, $entidad);

            } else {
                
                $resultado1 = mysqli_query($conexion, "UPDATE persona SET email='$correo',telefono='$cel',direccion='$direc' where idpersona='$idper'");
                $resultado1 = mysqli_query($conexion, "UPDATE usuarios SET email='$correo', fechaedicion=sysdate() where dni=(select dni from persona where idpersona='$idper')");
            }

            $existe1 = mysqli_query($conexion, "SELECT idpersona ID FROM persona where dni='$dni'");
            $fila2 = mysqli_fetch_assoc($existe1);
            $id = $fila2['ID'];
            $consulta2 = "INSERT into documento values (null, '$expediente','$nrodoc','$folios','$asunto','PENDIENTE','$nuevo','$id','$tipo','8')";
            $resultado2 = mysqli_query($conexion, $consulta2);

            $inser = mysqli_query($conexion, "INSERT into historial values(null,sysdate(),'$expediente','$dni','DERIVADO','SECRETARÍA','INGRESO DE NUEVO TRÁMITE')");

            if ($inser) {
                $iddoc = mysqli_query($conexion, "SELECT max(iddocumento) idmax from documento");
                $resu = mysqli_fetch_assoc($iddoc);
                $lastid = $resu['idmax'];

                $consulta = "INSERT into derivacion values (null, sysdate(),'EXTERIOR','8','$lastid','')";
                $resultado = mysqli_query($conexion, $consulta);
                $last = mysqli_insert_id($conexion);



                $consul = mysqli_query($conexion, "select nro_expediente expediente, nro_doc nro, tipodoc, concat(nombres, ' ',ap_paterno,' ',ap_materno) Datos, date_format(fechad, '%d/%m/%Y') Fecha
                from derivacion d, documento dc, areainstitu a, area ae, persona p, tipodoc t where d.iddocumento=dc.iddocumento and
                d.idareainstitu=a.idareainstitu and a.idarea=ae.idarea and dc.idpersona=p.idpersona and dc.idtipodoc=t.idtipodoc and idderivacion='$last'");
                $data = mysqli_fetch_assoc($consul);

                require_once("../public/assets/plugins/PHPMailer/clsMail.php");
                $mailSend = new clsMail();

                $bodyHTML = '<html>
                <head>
                    <title> Mensaje HTML </title>
                    <style>
                        body{
                            font-family: -apple-system, BlinkMacSystemFont, Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                        }
                        h1 {
                            font-size: 1.6rem;
                            padding: 12px;
                            color: #F4FA58;
                            margin: 0;
                        }
                
                        h2 {
                            font-size: 1.4rem;
                            margin: 0;
                            color: white;
                        }
                        #titu{
                            background-color: #096B87;
                            text-align: center;
                            height: 105px;
                        }
                        #table{
                            margin: 0 auto;
                            width: 60%;
                        }
                    </style>
                </head>
                
                <body>
                    <div id="titu">
                        <h1>HOSPITAL ANTONIO CALDAS DOMÍNGUEZ - POMABAMBA</h1>
                        <h2>MESA DE PARTES VIRTUAL</h2>
                    </div>
                    
                        <p>Estimado(a): <b>' . $nombres . ' ' . $appat . ' ' . $apmat . '</b></p><hr>
                        <p>Se le envía este email por parte de la <b>Mesa de Partes Virtual</b> del <b>Hospital Antonio Caldas Domínguez - Pomabamba.</b>
                            <br>Para informarle que su trámite a sido enviado por lo que se le da a conocer información del trámite recepcionado:
                        </p>
                        
                        
                        <div id="table">
                            <table width="100%" border="2" cellspacing="0" cellpadding="5" id="tableDoc">
                                <tr>
                                  <th colspan="2" style="text-align:center;color:red;font-size: 1.7rem;height: 50px;padding: 0;">
                                    DATOS DEL DOCUMENTO</th>
                                </tr>
                                <tr style="text-align:center;font-size:20px">
                                  <th style="width: 40%;">EXPEDIENTE</th>
                                  <td>' . $data['expediente'] . '</td>
                                </tr>
                                <tr style="text-align:center;font-size:20px">
                                  <th>N°. DOCUMENTO</th>
                                  <td>' . $data['nro'] . '</td>
                                </tr>
                                <tr style="text-align:center;font-size:20px">
                                  <th>TIPO</th>
                                  <td>' . $data['tipodoc'] . '</td>
                                </tr>
                                <tr style="text-align:center;font-size:18px">
                                  <th>REMITENTE</th>
                                  <td>' . $data['Datos'] . '</td>
                                </tr>
                                <tr style="text-align:center;font-size:18px">
                                  <th>FECHA</th>
                                  <td>' . $data['Fecha'] . '</td>
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
                </html>';

                $enviado =  $mailSend->metEnviar("MESA DE PARTES VIRTUAL - HACDP", "Usuario", "$correo", "TRÁMITE ENVIADO", $bodyHTML);



                print '<label><b>Expediente</b>&nbsp;: ' . $data['expediente'] . '</label><br>' .
                    '<label><b>Nro. Documento</b>&nbsp;: ' . $data['nro'] . '</label><br>' .
                    '<label><b>Tipo</b>&nbsp;: ' . $data['tipodoc'] . '</label><br>' .
                    '<label><b>Remitente</b>&nbsp;: ' . $data['Datos'] . '</label><br>' .
                    '<label><b>Fecha</b>&nbsp;: ' . $data['Fecha'] . '</label>';
            } else {
                print 'Error no se guardo en el historial';
            }
        } else {
            echo 'ERROR AL GUARDAR EL ARCHIVO';
        }

        break;
    case 3:
        // Consultar por Expediente
        $data = $tramite->consultarTramitexExpediente($expediente);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 4:
        // Consultar Tipos de Documentos
        $data = $tramite->consultarTipoDocs();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 5:
        // ELiminar por ID
        // $data = $area->eliminarAreaID($id_area);
        // echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 6:
        // Consultar usuarios que no son empleados
        // $data = $empleado->listarUsuariosPendientes();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 7:
        // Consultar usuarios que no son empleados
        // $data = $empleado->listarUsuariosPendientes();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 8:
        // Consultar usuarios que no son empleados
        // $data = $empleado->listarUsuariosPendientes();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 9:
        // Consultar usuarios que no son empleados
        // $data = $empleado->listarUsuariosPendientes();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 10:
        // Consultar usuarios que no son empleados
        // $data = $empleado->listarUsuariosPendientes();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 11:
        // Consultar usuarios que no son empleados
        // $data = $empleado->listarUsuariosPendientes();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    default:
        break;
}
