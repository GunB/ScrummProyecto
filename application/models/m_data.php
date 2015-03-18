<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class M_data extends CI_Model {

    //var $sesion = null;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_only_atribute($array, $atribute) {
        $array = (array) $array;
        $resp = array();
        foreach ($array as $value) {
            array_push($resp, $value->$atribute);
        }
        return $resp;
    }

    function get_all_post($unset = array()) {
        $post = array();
        foreach ($_POST as $key => $value) {
            $data = $this->input->post($key);
            if (!empty($data)) {
                $post[$key] = $data;
            }
        }

        foreach ($unset as $value) {
            if (isset($post[$value]))
                unset($post[$value]);
        }
        //$post = (object) $post;
        return $post;
    }

    function get_all_from_table_form($table_name) {
        $query = $this->db->get($table_name);
        $result = array();
        foreach ($query->result() as $row) {
            //array_push($result, $row);
            $result[$row->id] = $row->nombre;
        }
        //$result = (object) $result;
        return $result;
    }

    function crear_input($nombre_tabla, $data) {
        $fields = $this->db->list_fields($nombre_tabla);
        $input = array();
        foreach ($fields as $value) {
            if (isset($data[$value])) {
                $input[$value] = $data[$value];
                unset($data[$value]);
            } elseif ($value == 'usuario_id') {
                $input['usuario_id'] = $this->m_sesion->obtener_id_sesion();
            }
        }
        $input['detalles'] = json_encode($data);
        return $input;
    }

}

?>
