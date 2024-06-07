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
                                        <input type="text" class="form-control text-uppercase" name="inombre" id="inombrep" required >
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Apellido Paterno</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control text-uppercase" name="iappat" id="iappatp" required >
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Apellido Materno</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control text-uppercase" name="iapmat" id="iapmatp" required >
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
                                        <input type="text" class="form-control text-uppercase" name="idir" id="idirp" required >
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
        <div class="modal fade" id="mimodal" aria-modal="true" role="dialog">
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
                        <button type="button" class="btn btn1 btn-primary" onclick="salir()">Sí. Salir</button>
                    </div>
                </div>
            </div>
        </div>