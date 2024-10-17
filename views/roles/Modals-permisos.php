<!-- MODAL MODULOS Y PERMISOS-->
<div class="modal fade" id="modal_permisos">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="modal-header">
                <div class="d-flex align-items-center">
                    <h4 class="modal-title modal-title-h4 mr-2" id="modal-title">PERMISOS DEL ROL:
                        <span id="span_rol" class="p-descrip mb-0"></span>
                    </h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body py-0">
                <form id="form_permisos" action="">
                    <input type="hidden" id="idrol" name="idrol" value="<?= $data['idrol']; ?>" required>
                    <table id="tablaPermisos" class="table table-hover table-data">
                        <thead>
                            <tr>
                                <th>Todo</th>
                                <th>#</th>
                                <th>Módulo</th>
                                <th>Crear</th>
                                <th>Ver</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $modulos = $data['modulos'];
                            for ($i = 0; $i < count($modulos); $i++) {
                                $permisos = $modulos[$i]['permisos'];
                                $cCheck = $permisos['cre'] == 1 ? " checked " : "";
                                $rCheck = $permisos['rea'] == 1 ? " checked " : "";
                                $uCheck = $permisos['upd'] == 1 ? " checked " : "";
                                $dCheck = $permisos['del'] == 1 ? " checked " : "";
                                ($cCheck == "" || $rCheck == "" || $uCheck == "" || $dCheck == "") ? $rowCheck = "" : $rowCheck = " checked";
                                $idmod = $modulos[$i]['idmodulo'];
                            ?>
                                <tr>
                                    <td title="Marcar Todo los permisos">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input row-checkbox custom-control-input custom-control-input-info" id="rowCheck<?= $i ?>" title="Marcar Todo los permisos" <?= $rowCheck ?>>
                                            <label class="custom-control-label" for="rowCheck<?= $i ?>"> </label>
                                        </div>
                                    </td>
                                    <td>
                                        <?= $no; ?>
                                        <input type="hidden" name="modulos[<?= $i; ?>][idmodulo]" value="<?= $idmod ?>" required>
                                    </td>
                                    <td>
                                        <?= $modulos[$i]['titulo']; ?>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input other_check custom-control-input custom-control-input-info" name="modulos[<?= $i; ?>][cre]" id="creCheck<?= $i ?>" <?= $cCheck ?>>
                                            <label class="custom-control-label" for="creCheck<?= $i ?>"> </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input other_check custom-control-input custom-control-input-info" name="modulos[<?= $i; ?>][rea]" id="reaCheck<?= $i ?>" <?= $rCheck ?>>
                                            <label class="custom-control-label" for="reaCheck<?= $i ?>"> </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input other_check custom-control-input custom-control-input-info" name="modulos[<?= $i; ?>][upd]" id="updCheck<?= $i ?>" <?= $uCheck ?>>
                                            <label class="custom-control-label" for="updCheck<?= $i ?>"> </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input other_check custom-control-input custom-control-input-info" name="modulos[<?= $i; ?>][del]" id="delCheck<?= $i ?>" <?= $dCheck ?>>
                                            <label class="custom-control-label" for="delCheck<?= $i ?>"> </label>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn1 btn-success" id="submitPermisos">Guardar</button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>