<!-- MODAL DE ACEPTACION-->
<div class="modal fade" id="modal_aceptacion">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="modal-header">
                <h4 class="modal-title modal-title-h4" id="modal-title">ACEPTAR/RECHAZAR TRÁMITE</h4>
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
                                <input type="text" class="form-control input-form" id="inrodoc_1" readonly name="inrodoc">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>N° Folios </label>
                                <input type="number" class="form-control input-form" id="ifolio_1" readonly name="ifolio">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>N° Expediente </label>
                                <input type="text" class="form-control input-form" id="iexpediente_1" readonly name="iexpediente">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Estado </label>
                                <input type="text" class="form-control input-form" id="iestado_1" readonly name="iestado">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tipo</label>
                                <input type="text" class="form-control input-form" id="itipodoc_1" readonly name="itipodoc">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Asunto </label>
                                <textarea readonly class="form-control input-form" rows="3" id="iasunto_1" name="iasunto" style=" resize: none;"></textarea>
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

<!-- MODAL SEGUIMIENTO-->
<div class="modal fade" id="modal_historial">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="modal-header">
                <div class="d-flex align-items-center">
                    <h4 class="modal-title modal-title-h4 mr-2" id="modal-title">Seguimiento del Trámite: Expediente</h4>
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