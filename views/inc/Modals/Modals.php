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
                    <div class="form-group row">
                        <div class="col-12">
                            <label>Contraseña Actual<span class="span-required"></span></label>
                        </div>
                        <div class="row col-12">
                            <div class="col">
                                <input type="password" class="form-control" name="ioldpassword" id="icontraU" required minlength="8" />
                            </div>
                            <div class="col-auto">
                                <div class="input-group-append col-auto px-0" title="Mostrar/Ocultar Contraseña">
                                    <button class="btn bg-gradient-light toggle-password" type="button">
                                        <i class="fas fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label>Contraseña Nueva</label><span class="span-required"></span>
                        </div>
                        <div class="row col-12">
                            <div class="col">
                                <input type="password" class="form-control" name="ipassword" id="inewcontraU" required minlength="8" />
                            </div>
                            <div class="col-auto">
                                <div class="input-group-append col-auto px-0" title="Mostrar/Ocultar Contraseña">
                                    <button class="btn bg-gradient-light toggle-password" type="button">
                                        <i class="fas fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label>Confirmar nueva contraseña<span class="span-required"></span></label>
                        </div>
                        <div class="row col-12">
                            <div class="col">
                                <input type="password" class="form-control" name="iconfirmpsw" id="iconfirmpswU" required minlength="8" />
                            </div>
                            <div class="col-auto">
                                <div class="input-group-append col-auto px-0" title="Mostrar/Ocultar Contraseña">
                                    <button class="btn bg-gradient-light toggle-password" type="button">
                                        <i class="fas fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">
                                <p id="ErrorContraU" class="m-0 p-0 aviso"></p>
                            </div>
                        </div>
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