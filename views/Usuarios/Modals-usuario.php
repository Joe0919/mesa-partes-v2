<!-- MODAL FOTO-->
<!-- <div class="modal fade" id="modalfoto">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title modal-title-weight">ACTUALIZAR FOTO DE PERFIL:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="FormFoto" method="post">
                <div class="modal-body modal-body-center">
                    <h1 class="modal-body-title mb-2">Foto de perfil Actual</h1>
                    <figure class="modal-photo" id="foto_perfilf">
                    </figure>
                    <div class="form-group">
                        <label>Elegir Foto (jpg)</label><span class="span-red"> (*)</span>
                        <div class="file-photo">
                            <input type="hidden" id="opcionf" name="opcion" value='5'>
                            <input type="hidden" id="idnif" name="idni" value="">
                            <input type="hidden" id="idusuf" name="idusu" value="">
                            <input type="file" id="idfilef" name="idfile" required accept="image/jpeg">
                        </div>
                    </div>
                    <span class="span-red font-weight-normal">(*) Campos Obligatorios </span>
                </div>
                <div class=" modal-footer justify-content-between">
                    <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">Cancelar </button>
                    <button type="submit" class="btn btn1 btn-primary" id="Cambiar">Cambiar</button>
                </div>
            </form>
        </div>
    </div>
</div> -->
<!-- MODAL INGRESO DE USUARIO-->
<div class="modal fade" id="modal_new_user">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_new_user" method="post">
                <div class="modal-header" id="modal-header">
                    <h4 class="modal-title modal-title-weight" id="modal-title">INGRESE DATOS DEL USUARIO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <h1 class="modal-body-title mb-2">Foto de perfil Actual</h1>
                            <figure class="modal-photo" id="foto_perfilf">
                            </figure>
                            <div class="form-group">
                                <label>Elegir Foto (jpg)</label><span class="span-gray"> (Opcional)</span>
                                <div class="file-photo">
                                    <input type="hidden" id="opcionf" name="opcion" value='5'>
                                    <input type="hidden" id="idnif" name="idni" value="">
                                    <input type="file" id="idfilef" name="idfile" accept="image/jpeg">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="idni">DNI</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control" name="idni" id="idni" onkeypress='return validaNumericos(event)' maxlength="8" minlength="8" required>
                                        <p id="ErrorDNI" class="m-0 p-0 aviso"></p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inombre">Nombres</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control text-uppercase" name="inombre" id="inombre" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ippat">Apellido Paterno</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control text-uppercase" name="iappat" id="iappat" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="iapmat">Apellido Materno</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control text-uppercase" name="iapmat" id="iapmat" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="icel">Celular</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control" name="icel" id="icel" required onkeypress='return validaNumericos(event)' maxlength="9" minlength="9">
                                        <p id="ErrorCel" class="m-0 p-0 aviso"></p>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="idir">Dirección</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control text-uppercase" name="idir" id="idir" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="iemail">Email</label><span class="span-red"> (*)</span>
                                        <input type="email" class="form-control" name="iemail" id="iemail" required>
                                        <p id="ErrorEmail" class="m-0 p-0 aviso"></p>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inomusu">Nombre Usuario</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control" name="inomusu" id="inomusu" required>
                                        <p id="ErrorNomUsu" class="m-0 p-0 aviso"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="irol">Rol</label><span class="span-red"> (*)</span>
                                        <!-- <a class="btn btn-flat bg-success btn-a1">...</a> -->
                                        <select class="form-control select-rol" name="irol" id="irol" required></select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="ipass">Contraseña</label><span class="span-red"> (*)</span>
                                        <input type="password" class="form-control" name="ipass" id="ipass" minlength="8" required />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="ipassco">Confirmar Contraseña</label><span class="span-red"> (*)</span>
                                        <input type="password" class="form-control" name="ipassco" id="ipassco" minlength="8" required />
                                        <p id="ErrorContra" class="m-0 p-0 aviso"></p>
                                    </div>
                                </div>
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

<!-- MODAL EDICIÓN DE USUARIO-->
<div class="modal fade" id="modal_edit_user">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_edit_user" method="post">
                <div class="modal-header" id="modal-header">
                    <h4 class="modal-title modal-title-weight" id="modal-title">INGRESE DATOS DEL USUARIO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idusu" id="idusuE">
                    <input type="hidden" class="form-control" name="idper" id="idperE">
                    <input type="hidden" class="form-control" name="estado" id="estadoE">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="idni">DNI</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control" name="idni" id="idniE" readonly required>
                                <p id="ErrorDNI" class="m-0 p-0"></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inombre">Nombres</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control text-uppercase" name="inombre" id="inombreE" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ippat">Apellido Paterno</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control text-uppercase" name="iappat" id="iappatE" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="iapmat">Apellido Materno</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control text-uppercase" name="iapmat" id="iapmatE" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="icel">Celular</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control" name="icel" id="icelE" required onkeypress='return validaNumericos(event)' maxlength="9" minlength="9">
                                <p id="ErrorCel" class="m-0 p-0"></p>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="idir">Dirección</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control text-uppercase" name="idir" id="idirE" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="iemail">Email</label><span class="span-red"> (*)</span>
                                <input type="email" class="form-control" name="iemail" id="iemailE" required>
                                <p id="ErrorEmail" class="m-0 p-0"></p>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inomusu">Nombre Usuario</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control" name="inomusu" id="inomusuE" required>
                                <p id="ErrorNomUsu" class="m-0 p-0"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="irol">Rol</label><span class="span-red"> (*)</span>
                                <!-- <a class="btn btn-flat bg-success btn-a1">...</a> -->
                                <select class="form-control select-rol" name="irol" id="irolE" required></select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="estado">Estado de la Cuenta:</label>
                                <div class="custom-control custom-switch custom-switch-on-success mt-2">
                                    <input type="checkbox" class="custom-control-input" id="checkEstado">
                                    <label class="custom-control-label" id="label-estado" for="checkEstado"></label>
                                </div>
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

<!-- MODAL CAMBIO DE CONTRASEÑA-->
<div class="modal fade" id="modal_edit_psw">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_edit_psw" method="post">
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
                        <input type="hidden" class="form-control" name="idusu" id="idusuU">
                    </div>
                    <div class="form-group">
                        <label>Contraseña Actual<span class="span-red"> (*)</span></label>
                        <input type="password" class="form-control" name="icontra" id="icontraU" required minlength="8" />
                    </div>
                    <div class="form-group">
                        <label>Contraseña Nueva<span class="span-red"> (*)</span></label>
                        <input type="password" class="form-control" name="inewcontra" id="inewcontraU" required minlength="8" />
                    </div>
                    <div class="form-group">
                        <label>Confirmar nueva contraseña<span class="span-red"> (*)</span></label>
                        <input type="password" class="form-control" name="iconfirmpsw" id="iconfirmpswU" required minlength="8" />
                        <p id="ErrorContraU" class="m-0 p-0 aviso"></p>
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