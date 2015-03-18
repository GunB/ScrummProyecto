<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_tareas
 *
 * @author Heiner
 */
class M_tareas extends CI_Model {

    //var $sesion = null;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function agregar_tarea($tarea, $id_historia_usuario) {
        if(is_object($tarea)){
            $tarea = (array) $tarea;
        }
        //var_dump($tarea);
        $tarea['historia_usuario_id'] = $id_historia_usuario;
        $this->db->insert('tarea', $tarea);
        return $this->db->insert_id();
    }

    function eliminar_tarea($id_tarea) {
        $query = $this->db->get_where('tarea', array('id' => $id_tarea)); // verificar si no es un entregable
        if (!empty($query->num_rows)) {
            $this->db->delete('tarea', array('id' => $id_tarea));
            return true;
        } else {
            return false;
        }
    }

    function is_tarea_entregable_anteriormente_finalizada($id_historia_usuario) {
        $entregable = $this->get_tareas_historia($id_historia_usuario, 2);
        $search = $this->tarea_estado_primer_dailyscrum($entregable[0]->id, 3);
        return !empty($search);
    }

    function get_tareas_historia($id_historia, $tipo_tarea = null) {
        
        $this->db->from('historia_usuario');
        $this->db->from('tarea');
        $this->db->where('historia_usuario.id', $id_historia);
        $this->db->where('historia_usuario.id = tarea.historia_usuario_id');
        //$this->db->where('tarea.estado_tarea_id = estado_tarea.id');
        if (!empty($tipo_tarea)) {
            $this->db->where('tipo_tarea_id', $tipo_tarea);
        }
        $query = $this->db->get();
        $resp = array();
        foreach ($query->result() as $row) {
            array_push($resp, $row);
        }
        return $resp;
    }

    function get_tarea($id_tarea) {
        $this->db->from('tarea');
        $this->db->where('id', $id_tarea);
        $query = $this->db->get();
        //$resp = array();
        foreach ($query->result() as $row) {
            $resp = $row;
        }
        return $resp;
    }

    function cambiar_estado_tarea($id_tarea, $id_estado_nuevo) {
        $data = array(
            'estado_tarea_id' => $id_estado_nuevo
        );
        $this->db->where('id', $id_tarea);
        $this->db->update('tarea', $data);
    }

    public function tareas_incompletas_historia($id_historia, $array_tipo_tarea = array('1')) {
        $estados = array('1', '2');
        $this->db->from('tarea');
        $this->db->where('historia_usuario_id', $id_historia);
        $this->db->where_in('tipo_tarea_id', $array_tipo_tarea);
        $this->db->where_in('estado_tarea_id', $estados);
        $query = $this->db->get();
        $resp = array();
        foreach ($query->result() as $row) {
            array_push($resp, $row);
        }
        return $resp;
    }

    public function tareas_completas_historia($id_historia, $array_tipo_tarea = array('2')) {
        $estados = array('3');
        $this->db->from('tarea');
        $this->db->where('historia_usuario_id', $id_historia);
        $this->db->where_in('tipo_tarea_id', $array_tipo_tarea);
        $this->db->where_in('estado_tarea_id', $estados);
        $query = $this->db->get();
        $resp = array();
        foreach ($query->result() as $row) {
            array_push($resp, $row);
        }
        return $resp;
    }

    public function tarea_estado_primer_dailyscrum($id_tarea, $estado) {
        $search = array('tarea_id' => $id_tarea, 'estado_tarea_id' => $estado);
        $query = $this->db->get_where('daily_scrum_has_tarea', $search, 1);
        $resp = null;
        foreach ($query->result() as $row) {
            $resp = $row;
        }
        return $resp;
    }

}

?>
