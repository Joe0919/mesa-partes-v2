<?php

class TramitesController extends Controllers
{
    private $personaModel;

    public function __construct()
    {
        parent::__construct("Tramite");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // session_regenerate_id(true); //# MEJORAR EL USO
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/acceso');
        }
        getPermisos(6);
    }
    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
        }

        $data['page_id'] = 7;
        $data['page_tag'] = "Trámites";
        $data['page_title'] = "Trámites";
        $data['file_js'] = "tramites.js";
        $this->views->getView("Tramites", "index", $data);
    }

    public function getTramites(string $idarea, string $area, string $estado)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $arrData = $this->model->selectTramites($idarea, $area, $estado);

            $estadoColors = [
                'PENDIENTE' => 'bg-black font-p',
                'ACEPTADO'  => 'bg-success font-p',
                'DERIVADO'  => 'bg-primary font-p',
                'RECHAZADO' => 'bg-danger font-p',
                'DEFAULT'   => 'bg-info font-p'
            ];

            foreach ($arrData as &$item) {
                $item['expediente'] = '<b>' . $item['expediente'] . '</b>';

                $colorClass = $estadoColors[$item['estado']] ?? $estadoColors['DEFAULT'];



                $item['Fecha'] = $this->getFechaBadge($item['Fecha']);

                $botones = '';

                if ($_SESSION['permisosMod']['upd']) {
                    switch ($item['estado']) {
                        case "PENDIENTE":
                            $botones .= '<button class="btn bg-gradient-success btn-sm btn-table btnAceptar" title="Aceptar/Rechazar"><i class="nav-icon fas fa-check"></i></button>';
                            break;
                        case "ACEPTADO":
                            $botones .= '<button class="btn bg-gradient-danger btn-sm btn-table btnDerivar" title="Derivar/Archivar"><i class="nav-icon fas fa-arrow-right"></i></button>';
                            break;
                    }
                }

                $btnView = '<button class="btn bg-gradient-info btn-sm btn-table btnMas" title="Más Información"><i class="nav-icon fas fa-eye"></i></button>';
                $btnHistory = '<button class="btn bg-gradient-secondary btn-sm btn-table btnSeguimiento" title="Ver Historial"><i class="nav-icon fas fa-search"></i></button>';

                $botones .= $btnView;
                $botones .= $btnHistory;

                $item['opciones'] = '<div class="text-center"><div class="btn-group">' . $botones . '</div></div>';

                $item['estado'] = '<span class="badge ' . $colorClass . '">' . $item['estado'] . '</span>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getTramite(string $expediente)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $Expediente = limpiarCadena($expediente);
            if ($Expediente != '') {
                $arrData = $this->model->selectTramite($Expediente, "");
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'title' => 'Error', 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'title' => 'ok', 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getHistorial(string $expediente)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $Expediente = limpiarCadena($expediente);

            $arrData = $this->model->selectHistorial($Expediente);
            for ($i = 0; $i < count($arrData); $i++) {

                $arrData[$i]['fecha'] = '<b>' . $arrData[$i]['fecha'] . '</b>';

                if ($arrData[$i]['accion'] == "PENDIENTE") {
                    $arrData[$i]['accion'] = '<span class="badge bg-black">' . $arrData[$i]['accion'] . '</span>';
                } else if ($arrData[$i]['accion'] == "ACEPTADO") {
                    $arrData[$i]['accion'] = '<span class="badge bg-success">' . $arrData[$i]['accion'] . '</span>';
                } elseif ($arrData[$i]['accion'] == "DERIVADO") {
                    $arrData[$i]['accion'] = '<span class="badge bg-primary">' . $arrData[$i]['accion'] . '</span>';
                } elseif ($arrData[$i]['accion'] == "RECHAZADO") {
                    $arrData[$i]['accion'] = '<span class="badge bg-danger">' . $arrData[$i]['accion'] . '</span>';
                } else {
                    $arrData[$i]['accion'] = '<span class="badge bg-warning">' . $arrData[$i]['accion'] . '</span>';
                }
            }

            $arrResponse = $arrData;

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getSelectTipo()
    {
        $arrData = $this->model->selectTipo();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function getSelectDestino()
    {
        if ($_POST) {

            $area = limpiarCadena($_POST['area']);

            $arrData = $this->model->selectAreaDestino($area);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    public function getFechas()
    {
        if ($_POST) {

            $opcion = limpiarCadena($_POST['opcion']);

            $anio =  isset($_POST['anio']) ? limpiarCadena($_POST['anio']) : '';


            switch ($opcion) {

                case 1:
                    $arrData = $this->model->selectAnios("date_format(fechad,'%Y')");
                    break;
                case 2:
                    if ($anio === '') {
                        $arrData = $this->model->selectAnios("date_format(fechad,'%m')");
                    } else {
                        $arrData = $this->model->selectAnios(
                            "date_format(fechad,'%m')",
                            "date_format(fechad,'%Y') = ?",
                            [$anio]
                        );
                    }
                    break;
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        } else {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    public function setTramite()
    {
        if ($_POST) {
            if (
                empty($_POST['idni']) ||
                empty($_POST['inombre']) ||
                empty($_POST['iappat']) ||
                empty($_POST['iapmat']) ||
                empty($_POST['iemail']) ||
                empty($_POST['idir']) ||
                empty($_POST['icel']) ||
                empty($_POST['itipo']) ||
                empty($_POST['n_doc']) ||
                empty($_POST['ifolios']) ||
                empty($_FILES['ifile'])
            ) {
                $arrResponse = array("status" => false, "title" => "Faltan Datos", "msg" => 'Completar todos los campos.');
            } else {
                $idpersona = limpiarCadena($_POST['idpersona']);
                $dni = limpiarCadena($_POST['idni']);
                $ruc = limpiarCadena($_POST['iruc']);
                $entidad = strtoupper(limpiarCadena($_POST['ientidad']));
                $dni = limpiarCadena($_POST['idni']);
                $nombres = strtoupper(limpiarCadena($_POST['inombre']));
                $appat = strtoupper(limpiarCadena($_POST['iappat']));
                $apmat = strtoupper(limpiarCadena($_POST['iapmat']));
                $email = limpiarCadena($_POST['iemail']);
                $direccion = strtoupper(limpiarCadena($_POST['idir']));
                $cel = limpiarCadena($_POST['icel']);
                $idtipo = intval(limpiarCadena($_POST['itipo']));
                $ndoc = limpiarCadena($_POST['n_doc']);
                $folios = intval(limpiarCadena($_POST['ifolios']));
                $asunto = limpiarCadena($_POST['iasunto']);
                $documento = $_FILES['ifile'];

                $request_persona = '';
                $ruta_pdf = "";

                if ($idpersona != "") {

                    $ruta_aux = UPLOADS_PATH . 'docs/'; // RAIZ/public/files/docs/
                    $rutaFecha = date('Y') . '/' . date('m') . '/' . date('d') . '/'; // 1/
                    $file_tmp_name = $documento['tmp_name'];

                    // Obtener el expediente
                    $expedienteData = $this->model->genExpediente();

                    // Acceder al número de expediente
                    $expediente = $expedienteData['Expediente'];

                    $nuevo_nombre = $ruta_aux . $rutaFecha . 'doc_' . $expediente . '_' . date('dmY') . '_' . $dni . '.pdf';

                    if (!file_exists($ruta_aux)) {
                        mkdir($ruta_aux, 0777, true);
                    }
                    if (!file_exists($ruta_aux . $rutaFecha)) {
                        mkdir($ruta_aux . $rutaFecha, 0777, true);
                    }

                    if (move_uploaded_file($file_tmp_name, $nuevo_nombre)) {
                        $ruta_pdf = 'files/docs/' . $rutaFecha . 'doc_' . $expediente . '_' . date('dmY') . '_' . $dni . '.pdf';

                        $this->personaModel = $this->loadAdditionalModel("Persona");

                        if ($idpersona == '0') {
                            $request_persona = $this->personaModel->insertPersona($dni, $appat, $apmat, $nombres, $email, $cel, $direccion, $ruc, $entidad);
                        } else {
                            $this->personaModel->editarPersona($email, $cel, $dni);
                            $request_persona = $idpersona;
                        }

                        if ($request_persona == 'exist') {
                            $arrResponse = array("status" => false, "title" => "Error", "msg" => 'Datos duplicados.');
                        } else {
                            $iddocumento = $this->model->registrarDocumento($expediente, $ndoc, $folios, $asunto, $ruta_pdf, $request_persona, $idtipo);
                            $this->model->registrarHistorial($expediente, $dni, 'INGRESO DE NUEVO TRÁMITE');

                            $this->model->registrarDerivacion($iddocumento, '', 'EXTERIOR', '8', 'DERIVANDO A SECRETARIA');

                            $arrData = $this->model->selectTramite($expediente, "");

                            $arrResponse = array('status' => true, 'title' => 'Trámite Registrado', "msg" => 'Su trámite se guardo con éxito.', 'data' => $arrData);
                        }
                    } else {
                        $arrResponse = array("status" => false, "title" => "Error", "msg" => 'No fue posible guardar el pdf.');
                    }
                } else {
                    $arrResponse = array("status" => false, "title" => "Error", "msg" => 'Falta el ID de la persona.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }
    public function putTramiteAceptacion()
    {
        if ($_POST) {
            $accion = limpiarCadena($_POST['accion']);
            $iddocumento = intval(limpiarCadena($_POST['iddocumento']));
            $idderivacion = intval(limpiarCadena($_POST['idderivacion']));
            $dni = limpiarCadena($_POST['dni']);
            $expediente = limpiarCadena($_POST['expediente']);
            $origen = strtoupper(limpiarCadena($_POST['origen']));
            $descripcion = strtoupper(limpiarCadena($_POST['descripcion']));
            $idusuario = intval(limpiarCadena($_POST['idusuario']));

            $request = '';

            // Controlar si se Acepta o Rechaza un Tramite
            if ($accion === 'ACEPTAR') {
                // Cambiamos el estado del documento a aceptado
                $request = $this->model->editarDocumento($expediente, 'ACEPTADO');
                // Guardamos la Aceptacion en el historial del doc
                $this->model->registrarHistorial($expediente, $dni, $descripcion, $idusuario, 'ACEPTADO', $origen);
                $arrResponse = array('status' => true, 'title' => 'Trámite Aceptado', "msg" => 'La acción se realizó con exito.', 'data' => $request);
            } else if ($accion === 'RECHAZAR') {
                // Validamos si en SECRETARIA se rechaza el tramite 
                if ($origen === 'SECRETARIA') {
                    // No es necesario Derivar a Secretaria, solo se rechaza
                    // Colocamos la descripcion por la que se esta Rechazando
                    $this->model->editarDerivacion($idderivacion, $descripcion);
                    // Guardamos el Rechazo en el historial del doc
                    $this->model->registrarHistorial($expediente, $dni, $descripcion, $idusuario, 'RECHAZADO', $origen);
                } else {
                    // Se cumple que es otra area
                    // Derivamos el Tramite a Secretaria sabiendo su ID
                    $this->model->registrarDerivacion($iddocumento, '', $origen, '8', $descripcion);
                    // Guardamos el Rechazo en el historial del doc
                    $this->model->registrarHistorial($expediente, $dni, $descripcion, $idusuario, 'RECHAZADO', $origen);
                    // Guardamos la Derivacion a SECRETARIA en el historial 
                    $this->model->registrarHistorial($expediente, $dni, $descripcion, $idusuario);
                }
                // Cambiamos el estado del documento a RECHAZADO
                $request = $this->model->editarDocumento($expediente, 'RECHAZADO');
                $arrResponse = array('status' => true, 'title' => 'Trámite Rechazado', "msg" => 'La acción se realizó con exito.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    public function putTramiteDerivacion()
    {
        if ($_POST) {
            $accion = limpiarCadena($_POST['accion']);
            $expediente = limpiarCadena($_POST['expediente']);
            $dni = limpiarCadena($_POST['dni']);
            $origen = strtoupper(limpiarCadena($_POST['origen']));
            $iddestino = isset($_POST['iddestino']) ? intval(limpiarCadena($_POST['iddestino'])) : '';
            $destino = limpiarCadena($_POST['destino']);
            $descripcion = strtoupper(limpiarCadena($_POST['descripcion']));
            $idusuario = intval(limpiarCadena($_POST['idusuario']));

            $request = '';

            if ($accion === '1') {
                // Derivamos el Tramite al Area Destino
                $this->model->registrarDerivacion(0, $expediente, $origen, $iddestino, $descripcion);
                // Cambiamos el estado  a PENDIENTE ya actualizamos la ubicacion del doc
                $this->model->editarDocumento($expediente, 'PENDIENTE', $iddestino);
                // Guardamos la Derivacion en el historial 
                $this->model->registrarHistorial($expediente, $dni, $descripcion, $idusuario, 'DERIVADO', $destino);
                $request = $accion . ' ' . $expediente . ' ' . $dni . ' ' . $origen . ' ' . $destino . ' ' . $descripcion;
                $arrResponse = array('status' => true, 'title' => 'Trámite Derivado', "msg" => 'La acción se realizó con exito.', 'data' => $request);
            } else if ($accion === '2') {
                // Cambiamos el estado  a ARCHIVADO ya actualizamos la ubicacion del doc
                $this->model->editarDocumento($expediente, 'ARCHIVADO');
                // Guardamos la Archivacion en el historial 
                $this->model->registrarHistorial($expediente, $dni, $descripcion, $idusuario, 'ARCHIVADO', $origen);
                $arrResponse = array('status' => true, 'title' => 'Trámite Archivado', "msg" => 'La acción se realizó con exito.', 'data' => $request);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }
    }
}


// switch ($opcion) {
//     case 1:
//         Consultar todos los datos
//         $data = $tramite->listarTramites();
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 2:
//         Crear nuevo registro y guardar archivo PDF

//         $a = "../../public/"; // Salir del directorio actual 

//         $ruta = "files/docs/"; // Prefijo de la ruta

//         $ruta_aux = $a . $ruta; //Unimos la ruta para verificar existencia

//         $expediente = $tramite->generarNroExpediente(); //Consulamos nuevo expediente para el nombre del doc

//         $file_tmp_name = $archivo['tmp_name'];  // Obtener archivo temporal del input
//         $new_name_file = $a . $ruta . $expediente . '_' . date('Y') . '_' . $dni . '.pdf'; // Crear nombre del doc
//         $nuevo = $ruta . $expediente . '_' . date('Y') . '_' . $dni . '.pdf'; //Nombre para el registro de la BD

//         Verificar si el directorio existe para crearlo
//         if (!file_exists($ruta_aux)) {
//             mkdir($ruta_aux);
//         }

//         Copiamos el archivo al directorio
//         if (move_uploaded_file($file_tmp_name, $new_name_file)) {

//             $data = $persona->verificarPersonaDNI($dni);

//             Si la persona no esta registrada
//             if ($data == 0) {
//                 Registramos a la persona nos devuelve el ID
//                 $idpersona = $persona->crearNuevaPersona($dni, $appat, $apmat, $nombres, $correo, $cel, $direc, $ruc, $entidad);
//             } else {
//                 Editamos datos de la persona  nos devuelve el ID
//                 $idpersona = $persona->editarPersona($correo, $cel, $direc, $idpersona);
//             }

//             $data = false;

//             Registramos el tramite y guardamos el ID registrado
//             $iddocumento = $tramite->registrarDatos("documento", "null,?,?,?,?,'PENDIENTE',?,?,?,'8'", [$expediente, $nrodoc, $folios, $asunto, $nuevo, $idpersona, $tipo]);
//             Registramos en el historial
//             $data = $tramite->registrarDatos("historial", "null,sysdate(),?,?,'DERIVADO','SECRETARÍA','INGRESO DE NUEVO TRÁMITE'", [$expediente, $dni]);

//             if ($data) {

//                 Registramos el registro en la tabla derivacion
//                 $ultimoID = $tramite->registrarDatos("derivacion", "null, sysdate(),'EXTERIOR','8',?,''", [$iddocumento]);
//                 Consultamos los datos del tramite registrado para enviar el email
//                 $data = $tramite->consultarTramitexExpediente(
//                     "idderivacion ID, nro_expediente,dc.iddocumento doc, nro_doc,folios, estado, tipodoc, asunto, dni,
//                     concat(nombres,' ',ap_paterno,' ',ap_materno) Datos, ruc_institu, institucion, area,
//                     date_format(fechad, '%d/%m/%Y') Fecha, descripcion",
//                     [$ultimoID],
//                     "idderivacion=?"
//                 );
//                 Importamos la clase PHPMailer
//                 require_once("../../vendor/phpmailer/phpmailer/src/clsMail.php");

//                 $enviarEmail = new clsMail();

//                 Creamos el cuerpo del EMAIL
//                 $bodyHTML = <<<HTML
//                     <html>
//                         <head>
//                             <title> Trámite Registrado</title>
//                             <style>
//                                 *{
//                                     padding:0;
//                                     margin:0;
//                                     box-sizing: content-box;
//                                 }
//                                 body{
//                                     font-family: -apple-system, BlinkMacSystemFont, Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
//                                 }
//                                 h1 {
//                                     font-size: 1.6rem;
//                                     padding: 12px;
//                                     color: #fff;
//                                     margin: 0;
//                                 }

//                                 h2 {
//                                     font-size: 1.4rem;
//                                     margin: 0;
//                                     color: yellow;
//                                 }
//                                 #titu{
//                                     background-color: #1f618d;
//                                     text-align: center;
//                                     height: 105px;
//                                 }
//                                 #table{
//                                     margin: 0 auto;
//                                     width: 60%;
//                                     max-width: 600px;
//                                 }
//                                 .title_table{
//                                     text-align:center;
//                                     color: white;	
//                                     font-size: 1.4rem;
//                                     height: 50px;
//                                     padding: 0;
//                                     background-color: #8c0505;
//                                     }
//                                 #tableDoc{
//                                     margin:16px 0;
//                                 }
//                                 #tableDoc tr{
//                                     text-align:center;
//                                     font-size:19px;
//                                 }
                                
//                                 #tableDoc td{
//                                     color: #063a6b;
//                                 }
//                                 .p_name{
//                                     margin: 10px 0;
//                                 }
//                             </style>
//                         </head>

//                         <body>
//                             <div id="titu">
//                                 <h1>HOSPITAL ANTONIO CALDAS DOMÍNGUEZ - POMABAMBA</h1>
//                                 <h2>MESA DE PARTES VIRTUAL</h2>
//                             </div>

//                             <p class="p_name">Estimado(a): <b>{ $nombres } { $appat } { $apmat }</b></p><hr>
//                             <p class="p_name">Se le envía este email por parte de la <b>Mesa de Partes Virtual</b> del <b>Hospital Antonio Caldas Domínguez - Pomabamba.</b>
//                             <br>Para informarle que su trámite a sido enviado por lo que se le da a conocer información del trámite recepcionado:
//                             </p>


//                             <div id="table">
//                                 <table width="100%" border="1" cellspacing="0" cellpadding="5" id="tableDoc">
//                                     <tr>
//                                         <th colspan="2" class="title_table">
//                                             DATOS DEL DOCUMENTO</th>
//                                     </tr>
//                                     <tr>
//                                         <th style="width: 40%;">EXPEDIENTE</th>
//                                         <td>{ $data[0]['nro_expediente'] }</td>
//                                     </tr>
//                                     <tr>
//                                         <th>N°. DOCUMENTO</th>
//                                         <td>{ $data[0]['nro_doc'] }</td>
//                                     </tr>
//                                     <tr>
//                                         <th>TIPO</th>
//                                         <td>{ $data[0]['tipodoc'] }</td>
//                                     </tr>
//                                     <tr>
//                                         <th>REMITENTE</th>
//                                         <td>{ $data[0]['Datos'] }</td>
//                                     </tr>
//                                     <tr>
//                                         <th>FECHA</th>
//                                         <td>{ $data[0]['Fecha'] }</td>
//                                     </tr>
//                                 </table>
//                             </div>

//                             <p>Puede realizar el seguimiento de su trámite puede ingresar a la plataforma de la <b>Mesa de Partes Virtual</b> en la pestaña <b><i>Seguimiento</i></b>
//                             <br>Saludos cordiales
//                             <br><b>HOSPITAL ANTONIO CALDAS DOMÍNGUEZ - POMABAMBA</b>
//                             </p>

//                             <p style="color: #094A8A;">_______________________________<br>
//                             <b>OFICINA DE SISTEMAS Y TELECOMUNICACIONES - HACDP</b> <br>
//                             <b>Contáctos:</b> 043-4510028<br>
//                             <b>Dirección:</b> Carretera Norte KM 1 S/N - Huajtchacra<br>
//                             <b>Plataforma Web:</b> 
//                             </p>
//                         </body>
//                     </html>
//                 HTML;

//                 Ejecutamos el envio de email
//                 $enviado =  $enviarEmail->metEnviar("MESA DE PARTES VIRTUAL - HACDP", "Usuario", "$correo", "TRÁMITE ENVIADO", $bodyHTML);

//                 Consultamos e imprimimos los datos del registro realizado
//                 $data = '<label><b>Expediente</b>&nbsp;: ' . $data[0]['nro_expediente'] . '</label><br>' .
//                     '<label><b>Nro. Documento</b>&nbsp;: ' . $data[0]['nro_doc'] . '</label><br>' .
//                     '<label><b>Tipo</b>&nbsp;: ' . $data[0]['tipodoc'] . '</label><br>' .
//                     '<label><b>Remitente</b>&nbsp;: ' . $data[0]['Datos'] . '</label><br>' .
//                     '<label><b>Fecha</b>&nbsp;: ' . $data[0]['Fecha'] . '</label>' .
//                     '<label><b>Fecha</b>&nbsp;: ' . $enviado . '</label>';
//             } else {
//                 $data = 'Error no se guardo en el historial';
//             }
//         } else {
//             $data = 'ERROR AL GUARDAR EL ARCHIVO';
//         }
//         echo $data;
//         break;
//     case 3:
//         Consultar por Expediente
//         $data = $tramite->consultarTramitexExpediente(
//             "idderivacion ID, nro_expediente,dc.iddocumento doc, nro_doc,folios,
//             estado, tipodoc, asunto, dni, concat(nombres,' ',ap_paterno,' ',ap_materno) Datos, ruc_institu, institucion, archivo, area, 
//             date_format(fechad, '%d/%m/%Y') Fecha, descripcion",
//             [$expediente],
//             "nro_expediente=?"
//         );
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 4:
//         Consultar Tipos de Documentos
//         $data = $tramite->consultarTabla("*", "tipodoc", "", []);
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 5:
//         Consultar todos los tramites del area
//         $data = $tramite->listarTramites("where area=? and estado=? and idubi=?", [$area, $estado, $idarea]);
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 6:
//         Controlar si se Acepta o Rechaza un Tramite
//         if ($accion === 'ACEPTAR') {
//             Cambiamos el estado del documento a aceptado
//             $tramite->editarDatos("documento", "estado = 'ACEPTADO'", [$id], "iddocumento = ?");
//             Guardamos la Aceptacion en el historial del doc
//             $data = $tramite->registrarDatos("historial", "null,sysdate(),?,?,'ACEPTADO',?,?", [$expediente, $dni, $origen, $descripcion]);
//         } else if ($accion === 'RECHAZAR') {

//             Validamos si en SECRETARIA se rechaza el tramite 
//             if ($origen === 'SECRETARIA') {
//                 No es necesario Derivar a Secretaria, solo se rechaza

//                 Colocamos la descripcion por la que se esta Rechazando
//                 $tramite->editarDatos("derivacion", "descripcion = ? ", [$descripcion, $idderivacion], "idderivacion = ?");

//                 Guardamos el Rechazo en el historial del doc
//                 $tramite->registrarDatos("historial", "null,sysdate(),?,?,'RECHAZADO',?,?", [$expediente, $dni, $origen, $descripcion]);
//             } else {
//                 Se cumple que es otra area

//                 Derivamos el Tramite a Secretaria
//                 $tramite->registrarDatos("derivacion", "null,sysdate(),?,(SELECT idarea from area where area='SECRETARIA'),?,?", [$origen, $id, $descripcion]);

//                 Guardamos el Rechazo en el historial del doc
//                 $tramite->registrarDatos("historial", "null,sysdate(),?,?,'RECHAZADO',?,?", [$expediente, $dni, $origen, $descripcion]);

//                 Guardamos la Derivacion a SECRETARIA en el historial 
//                 $tramite->registrarDatos("historial", "null,sysdate(),?,?,'DERIVADO','SECRETARIA',?", [$expediente, $dni, $descripcion]);
//             }
//             Cambiamos el estado del documento a RECHAZADO
//             $data = $tramite->editarDatos("documento", "estado = 'RECHAZADO'", [$id], "iddocumento = ?");
//         }
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 7:
//         Consultar Areas Destino
//         $data = $tramite->consultarTabla(
//             "ae.idareainstitu ID, cod_area, area",
//             "institucion i inner join areainstitu ae on ae.idinstitucion = i.idinstitucion inner join area a on a.idarea=ae.idarea",
//             "where area != ?",
//             [$area]
//         );
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 8:
//         Controlar si se Deriva o Archiva un Tramite
//         if ($accion === '1') {

//             Derivamos el Tramite al Area Destino
//             $tramite->registrarDatos("derivacion", "null,sysdate(),?,?,?,?", [$origen, $destino, $id, $descripcion]);

//             Cambiamos el estado  a PENDIENTE ya actualizamos la ubicacion del doc
//             $tramite->editarDatos("documento", "estado = 'PENDIENTE', idubi=?", [$destino, $id], "iddocumento = ?");

//             Guardamos la Derivacion en el historial 
//             $tramite->registrarDatos(
//                 "historial",
//                 "null,sysdate(),?,?,'DERIVADO',
//             (SELECT area from area a, areainstitu e where a.idarea=e.idarea and idareainstitu=?),?",
//                 [$expediente, $dni, $destino, $descripcion]
//             );
//             $data = "DERIVADO";
//         } else if ($accion === '2') {

//             Cambiamos el estado  a ARCHIVADO ya actualizamos la ubicacion del doc
//             $tramite->editarDatos("documento", "estado = 'ARCHIVADO'", [$id], "iddocumento = ?");

//             Guardamos la Archivacion en el historial 
//             $tramite->registrarDatos(
//                 "historial",
//                 "null,sysdate(),?,?,'ARCHIVADO',?,?",
//                 [$expediente, $dni, $origen, $descripcion]
//             );

//             $data = "Archivado";
//         }

//         echo json_encode($accion, JSON_UNESCAPED_UNICODE);
//         break;
//     case 9:
//         Consultar todos los tramites enviados desde el area
//         $data = $tramite->listarTramites("where origen=?", [$area]);
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 10:
//         Busqueda por Expediente, DNI y año
//         $data = $tramite->consultarTramitexExpediente(
//             "idderivacion ID, nro_expediente,dc.iddocumento doc, nro_doc,folios, estado, tipodoc, asunto, dni,
//             concat(nombres,' ',ap_paterno,' ',ap_materno) Datos, ruc_institu, institucion, archivo, area,
//             date_format(fechad, '%d/%m/%Y') Fecha, descripcion",
//             [$expediente, $anio, $dni],
//             "nro_expediente=? and date_format(fechad, '%Y')=? and dni=?"
//         );
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 11:
//         CONSULTAMOS LOS DATOS EN LA TABLA HISTORIAL
//         $resultado = $tramite->consultarTabla(
//             "idhistorial, accion, area, date_format(fecha, '%d/%m/%Y') fecha, time_format(fecha, '%H:%i:%s %p') hora, descrip",
//             "historial",
//             "where expediente=? and date_format(fecha, '%Y')=? and dni=?",
//             [$expediente, $anio, $dni]
//         );

//         EMPEZAMOS A DIBUJAR LA LINEA DE TIEMPO DEL TRAMITE
//         print <<<HTML
//                 <div class="timeline" id="div_historial">
//                     <div class="time-label">
//                         <span class="bg-red">HISTORIAL DEL TRÁMITE: </span>
//                     </div>
//                     <div class="time-label">
//                         <span class="bg-green">EXPEDIENTE <b>{$expediente}</b></span>
//                     </div>
//                 HTML;
//         VALIDAMOS EL ESTADO DEL TRAMITE PARA CONDICIONAR EL ICONO A DIBUJAR
//         foreach ($resultado as $data) {
//             switch ($data['accion']) {
//                 case 'DERIVADO':
//                     $icono = <<<HTML
//                             <i class="fas fa-arrow-circle-right bg-yellow"></i> 
//                          HTML;
//                     $preposicion = "a";
//                     break;
//                 case 'ACEPTADO':
//                     $icono = <<<HTML
//                             <i class="fas fa-check bg-green"></i> 
//                          HTML;
//                     $preposicion = "en";
//                     break;
//                 case 'RECHAZADO':
//                     $icono = <<<HTML
//                             <i class="fas fa-remove-format bg-red"></i>
//                          HTML;
//                     $preposicion = "en";
//                     break;
//                 case 'ARCHIVADO':
//                     $icono = <<<HTML
//                             <i class="fas fa-save bg-blue"></i> 
//                          HTML;
//                     $preposicion = "en";
//                     break;
//             }
//             AGREGAMOS EL ICONO AL CODIGO REPETIDO
//             print <<<HTML
//                     <div>
//                         {$icono}
//                         <div class="timeline-item">
//                             <span style="font-size:18px" class="time"><i class="fas fa-clock"></i> {$data['hora']}</span>
//                             <h3 style="font-size:18px" class="timeline-header">El trámite fue <b class="text-primary">{$data['accion']}</b> {$preposicion}
//                                 <b class="text-primary">{$data['area']}</b> el <b class="text-muted">{$data['fecha']}</b></h3>
//                             <div style="font-size:15px" class="timeline-body">
//                                 {$data['descrip']}
//                             </div>
//                         </div>
//                     </div>
//         HTML;
//         }
//         CERRAMOS EL DIV DE LA LINEA DE TIEMPO
//         print <<<HTML
//                 <div>
//                     <i class="fas fa-clock bg-gray"></i>
//                 </div>
//             </div>
//             HTML;
//         break;

//     case 12:
//         $data = $tramite->consultarTabla(
//             "distinct date_format(fechad,'%Y') dato",
//             "derivacion",
//         );
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 13:

//         if ($anio === '') {
//             $data = $tramite->consultarTabla(
//                 "distinct date_format(fechad,'%m') dato",
//                 "derivacion",
//             );
//         } else {
//             $data = $tramite->consultarTabla(
//                 "distinct date_format(fechad,'%m') dato",
//                 "derivacion",
//                 "where date_format(fechad,'%Y')=?",
//                 [$anio]
//             );
//         }

//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     default:
//         echo "OPCION NO VALIDA" . $opcion;
//         break;
// }