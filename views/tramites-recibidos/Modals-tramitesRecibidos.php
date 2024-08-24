<!-- MODAL DE ACEPTACION-->
<div class="modal fade" id="modal_aceptacion">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="modal-header">
                <h4 class="modal-title modal-title-h4" id="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_aceptacion">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="idderivacion" id="idderivacion">
                                <input type="hidden" class="form-control" name="iddocumento" id="iddocumento">
                                <input type="hidden" class="form-control" name="idni" id="idnir">
                                <label>N° Documento </label>
                                <input type="text" class="form-control" id="inrodoc_1" readonly name="inrodoc">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>N° Folios </label>
                                <input type="number" class="form-control" id="ifolio_1" readonly name="ifolio">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>N° Expediente </label>
                                <input type="text" class="form-control" id="iexpediente_1" readonly name="iexpediente">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Estado </label>
                                <input type="text" class="form-control" id="iestado_1" readonly name="iestado">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tipo</label>
                                <input type="text" class="form-control" id="itipodoc_1" readonly name="itipodoc">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Asunto </label>
                                <textarea readonly class="form-control" rows="3" id="iasunto_1" name="iasunto" style=" resize: none;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Descripción: </label><span class="span-gray">(Opcional)</span>
                                <textarea class="form-control text-uppercase" rows="3" id="idescripcion" name="idescripcion" placeholder="Ingrese la descripción..." style=" resize: none;"></textarea>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn1 btn-primary" data-dismiss="modal" title="Cerrar la ventana">Cerrar</button>
                <div>
                    <button type="button" class="btn btn1 btn-success btnGestion" id="btnAceptarDoc" title="Aceptar el documento">Aceptar</button>
                    <button type="button" class="btn btn1 btn-danger btnGestion" id="btnRechazarDoc" title="Rechazar el documento">Rechazar</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- MODAL DERIVACION-->
<div class="modal fade" id="modal_derivacion">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="modal-header">
                <div class="d-flex align-items-center">
                    <h4 class="modal-title modal-title-h4 mr-2" id="modal-title">Derivar o Archivar Trámite N°:
                    </h4>
                    <p id="p_expediente_d" class="p-descrip mb-0"></p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form_derivacion">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="expediente" id="expediente_d">
                                <input type="hidden" class="form-control" name="idni" id="dni_d">
                                <label>Fecha: </label><span class="span-red"> (*)</span>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input class="form-control input-date" readonly type="text" id="datepicker1" value="<?php echo date('d/m/Y') ?>">
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Acción: </label><span class="span-red"> (*)</span>
                                <select class="form-control select-new" name="accion" id="idaccion">
                                    <option value="1">DERIVAR</option>
                                    <option value="2">ARCHIVAR</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="column" class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Área Origen: </label><span class="span-red"> (*)</span>
                                <input type="text" class="form-control text-center" id="idorigen" readonly name="origen">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Área Destino: </label><span class="span-red"> (*)</span>
                                <select class="form-control select-tipo text-bold text-center" name="iddestino" id="select-destino"></select>
                            </div>
                        </div>
                    </div>
                    <div id="des1" class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Descripción: </label><span class="span-gray">(Opcional)</span>
                                <textarea class="form-control text-uppercase" rows="3" id="iddescripcion" name="descripcion" placeholder="Ingrese la descripción..." style="resize: none;"></textarea>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn1  btn-danger" data-dismiss="modal" onclick="limpiarderivacion()">Cancelar</button>
                    <button type="submit" class="btn btn1 btn-primary" id="btnEnviarDerivacion">Derivar</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>