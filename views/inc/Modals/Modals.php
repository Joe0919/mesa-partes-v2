<!-- MODAL DATOS INSTITUCIÓN-->
<div class="modal fade" id="modal_inst">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_institucion" method="post">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-weight">DATOS DE LA INSTITUCIÓN:</h4>
                    <b id="idc" class="b-modal-info"></b>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <h1 class="modal-body-title mb-2">Logo Institución
                                <span class="span-required"></span>
                            </h1>
                            <figure class="modal-photo my-4" id="logo">
                                <div class="overlay">
                                    <i class="fas fa-camera"></i>
                                    <span class="text ml-1">Elegir foto</span>
                                </div>
                            </figure>
                            <input type="file" class="input_foto" id="input_logo" name="foto" accept="image/jpeg, image/png">
                            <input type="hidden" name="bdr_logo" id="bdr_logo" value="0">
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="idinstitucion" id="idinstitucion">
                                <label>RUC</label><span class="span-required"></span>
                                <input type="text" class="form-control" name="ruc" id="ruc" onkeypress='return validaNumericos(event)' maxlength="11" minlength="11" required>
                            </div>
                            <div class="form-group">
                                <label>Razón</label><span class="span-required"></span>
                                <input type="text" class="form-control text-uppercase" name="razon" id="razon" required>
                            </div>
                            <div class="form-group">
                                <label>Dirección</label><span class="span-required"></span>
                                <input type="text" class="form-control text-uppercase" name="instdirec" id="instdirec" required>
                                <b id="error3"></b>
                            </div>
                        </div>
                    </div>

                    <span class="span-red span-required-description"> Obligatorio </span>
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
<div class="modal fade" id="modal_EditUser">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_EditUser" method="post">
                <div class="modal-header" id="modal-header">
                    <h4 class="modal-title modal-title-weight" id="modal-title">DATOS DEL PERFIL DE USUARIO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idusuario" id="idusuarioP" value="0">
                    <input type="hidden" class="form-control" name="idpersona" id="idpersonaP" value="0">
                    <div class="row d-flex flex-row align-items-center">
                        <div class="col-sm-3">
                            <h1 class="modal-body-title mb-2">Foto de perfil
                                <span class="span-gray font-weight-normal"> (Opcional)</span>
                            </h1>
                            <figure class="modal-photo my-4" id="foto_perfilP">
                                <div class="overlay">
                                    <i class="fas fa-camera"></i>
                                    <span class="text ml-1">Elegir foto</span>
                                </div>
                            </figure>
                            <input type="file" class="input_foto" id="input_photoP" name="foto" accept="image/jpeg, image/png">
                            <input type="hidden" name="bdr-photo" id="bdr-photoP" value="0">
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>DNI</label><span class="span-required"></span>
                                        <input type="text" class="form-control text-uppercase" name="idni" id="idniP" maxlength="8" minlength="8" required readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nombres</label><span class="span-required"></span>
                                        <input type="text" class="form-control text-uppercase" name="inombre" id="inombreP" required placeholder="Ingrese nombres">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Apellido Paterno</label><span class="span-required"></span>
                                        <input type="text" class="form-control text-uppercase" name="iappat" id="iappatP" required placeholder="Ingrese apellido paterno">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Apellido Materno</label><span class="span-required"></span>
                                        <input type="text" class="form-control text-uppercase" name="iapmat" id="iapmatP" required placeholder="Ingrese apellido materno">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label><span class="span-required"></span>
                                        <input type="email" class="form-control" name="iemail" id="iemailP" required placeholder="Ingrese un email">
                                        <p id="ErrorEmailP" class="m-0 p-0 aviso"></p>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Dirección</label><span class="span-required"></span>
                                        <input type="text" class="form-control text-uppercase" name="idir" id="idirP" required placeholder="Ingrese dirección">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Celular</label><span class="span-required"></span>
                                        <input type="text" class="form-control" name="icel" id="icelP" required onkeypress='return validaNumericos(event)' maxlength="9" minlength="9" placeholder="Ingrese n° celular">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nombre Usuario</label><span class="span-required"></span>
                                        <input type="text" class="form-control" name="inomusu" id="inomusuP" required placeholder="Ingrese alias">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Rol</label><span class="span-required"></span>
                                        <input type="text" class="form-control" name="rol" id="rolP" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="span-red span-required-description"> Obligatorio </span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn1 btn-primary" id="submitEditUsuario">Guardar</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- MODAL CAMBIO DE CONTRASEÑA-->
<div class="modal fade" id="modal_edit_psw">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_edit_psw" method="post">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-weight tituloPsw"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="description"></div>
                        <p class="span-gray font-italic">IMPORTANTE: La nueva contraseña debe tener mas de 8 caracteres. Entre mayúsculas, minusculas, números y caracteres especiales (=?/&%$_)</p>
                        <input type="hidden" class="form-control" name="idusuario" id="idusuarioC">
                    </div>
                    <div class="form-group">
                        <label>Contraseña Actual<span class="span-required"></span></label>
                        <input type="password" class="form-control" name="ioldpassword" id="icontraU" required minlength="8" />
                    </div>
                    <div class="form-group">
                        <label>Contraseña Nueva<span class="span-required"></span></label>
                        <input type="password" class="form-control" name="ipassword" id="inewcontraU" required minlength="8" />
                    </div>
                    <div class="form-group">
                        <label>Confirmar nueva contraseña<span class="span-required"></span></label>
                        <input type="password" class="form-control" name="iconfirmpsw" id="iconfirmpswU" required minlength="8" />
                        <p id="ErrorContraU" class="m-0 p-0 aviso"></p>
                    </div>
                    <span class="span-red span-required-description"> Obligatorio </span>
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