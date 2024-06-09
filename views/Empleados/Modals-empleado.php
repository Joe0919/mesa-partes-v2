<!-- MODAL INGRESO Y EDICION DE AREAS-->
<div class="modal fade" id="modal_empleado">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_empleado" method="post">
                <div class="modal-header" id="modal-header">
                    <h4 class="modal-title modal-title-weight" id="modal-title-area">GESTION DE EMPLEADOS:</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="id" id="idempleado" value="0">
                    <div id="div_users" class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="select-user">Usuarios Registrados Pendientes</label><span class="span-red"> (*)</span>
                                <select class="form-control select-inst" name="id_usu" id="select-user"></select>
                            </div>
                        </div>
                    </div>
                    <div class="div-info" id="Informacion">
                        <p class="p-info">Información del Usuario:</p>
                        <input type="hidden" class="form-control" name="idper" id="idperE">
                        <input type="hidden" class="form-control" name="idusu" id="idusuE">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="color-blue">DNI</label>
                                    <input type="text" class="form-control" name="idni" id="dniU" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="color-blue">NOMBRES</label>
                                    <input type="text" class="form-control" name="inom" id="nomU" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="color-blue">APELLIDO PATERNO</label>
                                    <input type="text" class="form-control" name="iappat" id="apU" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="color-blue">APELLIDO MATERNO</label>
                                    <input type="text" class="form-control" name="iapmat" id="amU" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="color-blue">CELULAR</label>
                                    <input type="text" class="form-control" name="icel" id="celU" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="color-blue">DIRECCIÓN</label>
                                    <input type="text" class="form-control" name="idir" id="dirU" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="codU">CÓDIGO</label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control" id="codEmpleado" name="codigo" onkeypress="return validaNumericos(event)" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="select-area">Área</label><span class="span-red"> (*)</span>
                                <select class="form-control select-inst" name="idareainst" id="select-area" required></select>
                            </div>
                        </div>
                    </div>
                    <span class="span-red font-weight-normal">(*) Campos Obligatorios </span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn1 btn-primary" id="submitEmpleado"></button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>