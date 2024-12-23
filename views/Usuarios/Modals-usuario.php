<!-- MODAL USUARIO -->
<div class="modal fade" id="modal_user">
    <div class="modal-dialog modal-variant">
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
                        <div class="col-md-3">
                            <h1 class="modal-body-title mb-2">Foto de perfil
                                <span class="span-gray font-weight-normal"> (Opcional)</span>
                            </h1>
                            <figure class="modal-photo my-4" id="foto_perfilf">
                                <div class="overlay">
                                    <i class="fas fa-camera"></i>
                                    <span class="text ml-1">Elegir foto</span>
                                </div>
                            </figure>
                            <input type="file" class="input_foto" id="input_photo" name="foto" accept="image/jpeg, image/png">
                            <input type="hidden" name="bdr-photo" id="bdr-photo" value="0">
                        </div>
                        <div class="col-md-9">
                            <small class="p-nota text-muted mb-1">NOTA: Valide el DNI. Si existen coincidencias se completarán los datos y pueden ser editados</small>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row form-group">
                                        <div class="col-12">
                                            <label for="idni">DNI</label><span class="span-required"></span>
                                        </div>
                                        <div class="row col-12 pr-0">
                                            <div class="col">
                                                <input type="text" class="form-control text-uppercase" name="idni" id="idni" onkeypress='return validaNumericos(event)' maxlength="8" minlength="8" required placeholder="Ingrese DNI">
                                            </div>
                                            <div class="col-auto pr-0">
                                                <input id="validarDNI" type="button" class="btn btn-success" value="Validar DNI">
                                            </div>
                                        </div>
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
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="ipass">Contraseña</label>
                                            <span class="span-required"></span>
                                        </div>
                                        <div class="row col-12">
                                            <div class="col">
                                                <input type="password" class="form-control" name="ipass" id="ipass" minlength="8" required placeholder="Ingrese contraseña">
                                            </div>
                                            <div class="input-group-append col-auto px-0" title="Mostrar/Ocultar Contraseña">
                                                <button class="btn bg-gradient-light toggle-password" type="button">
                                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row form-group">
                                        <div class="col-12">
                                            <label for="ipassco">Confirmar Contraseña</label><span class="span-required"></span>
                                        </div>
                                        <div class="row col-12">
                                            <div class="col">
                                                <input type="password" class="form-control" name="ipassword" id="ipassco" minlength="8" required placeholder="Confirme contraseña">
                                            </div>
                                            <div class="input-group-append col-auto px-0" title="Mostrar/Ocultar Contraseña">
                                                <button class="btn bg-gradient-light toggle-password" type="button">
                                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                                </button>
                                            </div>
                                            <div class="col-12">
                                                <p id="ErrorContra" class="m-0 p-0 aviso"></p>
                                            </div>
                                        </div>
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
                    <div>
                        <button type="button" class="btn btn1 btn-info" id="limpiarUsuario">Limpiar</button>
                        <button type="submit" class="btn btn1 btn-primary" id="submitUsuario"></button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>