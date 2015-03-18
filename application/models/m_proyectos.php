<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class M_proyectos extends CI_Model {

    //var $sesion = null;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function agregar_iteracion_extra($id_proyecto) {
        $estado_proyecto = $this->estado_proyecto($id_proyecto);
        if ($estado_proyecto == 3) {
            $iteraciones = intval($this->obtener_cantidad_iteraciones_proyecto_activo()) + 1;
            $this->db->update('proyecto', array('cantidad_iteraciones' => $iteraciones), array('id' => $id_proyecto));
        }
        $this->set_estado_proyecto($id_proyecto, 2);
    }

    public function crear_proyecto($nombre, $entidad, $usuario, $descripcion) {
        $input = array(
            'id' => null,
            'nombre' => $nombre,
            'ent_interesada' => $entidad,
            'usuario_id' => $usuario,
            'descripcion' => $descripcion
        );
        $this->db->insert('proyecto', $input);
        $id_proyecto = $this->db->insert_id();

        $input = array(
            'id' => null,
            'proyecto_id' => $id_proyecto,
            'estado_proyecto_id' => 1
        );

        $this->db->insert('proyecto_has_estado_proyecto', $input);
        $this->load->model('m_iteracion');
        $this->m_iteracion->crear_iteracion($id_proyecto, 0);

        return true;
    }

    public function proyectos_usuario($usuario) {
        $temp = $this->db->get_where('proyecto', array('usuario_id' => $usuario));
        return $temp;
    }

    function activar_proyecto($id, $nombre, $entidad, $duracion, $duracion_iteracion, $cantidad_iteraciones) {
        if (is_int($id) or is_string($id)) {
            $newdata = array(
                'proyecto' => array(
                    'id' => $id,
                    'nombre' => $nombre,
                    'entidad' => $entidad,
                    'duracion' => $duracion,
                    'duracion_iteracion' => $duracion_iteracion,
                    'cantidad_iteraciones' => $cantidad_iteraciones
                )
            );
        } else {
            $newdata = $id;
        }
        $this->session->set_userdata($newdata);
    }

    function obtener_grafica_rendimiento($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('proyecto', 1);
        foreach ($query->result() as $row) {
            $grafica = $row->grafica;
        }
        return $grafica;
    }

    function actualizar_grafica_rendimiento($id, $grafica) {
        $data = array(
            'grafica' => $grafica,
        );

        $this->db->where('id', $id);
        $this->db->update('proyecto', $data);
    }

    function obtener_proyecto_activo() {
        return $this->session->userdata('proyecto');
    }

    function obtener_id_proyecto_activo() {
        $resp = $this->obtener_proyecto_activo();
        return $resp["id"];
    }

    function obtener_duracion_iteracion_proyecto_activo() {
        $resp = $this->obtener_proyecto_activo();
        return $resp["duracion_iteracion"];
    }

    function obtener_duracion_proyecto_activo() {
        $resp = $this->obtener_proyecto_activo();
        return $resp["duracion"];
    }

    function obtener_nombre_proyecto_activo() {
        $resp = $this->obtener_proyecto_activo();
        return $resp["nombre"];
    }

    function obtener_cantidad_iteraciones_proyecto_activo() {
        $this->actualizar_datos_proyecto();
        $resp = $this->obtener_proyecto_activo();
        return $resp["cantidad_iteraciones"];
    }

    function actualizar_datos_proyecto() {
        $proyecto = (object) $this->datos_proyecto($this->obtener_id_proyecto_activo());
        $this->activar_proyecto($proyecto->id, $proyecto->nombre, $proyecto->entidad, $proyecto->duracion, $proyecto->duracion_iteracion, $proyecto->cantidad_iteraciones);
    }

    function datos_proyecto($id_proyecto) {
        $query = $this->db->get_where('proyecto', array('id' => $id_proyecto), 1);
        foreach ($query->result() as $row) {
            $datos_proyecto = array
                (
                'id' => $row->id,
                'nombre' => $row->nombre,
                'entidad' => $row->ent_interesada,
                'duracion' => $row->duracion,
                'duracion_iteracion' => $row->duracion_iteracion,
                'cantidad_iteraciones' => $row->cantidad_iteraciones,
                'descripcion' => $row->descripcion,
            );
        }
        return $datos_proyecto;
    }

    public function comprobar_proyecto_activo() {
        if (!$this->obtener_proyecto_activo()) {
            redirect("inicio");
        }
    }

    public function set_duracion($id, $duracion_iteracion, $duracion) {
        $iteraciones = $duracion / $duracion_iteracion;
        $iteraciones = ceil($iteraciones);
        $data = array(
            'duracion_iteracion' => $duracion_iteracion,
            'duracion' => $duracion,
            'cantidad_iteraciones' => $iteraciones
        );

        $this->db->where('id', $id);
        $this->db->update('proyecto', $data);
    }

    public function set_estado_en_progreso($id_proyecto) {
        $this->set_estado_proyecto($id_proyecto, 2);
    }

    public function set_estado_proyecto($id_proyecto, $estado) {
        $data = array(
            'proyecto_id' => $id_proyecto,
            'estado_proyecto_id' => ($estado)
        );

        $this->db->insert('proyecto_has_estado_proyecto', $data);
    }

    public function existe_duracion_iteracion($id) {
        $query = $this->db->get_where('proyecto', array('id' => $id), 1);
        foreach ($query->result() as $row) {
            if ($row->duracion_iteracion != null) {
                $boolduracion = true;
            } else {
                $boolduracion = false;
            }
        }
        return $boolduracion;
    }

    public function estado_proyecto($id) {
        $resp = null;
        $this->db->order_by('id', 'desc');
        $query = $this->db->get_where('proyecto_has_estado_proyecto', array('proyecto_id' => $id), 1);
        foreach ($query->result() as $row) {
            $resp = $row->estado_proyecto_id;
        }
        return $resp;
    }

    public function porcentajes_proyecto($id) {
        $this->load->model('m_historias');
        $this->load->model('m_iteracion');
        $this->load->model('m_dailyscrum');

        $finalizado = $this->m_historias->obtener_puntos_historia_finalizados($id);
        $total = $this->m_historias->obtener_total_puntos_historia($id);

        $data['total_puntos_historia'] = $total;

        $duracionproyecto = $this->obtener_duracion_proyecto_activo();

        if (!empty($duracionproyecto)) {
            $puntos_diarios = $total / $duracionproyecto;
            $data['porcentaje_terminado'] = ($finalizado / $total) * 100;
        } else {
            $puntos_diarios = 0;
            $data['porcentaje_terminado'] = 0;
        }

        $ultima_iteracion = $this->m_iteracion->obtener_ultima_iteracion($id);
        $daily_scrums = $this->m_dailyscrum->obtener_cantidad_daily_scrums_terminados($ultima_iteracion->id);

        $dias_transcurridos = (($ultima_iteracion->numero - 1) * $this->obtener_duracion_iteracion_proyecto_activo());
        $dias_transcurridos = $dias_transcurridos + $daily_scrums;

        $estimado = $puntos_diarios * $dias_transcurridos;

        $diferencia = $estimado - $finalizado;
        if ($diferencia < 0) {
            $data['estado'] = 'adelantado';
        } else {
            if ($diferencia > 0) {
                $data['estado'] = 'atrasado';
            } else {
                $data['estado'] = 'acorde';
            }
        }
        if (!empty($puntos_diarios)) {
            $data['dias'] = abs($diferencia) / $puntos_diarios;
        } else {
            $data['dias'] = 0;
        }
        return $data;
    }

}

?>