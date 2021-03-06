<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Modelo RESTful
|--------------------------------------------------------------------------
|
| Esta es la plantilla de Ncai SpA para un modelo RESTful en Codeigniter.
| Esta plantilla contiene los métodos por defecto para realizar consultas a
| la base de datos. Utiliza la convención CRUD para hacerlo: create, read,
| update y delete.
|
|
*/

class Group extends CI_Model {

    ##########################
    # CONSTRUCTOR DEL MODELO #
    ##########################

    public function __construct() {
        parent::__construct();

    }
    
    ##############################
    # MÉTODOS BÁSICOS DEL MODELO #
    ##############################

    // Crea una entrada en la base de datos
    public function create(string $table = 'groups', array $data) {
        $data['created_at'] = time();
        $data['edited_at'] = time();
        $query = $this->db->insert($table, $data);
        return $query;
    }

    // Obtiene una o varias entradas desde la base de datos
    public function read(string $table = 'groups', array $data = NULL, bool $array = FALSE) {
        if (!$data) {
            $query = $this->db->get($table);
            return $query->result();
        } else {
            $query = $this->db->get_where($table, $data);
            if ($query->num_rows() == 0 ) {
                return false;
            } elseif ($query->num_rows() == 1 ) {
                if ($array) {
                    return $query->result();
                } else {
                    return $query->row();
                }
            } else {
                return $query->result();
            }
        }
    }

    // Actualiza una entrada en la base de datos
    public function update(string $table = 'groups', array $data, array $where) {
        $data['edited_at'] = time();
        $query = $this->db->update($table, $data, $where);
        return $query;
    }

    public function delete($table, array $where){
        $data['deleted_at'] = time();
        $data['is_deleted'] = 1;
        $query = $this->db->update($table, $data, $where);
        return $query;
    }

    // Elimina una entrada en la base de datos
    public function destroy($table = '', array $where) {     
        $query = $this->db->delete($table, $where);
        return $query;
    }

    ##################################
    # MÉTODOS ESPECÍFICOS DEL MODELO #
    ##################################

}