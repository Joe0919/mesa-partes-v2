<!-- MODAL INGRESO Y EDICION DE AREAS-->
<div class="modal fade" id="modal_empleado">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_empleado" method="post">
                <div class="modal-header" id="modal-header">
                    <h4 class="modal-title modal-title-weight" id="modal-title-empleado"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idempleado" id="idempleado" value="0">
                    <div id="div_users" class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="select-user">Usuarios Registrados Pendientes</label><span class="span-required"></span>
                                <select class="form-control select-inst" name="id_usu" id="select_usuario"></select>
                            </div>
                        </div>
                    </div>
                    <div class="div-info" id="Informacion">
                        <p class="p-info">Información del Usuario:</p>
                        <input type="hidden" class="form-control" name="idpersona" id="idpersonaU">
                        <input type="hidden" class="form-control" name="idusuario" id="idusuarioU">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="color-blue">DNI</label>
                                    <input type="text" class="form-control" name="idni" id="dniU" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="color-blue">Nombres</label>
                                    <input type="text" class="form-control" name="inom" id="nomU" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="color-blue">Apellido Paterno</label>
                                    <input type="text" class="form-control" name="iappat" id="apU" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="color-blue">Apellido Materno</label>
                                    <input type="text" class="form-control" name="iapmat" id="amU" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="color-blue">N° Celular</label>
                                    <input type="text" class="form-control" name="icel" id="celU" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="color-blue">Dirección</label>
                                    <input type="text" class="form-control" name="idir" id="dirU" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="codU">Código</label><span class="span-required"></span>
                                <input type="text" class="form-control" id="codEmpleado" name="codigo" value="AUTOGENERADO" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="select-area">Área</label><span class="span-required"></span>
                                <select class="form-control select-inst" name="idarea" id="select_area" required></select>
                            </div>
                        </div>
                    </div>
                    <span class="span-red span-required-description"> Obligatorio </span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn1 btn-primary" id="submitEmpleado"></button>
                </div>
            </form>
        </div>
    </div>
</div>