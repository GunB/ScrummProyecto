<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class M_sesion extends CI_Model {

    //var $sesion = null;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function crear_sesion($id) {
        $newdata = array(
            'usuario' => $id
        );
        $this->session->set_userdata($newdata);
    }

    function obtener_sesion() {
        $temp = $this->session->userdata('usuario');
        //$temp = $this->session->all_userdata();
        return $temp;
    }

    function obtener_id_sesion() {
        $temp = $this->obtener_sesion()->id;
        return intval($temp);
    }

    function destruir_sesion() {
        $this->session->sess_destroy();
    }

    public function buscar_cuenta($correo) {
        $input = array(
            'correo' => $correo
        );

        $query = $this->db->get_where('usuario', $input);
        $result = array();
        foreach ($query->result() as $row) {
            array_push($result, $row);
        }
        return empty($result);
    }

    public function buscar_sesion($correo, $clave) {
        $input = array(
            'correo' => $correo,
            'clave' => $clave
        );
        $query = $this->db->get_where('usuario', $input);
        $result = array();
        foreach ($query->result() as $row) {
            array_push($result, $row);
        }

        if (empty($result)) {
            return null;
        } else {
            return $result[0];
        }
    }

    public function crear_cuenta($nombre, $correo, $clave) {
        if (($this->buscar_cuenta($correo))) {
            $input = array(
                'id' => null,
                'nombre' => $nombre,
                'correo' => $correo,
                'clave' => $clave
            );
            $this->db->insert('usuario', $input);
            return true;
        } else {
            return false;
        }
    }

    public function comprobar_sesion() {
        if (!$this->obtener_sesion()) {
            redirect("inicio/login");
        }
    }

}

?>