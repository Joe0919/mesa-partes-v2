<!-- MODAL INGRESO Y EDICION DE AREAS-->
<div class="modal fade" id="modal_area">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_area" method="post">
                <div class="modal-header" id="modal-header">
                    <h4 class="modal-title modal-title-weight" id="modal-title-area"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idarea" id="idarea" value="0">

                    <div class="form-group">
                        <label for="inputName">Código</label><span class="span-required"></span>
                        <input type="text" class="form-control" name="icodigo" id="icodarea" readonly value="AUTOGENERADO">
                    </div>

                    <div class="form-group">
                        <label for="inputName">Área</label><span class="span-required"></span>
                        <input type="text" class="form-control text-uppercase" name="iarea" id="iarea" required placeholder="Ingrese nombre del Área">
                    </div>
                    <div class="form-group">
                        <label for="inst">Institución</label><span class="span-required"></span>
                        <select class="form-control select-inst" name="id_inst" id="select_inst" required></select>
                    </div>
                    <span class="span-red span-required-description"> Obligatorio </span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn1 btn-primary" id="submitArea"></button>
                </div>
            </form>
        </div>
    </div>
</div>