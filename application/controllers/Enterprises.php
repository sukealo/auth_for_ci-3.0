<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Controlador de Empresas
|--------------------------------------------------------------------------
|
| Empresas es un Conjunto de usuarios que pertenecen a una organización, grupo
| de trabajo o asociación.
|
*/

class Enterprises extends CI_Controller {

    /**
     * Carga los modelos y previene el acceso de usuarios sin sesión iniciada.
     * @return type
     */
    public function __construct() {
        parent::__construct();
        // Cargar Modelo
        $this->load->model('Enterprise');
        $this->load->model('Group');
        $this->load->model('User');
        //Middleware
        $this->middleware->only_auth();
    }
    
    /**
     * Muestra una lista de todos los grupos
     * @return json html
     */
    public function index() {
        $this->middleware->only_permission(PERM['sadmin'], 'No tienes permiso para acceder a este recurso.', 'enterprises/show/'.$this->session->userdata('enterprises_id'));
        $data['enterprises'] = $this->Enterprise->read('enterprises',['is_deleted!=' =>  1],NULL,NULL,TRUE);
        $data['title'] = 'Listado de Empresa';
        $data['description'] = 'Aquí puedes ver un listado de todos las empresas inscritas en el sistema.';
        $this->middleware->renderview('enterprises/index', $data);
    }

    /**
     * Devuelve html con detalles de un grupo específico
     * @param int $id 
     * @return json html
     */
    public function show(int $id) {
        $user_enterprise_id = $this->session->userdata('enterprise_id');
        if ($this->session->userdata('permissions') & PERM['admin'] && $this->session->userdata('enterprise_id') !== $id) {
            redirect('enterprises/show/'.$user_enterprise_id);
        }
        $data['enterprise'] = $this->Enterprise->read('enterprises', ['id' => $id]);
        if (!$data['enterprise']) {
            $data['enterprise'] = $this->Enterprise->read('enterprises', ['id' => $user_enterprise_id]);;
        }
        $data['users'] = $this->User->read('users', ['users.enterprise_id' => $id],null,null, true);
        if (!$data['users']) {
            $data['users'] = [];
        }
        $data['title'] = $data['enterprise']->fakename;
        $data['description'] = 'Aquí puedes ver todos los detalles de esta empresa.';
        $this->middleware->renderview('enterprises/show', $data);
    }

    /**
     * Devuelve un html con un formulario para crear un grupo.
     * @return json html
     */
    public function add() {
        $this->middleware->onlyajax();
        $data['title'] = 'Nuevo Empresa';
        $data['description'] = 'Aquí puedes crear una nueva Empresa.';
        $this->middleware->renderview('enterprises/new', $data);
    }

    /**
     * Crea un nuevo grupo
     * @return redirect
     */
    public function create() {
        $this->middleware->onlyajax();
        // Valido los datos TODO: Do the validation in the create method
        $this->form_validation->set_rules('name', 'nombre', 'trim|required|min_length[1]|max_length[20]');
        $this->form_validation->set_rules('email', 'correo electrónico', 'trim|required|min_length[5]|max_length[40]|valid_email|is_unique[groups.email]');
        $this->form_validation->set_rules('token', 'token de acceso', 'trim|min_length[5]|max_length[50]');
        $this->form_validation->set_rules('max_members', 'número de miembros', 'required|trim|min_length[1]|max_length[5]');
        if(!$this->form_validation->run()) {
            $this->form_validation->set_error_delimiters("\n", '');
            $this->middleware->response(validation_errors(), 'error');
        } else {
            // Arreglo los datos
            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $data['token'] = $this->input->post('token');
            $data['max_members'] = $this->input->post('max_members');
            $data['is_active'] = 1;
            // Hago la query
            $query = $this->Group->create('groups', $data);
            // La respuesta
            if ($query) {
                $this->middleware->response('El nuevo grupo ha sido creado correctamente.', 'success', 'referer');
            } else {
                $this->middleware->response('Imposible crear el grupo. Intente más tarde.', 'error');
            }
        }
    }

   /**
    * Devuelve html con un formulario para editar un grupo
    * @param int $id 
    * @return json html
    */
    public function edit(int $id) {
        $this->middleware->onlyajax();
        $data['group'] = $this->Group->read('groups', ['id' => $id]);
        $this->middleware->renderview('groups/edit', $data);
    }

