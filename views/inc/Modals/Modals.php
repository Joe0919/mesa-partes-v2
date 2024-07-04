<!-- MODAL DATOS INSTITUCIÓN-->
<div class="modal fade" id="modalinstitu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-institucion" method="post">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-weight">DATOS DE LA INSTITUCIÓN:</h4>
                    <b id="idc" class="b-modal-info"></b>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="idinst" id="idinst">
                        <label>RUC <span class="span-red"> (*)</span></label>
                        <input type="text" class="form-control" name="iruci" id="iruci" onkeypress='return validaNumericos(event)' maxlength="11" minlength="11" required>
                    </div>
                    <div class="form-group">
                        <label>Razón <span class="span-red"> (*)</span></label>
                        <input type="text" class="form-control text-uppercase" name="irazoni" id="irazoni" required>
                    </div>
                    <div class="form-group">
                        <label>Dirección <span class="span-red"> (*)</span></label>
                        <input type="text" class="form-control text-uppercase" name="idirei" id="idirei" required>
                        <b id="error3"></b>
                    </div>
                    <span class="span-red font-weight-normal">(*) Campos Obligatorios </span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn1 btn-danger" data-dismiss="modal" id="SalirI">Cancelar </button>
                    <button type="submit" class="btn btn1 btn-primary" id="BtnEditInsti">Editar datos</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- MODAL EDICIÓN DE USUARIO-->
<div class="modal fade" id="modalUsu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formperfil" method="post">
                <div class="modal-header" id="modal-header">
                    <h4 class="modal-title modal-title-weight" id="modal-title">DATOS DEL PERFIL DEL USUARIO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idusu" id="idusup">
                    <input type="hidden" class="form-control" name="idper" id="idperp">
                    <input type="hidden" class="form-control" name="estado" id="estadop">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>DNI</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control" name="idni" id="idnip" onkeypress='return validaNumericos(event)' maxlength="8" minlength="8" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nombres</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control text-uppercase" name="inombre" id="inombrep" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Apellido Paterno</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control text-uppercase" name="iappat" id="iappatp" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Apellido Materno</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control text-uppercase" name="iapmat" id="iapmatp" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Celular</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control" name="icel" id="icelp" required onkeypress='return validaNumericos(event)' maxlength="9" minlength="9">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Dirección</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control text-uppercase" name="idir" id="idirp" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="iemail">Email</label><span class="span-red"> (*)</span>
                                <input type="email" class="form-control" name="iemail" id="iemailp" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nombre Usuario</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control" name="inomusu" id="inomusup" required>
                            </div>
                        </div>
                    </div>
                    <span class="span-red font-weight-normal">(*) Campos Obligatorios </span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="Actualizar">Actualizar Datos</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- MODAL FOTO-->
<div class="modal fade" id="modalfotop">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title modal-title-weight">ACTUALIZAR FOTO DE PERFIL:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="FormFotop" method="post">
                <div class="modal-body modal-body-center">
                    <h1 class="modal-body-title mb-2">Foto de perfil Actual</h1>
                    <figure class="modal-photo" id="foto_perfil">
                    </figure>
                    <div class="form-group">
                        <label>Elegir Foto (jpg)</label><span class="span-red"> (*)</span>
                        <div class="file-photo">
                            <input type="hidden" id="opcion" name="opcion" value='5'>
                            <input type="hidden" id="iddni2" name="idni" value="<?php echo $dni; ?>">
                            <input type="hidden" id="idusua2" name="idusu" value="<?php echo $iduser; ?>">
                            <input type="file" id="idfilep" name="idfile" required accept="image/jpeg">
                        </div>
                    </div>
                    <span class=" span-red font-weight-normal">(*) Campos Obligatorios </span>
                </div>
                <div class=" modal-footer justify-content-between">
                    <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">Cancelar </button>
                    <button type="submit" class="btn btn1 btn-primary" id="CambiarP">Cambiar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- MODAL CAMBIO DE CONTRASEÑA-->
<div class="modal fade" id="modaleditpswG">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-psw" method="post">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-weight">CAMBIO DE CONTRASEÑA:</h4>
                    <b id="idc" class="b-modal-info"></b>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p class="font-weight-normal span-gray">La nueva contraseña debe tener mas de 8 caracteres. Debe contener mayúsculas, minusculas, números y caracteres especiales (=?/&%$_)</p>
                    </div>
                    <div class="form-group">
                        <label>Contraseña Actual<span class="span-red"> (*)</span></label>
                        <input type="password" class="form-control" name="icontra" id="icontra" required minlength="8" />
                    </div>
                    <div class="form-group">
                        <label>Contraseña Nueva<span class="span-red"> (*)</span></label>
                        <input type="password" class="form-control" name="inewcontra" id="inewcontra" required minlength="8" />
                    </div>
                    <div class="form-group">
                        <label>Confirmar nueva contraseña<span class="span-red"> (*)</span></label>
                        <input type="password" class="form-control" name="iconfirmpsw" id="iconfirmpsw" required minlength="8" />
                        <p id="ErrorContraG" class="m-0 p-0"></p>
                    </div>
                    <span class="span-red font-weight-normal">(*) Campos Obligatorios </span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="SalirC">Cancelar </button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- MODAL CONFIRMACION CERRAR SESION -->
