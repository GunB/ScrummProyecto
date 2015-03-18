<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class M_dailyscrum extends CI_Model {

    //var $sesion = null;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function obtener_ultimo_daily_scrum($iteracion_id, $estado_dailyscrum = null) {
        $input = array(
            'iteracion_id' => $iteracion_id,
        );
        if (!empty($estado_dailyscrum)) {
            $input['estado_daily_scrum_id'] = $estado_dailyscrum;
        }

        $this->db->distinct();
        $this->db->order_by("id", "desc");
        $query = $this->db->get_where('daily_scrum', $input);
        $resp = null;
        foreach ($query->result() as $row) {
            $resp = $row;
            break;
        }
        return $resp;
    }
    
    function obtener_dailyscrum($id_dailyscrum){
        $query = $this->db->get_where('daily_scrum', array('id' => $id_dailyscrum));
        $resp = null;
        foreach ($query->result() as $row) {
            ($resp = $row->id);
        }
        return $resp;
    }
    
    function obtener_dailyscrum_full($id_dailyscrum){
        $query = $this->db->get_where('daily_scrum', array('id' => $id_dailyscrum));
        $resp = null;
        foreach ($query->result() as $row) {
            ($resp = $row);
        }
        return $resp;
    }

    function obtener_tareas_dailyscrum($id_dailyscrum, $id_historia = null){
        //$this->db->select('tarea.id, tarea.nombre, tarea.tipo_tarea_id, tarea.historia_usuario_id, daily_scrum_has_tarea.*');
        $this->db->from('tarea, daily_scrum_has_tarea');
        $this->db->where('daily_scrum_has_tarea.tarea_id = tarea.id');
        $this->db->where(array('daily_scrum_has_tarea.daily_scrum_id' => $id_dailyscrum));
        if(!empty($id_historia)){
            $this->db->where(array('historia_usuario_id'=> $id_historia));
        }
        $query = $this->db->get();
        $resp = array();
        foreach ($query->result() as $row) {
            array_push($resp, $row);
        }
        //var_dump($this->db->last_query());
        return $resp;
    }

    function crear_daily_scrum($iteracion_id, $numero_daily_scrum, $estado_daily_scrum_id = 1) {
        $input = array(
            'id' => null,
            'dia' => $numero_daily_scrum,
            'detalles' => null,
            'iteracion_id' => $iteracion_id,
            'estado_daily_scrum_id' => $estado_daily_scrum_id
        );

        $this->db->insert('daily_scrum', $input);
        return $this->db->insert_id();
    }

    function asociar_historia_daily_scrum($historia_usuario, $daily_scrum, $estado_historia, $detalles = null) {
        $input = array(
            'id' => null,
            'detalles' => $detalles,
            'historia_usuario_id' => $historia_usuario,
            'estado_historia_id' => $estado_historia,
            'daily_scrum_id' => $daily_scrum
        );

        $this->db->insert('daily_scrum_has_historia_usuario', $input);
        return true;
    }

    function obtener_daily_scrums_iteraciones($iteraciones) {
        $resp = array();
        $this->db->from('daily_scrum');
        $this->db->where_in('iteracion_id', $iteraciones);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            array_push($resp, $row->id);
        }

        return $resp;
    }
    
    function obtener_dailyscrums_iteraciones($iteraciones) {
        $resp = array();
        $this->db->from('daily_scrum');
        $this->db->where_in('iteracion_id', $iteraciones);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            array_push($resp, $row);
        }

        return $resp;
    }

    function obtener_cantidad_daily_scrums_terminados($iditeracion) {
        $input = array(
            'iteracion_id' => $iditeracion,
            'estado_daily_scrum_id' => 2
        );
        $temp = 0;
        $query = $this->db->get_where('daily_scrum', $input);
        foreach ($query->result() as $row) {
            $temp++;
        }
        return $temp;
    }

    function consolidar_dailyscrum($dailyscrum, $historias) {
        $this->load->model('m_data');
        //$this->db->delete('daily_scrum_has_tarea', array('daily_scrum_id' => $dailyscrum->id));
        //$this->db->query("ALTER TABLE  `daily_scrum_has_tarea` AUTO_INCREMENT =1;");
        $id_historias = $this->m_data->get_only_atribute($historias, 'id');
        $this->db->select('id as "tarea_id", estado_tarea_id');
        $this->db->from('tarea');
        $this->db->where_in('historia_usuario_id', $id_historias);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $row->daily_scrum_id = $dailyscrum->id;
            $this->db->insert('daily_scrum_has_tarea', $row);
        }
    }

    function cambiar_estado_dailyscrum($id_dailyscrum, $estado_nuevo) {
        $data = array(
            'estado_daily_scrum_id' => $estado_nuevo
        );

        $this->db->where('id', $id_dailyscrum);
        $this->db->update('daily_scrum', $data);
    }

}

?>