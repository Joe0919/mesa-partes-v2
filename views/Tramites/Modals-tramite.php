<!-- MODAL MAS INFORMACION-->
<div class="modal fade" id="modalmas">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="modal-header">
                <h4 class="modal-title modal-title-h4" id="modal-title">Datos del Trámite</h4>
                <div class=".col-md-4 .ms-auto">
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

                                    <label>N° Documento </label><span class="span-red"> (*)</span>
                                    <input type="text" class="form-control input-form" id="inrodoc" disabled name="inrodoc">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>N° Folios </label><span class="span-red"> (*)</span>
                                    <input type="number" class="form-control input-form" id="ifolio" disabled name="ifolio">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>N° Expediente </label><span class="span-red"> (*)</span>
                                    <input type="text" class="form-control input-form" id="iexpediente" disabled name="iexpediente">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Estado </label><span class="span-red"> (*)</span>
                                    <input type="text" class="form-control input-form" id="iestad" disabled name="iestad">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tipo</label><span class="span-red"> (*)</span>
                                    <input type="text" class="form-control input-form" id="itipodoc" disabled name="itipodoc">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Asunto </label><span class="span-red"> (*)</span>
                                    <textarea disabled class="form-control input-form" rows="4" id="iasunt" name="iasunt" style=" resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="div_remitente" style="display: none;">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>DNI </label><span class="span-red"> (*)</span>
                                    <input type="number" class="form-control input-form" id="iddni1" disabled name="iddni1">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tipo de Persona: </label><span class="span-red"> (*)</span>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="custom-control custom-radio">
                                                <input disabled class="custom-control-input" type="radio" id="radio_natural" name="natural" value="natural">
                                                <label for="radio_natural" class="custom-control-label">Natural</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
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
                                    <label>RUC </label><span class="span-red"> (*)</span>
                                    <input type="text" class="form-control input-form" id="iruc" disabled name="iruc">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Entidad </label><span class="span-red"> (*)</span>
                                    <input type="text" class="form-control input-form" id="iinsti" disabled name="iinsti">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Apellidos y Nombres </label><span class="span-red"> (*)</span>
                                    <input type="text" class="form-control input-form" id="idremi" disabled name="idremi">
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