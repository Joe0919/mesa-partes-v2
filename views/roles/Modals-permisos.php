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
                                        <div class="toggle-flip">
                                            <label>
                                                <input type="checkbox" class="row-checkbox" title="Marcar Todo los permisos" <?= $rowCheck ?>><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                                            </label>
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
                                        <div class="toggle-flip">
                                            <label>
                                                <input type="checkbox" class="other_check" name="modulos[<?= $i; ?>][cre]" <?= $cCheck ?>><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-flip">
                                            <label>
                                                <input type="checkbox" class="other_check" name="modulos[<?= $i; ?>][rea]" <?= $rCheck ?>><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-flip">
                                            <label>
                                                <input type="checkbox" class="other_check" name="modulos[<?= $i; ?>][upd]" <?= $uCheck ?>><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="toggle-flip">
                                            <label>
                                                <input type="checkbox" class="other_check" name="modulos[<?= $i; ?>][del]" <?= $dCheck ?>><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                                            </label>
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