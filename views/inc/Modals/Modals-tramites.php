<!-- MODAL MAS INFORMACION DEL TRAMITE-->
<div class="modal fade" id="modalmas">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex flex-column flex-lg-row" id="modal-header">
                <h4 class="modal-title modal-title-h4" id="n_tramite"></h4>
                <div class="mt-2 mt-lg-0">
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
                                    <input type="text" class="form-control" id="inrodoc" readonly name="inrodoc">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>N° Folios </label>
                                    <input type="number" class="form-control" id="ifolio" readonly name="ifolio">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>N° Expediente </label>
                                    <input type="text" class="form-control" id="iexpediente" readonly name="iexpediente">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Estado </label>
                                    <input type="text" class="form-control" id="iestad" readonly name="iestad">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <input type="text" class="form-control" id="itipodoc" readonly name="itipodoc">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Asunto </label>
                                    <textarea readonly class="form-control" rows="4" id="iasunt" name="iasunt" style=" resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="div_remitente" style="display: none;">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>DNI </label>
                                    <input type="number" class="form-control" id="iddni1" readonly name="iddni1">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tipo de Persona: </label>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-radio">
                                                <input disabled class="custom-control-input" type="radio" id="radio_natural" name="natural" value="natural">
                                                <label for="radio_natural" class="custom-control-label">Natural</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
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
                                    <input type="text" class="form-control" id="iruc" readonly name="iruc">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Entidad </label>
                                    <input type="text" class="form-control" id="iinsti" readonly name="iinsti">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Apellidos y Nombres </label>
                                    <input type="text" class="form-control" id="idremi" readonly name="idremi">
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
                    <h4 class="modal-title modal-title-h4 mr-2" id="title_historial"></h4>
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
                            <th>Acción</th>
                            <th>Fecha</th>
                            <th>Área</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>


                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Acción</th>
                            <th>Fecha</th>
                            <th>Área</th>
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
                <button type="button" class="btn btn-primary" data-dismiss="modal" title="Cerrar la ventana">Cerrar</button>
                <div>
                    <button type="button" class="btn btn-success btnGestion" id="btnAceptarDoc" title="Aceptar el documento">Aceptar</button>
                    <div class="btn-group">
                        <button id="btnObservarRechazarDoc" type="button" class="btn btn-info btnGestion">Observar</button>
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Desplegar menú</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" data-action="Observar" data-color="info" data-value="0">Observar</a>
                            <a class="dropdown-item" data-action="Rechazar" data-color="danger" data-value="1">Rechazar</a>
                        </div>
                    </div>
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