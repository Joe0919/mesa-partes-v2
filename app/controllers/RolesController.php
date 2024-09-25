<?php
class RolesController extends Controllers
{
    public function __construct()
    {
        parent::__construct("Roles");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/acceso');
            exit();
        }
        getPermisos(3);
    }

    // Método para cargar la vista de roles
    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
            exit();
        }
        $data = [
            'page_id' => 4,
            'page_tag' => "Roles Usuario",
            'page_title' => "Roles Usuario",
            'file_js' => "roles.js"
        ];
        $this->views->getView("Roles", "index", $data);
    }

    // Método para obtener roles
    public function getRoles()
    {
        if ($_SESSION['permisosMod']['rea']) {
            $arrData = $this->model->selectRoles();
            foreach ($arrData as &$role) {
                $role['estado'] = $role['estado'] == 1
                    ? '<span class="badge bg-success">ACTIVO</span>'
                    : '<span class="badge bg-secondary">INACTIVO</span>';
                $role['opciones'] = $this->generateRoleOptions();
                $role['asociados'] = '<h5 class="mb-0" title="Número de datos asociados"><span class="badge badge-pill badge-warning">' . $role['asociados'] . '</span></h5>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // Método para generar opciones de botones para los roles
    private function generateRoleOptions()
    {
        $btnPermisos = $_SESSION['permisosMod']['upd']
            ? '<button class="btn btn-secondary btn-sm btn-table btnPermisos" title="Ver Permisos"><i class="nav-icon fas fa-key"></i></button>'
            : '';
        $btnEditar = $_SESSION['permisosMod']['upd']
            ? '<button class="btn btn-primary btn-sm btn-table btnEditar" title="Editar"><i class="nav-icon fas fa-edit"></i></button>'
            : '';
        $btnBorrar = $_SESSION['permisosMod']['del']
            ? '<button class="btn btn-danger btn-sm btn-table btnBorrar" title="Eliminar"><i class="nav-icon fas fa-trash"></i></button>'
            : '';

        return '<div class="text-center"><div class="btn-group">' . $btnPermisos . ' ' . $btnEditar . ' ' . $btnBorrar . '</div></div>';
    }

    // Método para obtener los roles en un select
    public function getSelectRoles()
    {
        $arrData = $this->model->selectRoles();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para crear o actualizar un rol
    public function setRol()
    {
        $intIdrol = intval(limpiarCadena($_POST['idrol']));
        $strRol = strtoupper(limpiarCadena($_POST['irol']));
        $strDescipcion = strtoupper(limpiarCadena($_POST['idescripcion']));
        $intEstado = intval(limpiarCadena($_POST['estado']));

        $request_rol = $this->handleRoleRequest($intIdrol, $strRol, $strDescipcion, $intEstado);
        echo json_encode($request_rol, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para manejar la creación o actualización de roles
    private function handleRoleRequest($intIdrol, $strRol, $strDescipcion, $intEstado)
    {
        if ($intIdrol == 0) {
            return $this->createRole($strRol, $strDescipcion, $intEstado);
        } else {
            return $this->updateRole($intIdrol, $strRol, $strDescipcion, $intEstado);
        }
    }

    // Método para crear un rol
    private function createRole($strRol, $strDescipcion, $intEstado)
    {
        if ($_SESSION['permisosMod']['cre']) {
            $request_rol = $this->model->insertRol($strRol, $strDescipcion, $intEstado);
            return $this->generateResponse($request_rol, 1);
        }
        return $this->responseDenegado();
    }

    // Método para actualizar un rol
    private function updateRole($intIdrol, $strRol, $strDescipcion, $intEstado)
    {
        if ($_SESSION['permisosMod']['upd']) {
            $request_rol = $this->model->editarRol($intIdrol, $strRol, $strDescipcion, $intEstado);
            return $this->generateResponse($request_rol, 2);
        }
        return $this->responseDenegado();
    }

    // Método para generar una respuesta basada en el resultado de la operación
    private function generateResponse($request_rol, $option)
    {
        if ($request_rol == 'exist') {
            return ['status' => false, 'title' => 'Datos duplicados', 'msg' => 'El Rol ya existe.'];
        } elseif ($request_rol > 0) {
            return [
                'status' => true,
                'title' => $option == 1 ? 'Registrado' : 'Actualizado',
                'msg' => 'Datos ' . ($option == 1 ? 'guardados' : 'actualizados') . ' correctamente.',
                'results' => $request_rol
            ];
        } else {
            return ['status' => false, 'title' => 'Error', 'msg' => 'No es posible almacenar los datos.'];
        }
    }

    // Método para obtener un rol específico
    public function getRol(int $idrol)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $intIdrol = intval(limpiarCadena($idrol));
            if ($intIdrol > 0) {
                $arrData = $this->model->selectRol($intIdrol);
                $arrResponse = empty($arrData)
                    ? ['status' => false, 'title' => 'Error', 'msg' => 'Datos no encontrados.']
                    : ['status' => true, 'title' => 'ok', 'data' => $arrData];
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode($this->responseDenegado(), JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // Método para eliminar un rol
    public function delRol()
    {
        if ($_POST && $_SESSION['permisosMod']['del']) {
            $intIdrol = intval(limpiarCadena($_POST['idrol']));
            $requestDelete = $this->model->eliminarRol($intIdrol);
            $arrResponse = $this->handleDeleteResponse($requestDelete);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($this->responseDenegado(), JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // Método para manejar la respuesta de eliminación
    private function handleDeleteResponse($requestDelete)
    {
        if ($requestDelete == 1) {
            return ['status' => true, 'title' => 'Eliminado', 'msg' => 'Se ha eliminado el Rol'];
        } elseif ($requestDelete == 'exist') {
            return ['status' => false, 'title' => 'Rol asociado', 'msg' => 'No es posible eliminar un Rol asociado a usuarios.'];
        } else {
            return ['status' => false, 'title' => 'Error', 'msg' => 'Error al eliminar el Rol.'];
        }
    }
}
