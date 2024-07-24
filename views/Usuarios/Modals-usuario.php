<!-- MODAL USUARIO -->
<div class="modal fade" id="modal_user">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_user" method="post">
                <div class="modal-header" id="modal-header">
                    <h4 class="modal-title modal-title-weight" id="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idusuario" id="idusuario" value="0">
                    <input type="hidden" class="form-control" name="idpersona" id="idpersona" value="0">
                    <input type="hidden" class="form-control" name="estado" id="iestado" value="INACTIVO">
                    <div class="row d-flex flex-row align-items-center">
                        <div class="col-sm-3">
                            <h1 class="modal-body-title mb-2">Foto de perfil
                                <span class="span-gray font-weight-normal"> (Opcional)</span>
                            </h1>
                            <figure class="modal-photo my-4" id="foto_perfilf">
                                <div class="overlay">
                                    <i class="fas fa-camera"></i>
                                    <span class="text ml-1">Elegir foto</span>
                                </div>
                            </figure>
                            <input type="file" id="input_photo" name="foto" accept="image/jpeg, image/png">
                            <input type="hidden" name="bdr-photo" id="bdr-photo" value="0">
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="idni">DNI</label><span class="span-required"></span>
                                        <input type="text" class="form-control text-uppercase" name="idni" id="idni" onkeypress='return validaNumericos(event)' maxlength="8" minlength="8" required placeholder="Ingrese DNI">
                                        <p id="ErrorDNI" class="m-0 p-0 aviso"></p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inombre">Nombres</label><span class="span-required"></span>
                                        <input type="text" class="form-control text-uppercase" name="inombre" id="inombre" required placeholder="Ingrese nombres">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ippat">Apellido Paterno</label><span class="span-required"></span>
                                        <input type="text" class="form-control text-uppercase" name="iappat" id="iappat" required placeholder="Ingrese apellido paterno">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="iapmat">Apellido Materno</label><span class="span-required"></span>
                                        <input type="text" class="form-control text-uppercase" name="iapmat" id="iapmat" required placeholder="Ingrese apellido materno">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="iemail">Email</label><span class="span-required"></span>
                                        <input type="email" class="form-control" name="iemail" id="iemail" required placeholder="Ingrese un email">
                                        <p id="ErrorEmail" class="m-0 p-0 aviso"></p>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="idir">Dirección</label><span class="span-required"></span>
                                        <input type="text" class="form-control text-uppercase" name="idir" id="idir" required placeholder="Ingrese dirección">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="icel">Celular</label><span class="span-required"></span>
                                        <input type="text" class="form-control" name="icel" id="icel" required onkeypress='return validaNumericos(event)' maxlength="9" minlength="9" placeholder="Ingrese n° celular">
                                        <p id="ErrorCel" class="m-0 p-0 aviso"></p>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inomusu">Nombre Usuario</label><span class="span-required"></span>
                                        <input type="text" class="form-control" name="inomusu" id="inomusu" required placeholder="Ingrese alias">
                                        <p id="ErrorNomUsu" class="m-0 p-0 aviso"></p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="irol">Rol</label><span class="span-required"></span>
                                        <select class="form-control select-rol" name="irol" id="select-rol" required></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="password-row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ipass">Contraseña</label><span class="span-required"></span>
                                        <input type="password" class="form-control" name="ipass" id="ipass" minlength="8" required placeholder="Ingrese contraseña">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ipassco">Confirmar Contraseña</label><span class="span-required"></span>
                                        <input type="password" class="form-control" name="ipassword" id="ipassco" minlength="8" required placeholder="Confirme contraseña">
                                        <p id="ErrorContra" class="m-0 p-0 aviso"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="estado-row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="estado">Estado de la Cuenta:</label>
                                        <div class="custom-control custom-switch custom-switch-on-success mt-2">
                                            <input type="checkbox" class="custom-control-input" name="checkEstado" id="checkEstado">
                                            <label class="custom-control-label" id="label-estado" for="checkEstado"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="span-red span-required-description"> Obligatorio </span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn1 btn-primary" id="submitUsuario"></button>
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
                    <h4 class="modal-title modal-title-weight">CAMBIO DE CONTRASEÑA:</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="description"></div>
                        <p class="span-gray font-italic">IMPORTANTE: La nueva contraseña debe tener mas de 8 caracteres. Entre mayúsculas, minusculas, números y caracteres especiales (=?/&%$_)</p>
                        <input type="hidden" class="form-control" name="idusuario" id="idusuarioP">
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