<div class="modal fade" id="modal_salir" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmación:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="font-weight-normal">¿Seguro que quiere cerrar la Sesión Actual?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">No. Continuar </button>
                <button type="button" class="btn btn1 btn-primary" onclick="window.location.href='<?= base_url(); ?>/Salir'">Sí. Salir</button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL MAS INFORMACION DEL TRAMITE-->
<div class="modal fade" id="modalmas">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="modal-header">
                <h4 class="modal-title modal-title-h4" id="modal-title">Datos del Trámite</h4>
                <div class=".col-md-4 .ms-auto">
                    <a id="btn_tramite" class="btn a-link btn-primary">Documento</a>
                    <a id="btn_remitente" class="btn a-link btn-light">Remitente</a>
                    <a id="btn_vistaprevia" class="btn a-link btn-light">Vista previa</a>
                </div>
            </div>
            <div class="modal-body">
                <form>
                    <div id="div_tramite" style="display: none;">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="iddoc" id="iddoc">

                                    <label>N° Documento </label>
                                    <input type="text" class="form-control input-form" id="inrodoc" disabled name="inrodoc">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>N° Folios </label>
                                    <input type="number" class="form-control input-form" id="ifolio" disabled name="ifolio">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>N° Expediente </label>
                                    <input type="text" class="form-control input-form" id="iexpediente" disabled name="iexpediente">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Estado </label>
                                    <input type="text" class="form-control input-form" id="iestad" disabled name="iestad">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <input type="text" class="form-control input-form" id="itipodoc" disabled name="itipodoc">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Asunto </label>
                                    <textarea disabled class="form-control input-form" rows="4" id="iasunt" name="iasunt" style=" resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="div_remitente" style="display: none;">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>DNI </label>
                                    <input type="number" class="form-control input-form" id="iddni1" disabled name="iddni1">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tipo de Persona: </label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="custom-control custom-radio">
                                                <input disabled class="custom-control-input" type="radio" id="radio_natural" name="natural" value="natural">
                                                <label for="radio_natural" class="custom-control-label">Natural</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="custom-control custom-radio">
                                                <input disabled class="custom-control-input" type="radio" id="radio_juridica" name="juridica" value="juridica">
                                                <label for="radio_juridica" class="custom-control-label">Jurídica</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>RUC </label>
                                    <input type="text" class="form-control input-form" id="iruc" disabled name="iruc">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Entidad </label>
                                    <input type="text" class="form-control input-form" id="iinsti" disabled name="iinsti">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Apellidos y Nombres </label>
                                    <input type="text" class="form-control input-form" id="idremi" disabled name="idremi">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="div_vistaprevia" class="div_vistaprevia">
                        <div id="div_iframePDF" class="w-100 h-100">
                            <iframe id="iframePDF" class="w-100 h-100" scrolling="no"></iframe>
                        </div>
                        <!-- <div id="loaderPDF" class="w-100 h-100">
                            <div class="w-100 h-100 d-flex justify-content-center align-items-center flex-column">
                                <span class="loader2 mb-1"></span>
                                <p class="text-light">Cargando Documento..</p>
                            </div>
                        </div>
                        <div id="error-message" class="w-100 h-100">
                            <p class="text-light">No se encontro el documento.</p>
                        </div> -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a target="_blank" class="btn btn-a2 bg-gradient-primary" id="btn_NuevoPDF">
                    <i class="nav-icon fas fa-file-pdf"></i>Abrir en nueva pestaña </a>
                <button type="button" class="btn btn1 btn-success" id="btnCerrarMas">Cerrar</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- MODAL SEGUIMIENTO-->
<div class="modal fade" id="modal_historial">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="modal-header">
                <div class="d-flex align-items-center">
                    <h4 class="modal-title modal-title-h4 mr-2" id="modal-title">Seguimiento del Trámite: Expediente
                    </h4>
                    <p id="p_expediente" class="p-descrip mb-0"></p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tablaSeguimiento" class="table table-hover table-data">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Ubic. Actual</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>


                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Ubic. Actual</th>
                            <th>Descripción</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn1 btn-success" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>