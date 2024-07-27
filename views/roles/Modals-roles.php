<!-- MODAL INGRESO Y EDICION DE ROLES-->
<div class="modal fade" id="modal_roles">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_roles" method="post">
                <div class="modal-header" id="modal-header">
                    <h4 class="modal-title modal-title-weight" id="modal-title-area"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idrol" id="idrol" value="0">
                    <div class="form-group">
                        <label>Rol</label><span class="span-required"></span>
                        <input type="text" class="form-control text-uppercase" name="irol" id="irol" placeholder="Ingrese el nombre del rol" required>
                    </div>
                    <div class="form-group">
                        <label>Descripción</label><span class="span-gray"> (Opcional)</span>
                        <textarea class="form-control text-uppercase" style="resize: none" rows="3" id="idescripcion" name="idescripcion" placeholder="Ingrese una descripcion"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inst">Estado</label><span class="span-required"></span>
                        <select class="form-control" name="estado" id="estado" required>
                            <option value="1">ACTIVO</option>
                            <option value="0">INACTIVO</option>
                        </select>
                    </div>
                    <span class="span-red span-required-description"> Obligatorio </span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn1 btn-primary" id="submitRol"></button>
                </div>
            </form>
        </div>
    </div>
</div>