    /**
     * Actualiza los datos de un grupo
     * @param int $id 
     * @return redirect
     */
    public function update(int $id) {
        $this->middleware->onlyajax();
        $this->form_validation->set_rules('name', 'nombre', 'trim|required|min_length[1]|max_length[20]');
        $this->form_validation->set_rules('email', 'correo electrónico', 'trim|required|min_length[5]|max_length[40]|valid_email');
        $this->form_validation->set_rules('token', 'token de acceso', 'trim|min_length[5]|max_length[50]');
        $this->form_validation->set_rules('max_members', 'número de miembros', 'required|trim|min_length[1]|max_length[5]');
        if(!$this->form_validation->run()) {
            $this->form_validation->set_error_delimiters("\n", '');
            $this->middleware->response(validation_errors(), 'error');
        }
        // Arreglo los datos
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['token'] = $this->input->post('token');
        $data['max_members'] = $this->input->post('max_members');
        // Hago la query
        $query = $this->Group->update('groups', $data, ['id' => $id]);
        if ($query) {
            $this->middleware->response('El grupo ha sido editado correctamente.', 'success', 'referer');
        } else {
            $this->middleware->response('Inposible actualizar los datos. Intente más tarde.', 'error');
        }
    }

    /**
     * Elimina un grupo
     * @param int $id 
     * @return redirect
     */
    public function destroy(int $id) {
        $this->middleware->onlyajax();
        if ($this->session->userdata('enterprise_id') == $id) {
            $this->middleware->response('No puedes eliminar tu propio grupo.', 'error');
        }
        $query = $this->Group->delete('enterprises', ['id' => $id]);
        if (!$query) {
            $this->middleware->response('Imposible eliminar el grupo. Intente más tarde.', 'error');
        } else {
            $this->middleware->response('Grupo eliminado correctamente', 'success', 'referer');
        }
    }

 /*
 |--------------------------------------------------------------------------
 | GRUPOS - Métodos Específicos
 |--------------------------------------------------------------------------
 | Estos métodos específicos son propios de la clase y se alejan del CRUD
 | básico. Por ejemplo, existe la opción para bloquear o desbloquear un 
 | grupo, o de cambiar su imagen corporativa.
 |
 */

    /**
     * Bloquea un grupo
     * @param int $id 
     * @return redirect
     */
    public function lock(int $id) {
        $this->middleware->onlyajax();
        $this->middleware->only_permission(PERM['sadmin'],'No tienes los permisos suficientes para realizar esta acción.');
        // Que no se bloquee a sí mismo
        if ($this->session->userdata('group_id') == $id) {
            $this->middleware->response('No puedes bloquear tu propio grupo.', 'error');
        }
        $data['is_active'] = 0;
        $query = $this->Group->update('groups', $data, ['id' => $id]);
        if (!$query) {
            $this->middleware->response('Imposible bloquear el grupo. Intente más tarde.', 'error');
        } else {
            $this->middleware->response('El grupo ha sido bloqueado exitosamente.', 'success', 'referer');
        }
    }

    /**
     * Desbloquea un grupo
     * @param int $id 
     * @return string or json
     */
    public function unlock(int $id) {
        $this->middleware->onlyajax();
        $this->middleware->only_permission(PERM['sadmin'],'No tienes los permisos suficientes para realizar esta acción.');
        $data['is_active'] = 1;
        $query = $this->Group->update('groups', $data, ['id' => $id]);
        if (!$query) {
            $this->middleware->response('Imposible desbloquar el grupo. Intente más tarde.', 'error');
        } else {
            $this->middleware->response('El grupo ha sido desbloqueado exitosamente.', 'success', 'referer');
        }
    }

    public function change_profile_picture($id){
        // TODO: Mejorar respuesta del método de cambio de imagen.
        $this->middleware->onlyajax();
        $data = $this->input->post('image');
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        $imageName = sha1(time().rand(1000,9000)).'.png';
        $this->Enterprise->update('enterprises', ['logo_url' => $imageName], ['id' => $id]);
        file_put_contents('assets/img/logos/'.$imageName, $data);
    }

}