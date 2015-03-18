<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class M_iteracion extends CI_Model {

    //var $sesion = null;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function obtener_id_numero_iteracion_proyecto($numero_iteracion, $proyecto) {
        $input = array(
            'numero' => $numero_iteracion,
            'proyecto_id' => $proyecto
        );

        $query = $this->db->get_where('iteracion', $input);
        $id = null;
        $resp = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                array_push($resp, $row);
            }
            $id = $resp[0]->id;
        }

        return $id;
    }

    function obtener_iteracion($id_iteracion) {
        $query = $this->db->get_where('iteracion', array('id' => $id_iteracion));
        $resp = null;
        foreach ($query->result() as $row) {
            ($resp = $row->id);
        }
        return $resp;
    }

    function obtener_iteracion_full($id_iteracion) {
        $query = $this->db->get_where('iteracion', array('id' => $id_iteracion));
        $resp = null;
        foreach ($query->result() as $row) {
            ($resp = $row);
        }
        return $resp;
    }
    
    function obtener_id_iteraciones_proyecto($proyecto) {
        $input = array(
            'proyecto_id' => $proyecto
        );

        $query = $this->db->get_where('iteracion', $input);
        $resp = array(-1);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                array_push($resp, $row->id);
            }
        }

        return $resp;
    }

    function obtener_iteraciones_proyecto($proyecto) {
        $query = $this->db->get_where('iteracion', array('proyecto_id' => $proyecto));
        $resp = array();
        foreach ($query->result() as $row) {
            array_push($resp, $row);
        }
        return $resp;
    }

    function obtener_ultima_iteracion($idproyecto) {
        $input = array(
            'proyecto_id' => $idproyecto
        );

        $this->db->order_by("id", "desc");
        $query = $this->db->get_where('iteracion', $input);
        $resp = null;
        foreach ($query->result() as $row) {
            $resp = $row;
            break;
        }
        return $resp;
    }

    function obtener_ultimo_estado_iteracion($id) {
        $input = array(
            'iteracion_id' => $id
        );

        $this->db->order_by("id", "desc");
        $query = $this->db->get_where('iteracion_has_estado_iteracion', $input, 1);
        $resp = null;
        foreach ($query->result() as $row) {
            $resp = $row->estado_iteracion_id;
        }
        return $resp;
    }

    function cambiar_estado_iteracion_actual($id, $estado) {
        $data = array(
            'id' => null,
            'iteracion_id' => $id,
            'estado_iteracion_id' => $estado
        );
        $this->db->insert('iteracion_has_estado_iteracion', $data);
    }

    public function crear_iteracion($proyecto, $numero, $meta = null, $fecha_entregable = null, $lugar_dscrum = null, $hora_dscrum = null, $tipo_iteracion = 1) {
        $input = array(
            'id' => null,
            'numero' => $numero,
            'meta' => $meta,
            'fecha_entregable' => $fecha_entregable,
            'lugar_daily_scrum' => $lugar_dscrum,
            'hora_daily_scrum' => $hora_dscrum,
            'tipo_iteracion_id' => $tipo_iteracion,
            'proyecto_id' => $proyecto
        );

        $this->db->insert('iteracion', $input);
        $id_iteracion = $this->db->insert_id();

        $this->agregar_estado_iteracion($id_iteracion, 1);

        $this->load->model('m_dailyscrum');
    }

    function editar_iteracion($id, $meta, $fecha_entregable, $lugar_dscrum, $hora_dscrum) {
        $data = array(
            'meta' => $meta,
            'fecha_entregable' => $fecha_entregable,
            'lugar_daily_scrum' => $lugar_dscrum,
            'hora_daily_scrum' => $hora_dscrum,
        );

        $this->db->where('id', $id);
        $this->db->update('iteracion', $data);
    }

    function agregar_estado_iteracion($id_iteracion, $estado_iteracion) {
        $input = array(
            'id' => null,
            'iteracion_id' => $id_iteracion,
            'estado_iteracion_id' => $estado_iteracion
        );

        $this->db->insert('iteracion_has_estado_iteracion', $input);
    }

    function asociar_historia_iteracion($id_historia, $id_iteracion) {
        $input = array(
            'iteracion_id' => $id_iteracion,
            'historia_usuario_id' => $id_historia
        );
        $this->db->insert('iteracion_has_historia_usuario', $input);

        return $this->db->insert_id();
    }

}

?>
