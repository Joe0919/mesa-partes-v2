<!-- MODAL INGRESO Y EDICION DE AREAS-->
<div class="modal fade" id="modal_area">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_area" method="post">
                <div class="modal-header" id="modal-header">
                    <h4 class="modal-title modal-title-weight" id="modal-title-area">GESTION DE ÁREAS</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="id" id="idarea" value="0">

                    <div class="form-group">
                        <label for="inputName">Código</label><span class="span-red"> (*)</span>
                        <input type="text" class="form-control" name="icod" id="icodarea" 
                        onkeypress="return validaNumericos(event)" required>
                    </div>

                    <div class="form-group">
                        <label for="inputName">Área</label><span class="span-red"> (*)</span>
                        <input type="text" class="form-control text-uppercase" name="iarea" id="iarea" required>
                    </div>
                    <div class="form-group">
                        <label for="irol">Institución</label><span class="span-red"> (*)</span>
                        <!-- <a class="btn btn-flat bg-success btn-a1">...</a> -->
                        <select class="form-control select-inst" name="id_inst" id="inst" required></select>
                    </div>
                    <span class="span-red font-weight-normal">(*) Campos Obligatorios </span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn1 btn-primary" id="submitArea"></button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>