<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class M_historias extends CI_Model {

    //var $sesion = null;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function cambiar_tipo_historia($id_historia, $tipo_nuevo) {
        $this->db->update('historia_usuario', array('tipo_historia_id' => $tipo_nuevo), array('id' => $id_historia));
    }

    function crear_historia($historia, $id_proyecto, $id_iteracion = null, $boolClon = FALSE) {
        if (is_object($historia)) {
            $historia = (array) $historia;
        }

        $this->load->model('m_iteracion');
        $posible_historia = $this->obtener_id_historia_proyecto_prioridad($id_proyecto, $historia['prioridad']);


        if (empty($posible_historia) or $boolClon) {
            $this->db->insert('historia_usuario', $historia);
            $id_historia = $this->db->insert_id();

            if (empty($id_iteracion)) {
                $id_iteracion = $this->m_iteracion->obtener_id_numero_iteracion_proyecto(0, $id_proyecto);
            }
            $this->m_iteracion->asociar_historia_iteracion($id_historia, $id_iteracion);
            return $id_historia;
        } else {
            return false;
        }
    }

    function crear_historia_extra($nombre, $descripcion, $prioridad, $puntos_de_historia, $entregable, $id_proyecto, $id_iteracion = null) {
        // <editor-fold defaultstate="collapsed" desc="input">
        $historia = array(
            'id' => null,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'prioridad' => $prioridad,
            'tipo_historia_id' => 2
        );
        // </editor-fold>
        $id = $this->crear_historia($historia, $id_proyecto, $id_iteracion);
        if ($id !== false) {
            $this->precisar_historia($id, $puntos_de_historia, $entregable);
        }
        return $id;
    }

    function crear_historia_hija($nombre, $descripcion, $prioridad, $puntos_de_historia, $entregable, $id_proyecto) {
        // <editor-fold defaultstate="collapsed" desc="input">
        $historia = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'prioridad' => $prioridad,
            'puntos_de_historia' => $puntos_de_historia,
            'tipo_historia_id' => 4
        );
        // </editor-fold>
        $this->load->model('m_iteracion');
        $posible_historia = $this->obtener_id_historia_proyecto_prioridad($id_proyecto, $historia['prioridad']);

        if (empty($posible_historia)) {
            $this->db->insert('historia_usuario', $historia);
            $id_historia = $this->db->insert_id();

            $id_iteracion_cero = $this->m_iteracion->obtener_id_numero_iteracion_proyecto(0, $id_proyecto);

            $this->m_iteracion->asociar_historia_iteracion($id_historia, $id_iteracion_cero);

            // <editor-fold defaultstate="collapsed" desc="input">
            $data = array(
                'nombre' => $entregable,
                'historia_usuario_id' => $id_historia,
                'estado_tarea_id' => 1,
                'tipo_tarea_id' => 2,
            );
            // </editor-fold>            
            $this->db->insert('tarea', $data);

            return $id_historia;
        } else {
            return false;
        }
    }

    function existe_historia($proyecto) {
        $idhistorias = $this->obtener_id_historias_proyecto($proyecto);

        if (!empty($idhistorias)) {
            $this->db->where_in('id', $idhistorias);
            $query = $this->db->get('historia_usuario');

            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function historia_en_proyecto($historia, $proyecto) {
        $idhistorias = $this->obtener_id_historias_proyecto($proyecto);

        if (!empty($idhistorias)) {
            $this->db->where_in('id', $idhistorias);
            $this->db->where('id', $historia);
            $query = $this->db->get('historia_usuario');

            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function comprobar_encargado($historia, $encargado) {

        $this->db->where('historia_usuario_id', $historia);
        $this->db->where('integrante_equipo_id', $encargado);
        $query = $this->db->get('historia_usuario_has_integrante_equipo');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function cambiar_estado_dividida($vector_hijas, $idhistoria) {
        $data = array(
            'tipo_historia_id' => 3,
            'detalles' => $vector_hijas,
        );

        $this->db->where('id', $idhistoria);
        $this->db->update('historia_usuario', $data);
    }

    function comprobar_precision($proyecto) {
        $idhistorias = $this->obtener_id_historias_proyecto($proyecto);

        if (!empty($idhistorias)) {
            $this->db->where_in('id', $idhistorias);
            $query = $this->db->get('historia_usuario');
            foreach ($query->result() as $row) {
                $entregable = $this->obtener_entregable_historia($row->id);
                if (empty($row->puntos_de_historia) or empty($entregable)) {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    function obtener_encargado($historia) {
        $this->db->where('historia_usuario_id', $historia);
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $query = $this->db->get('historia_usuario_has_integrante_equipo');

        $id = null;

        foreach ($query->result() as $row) {
            $id = $row->integrante_equipo_id;
        }

        $datos_integrante = null;

        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get('integrante_equipo');
        foreach ($query->result() as $row) {
            $datos_integrante = $row;
        }

        return $datos_integrante;
    }

    function obtener_porcentaje_tareas($historia) {
        $this->db->where('historia_usuario_id', $historia);
        $query = $this->db->get('tarea');

        $tareas = 0;
        $finalizadas = 0;
        foreach ($query->result() as $row) {
            $tareas++;
            if ($row->estado_tarea_id == 3) {
                $finalizadas++;
            }
        }
        $porcentaje = ($finalizadas / $tareas) * 100;
        return $porcentaje;
    }

    function obtener_id_historias_iteracion($iteracion) {
        $this->db->where('iteracion_id', $iteracion);
        $query = $this->db->get('iteracion_has_historia_usuario');

        $idhistorias = array();
        foreach ($query->result() as $row) {
            array_push($idhistorias, $row->historia_usuario_id);
        }

        return $idhistorias;
    }

    function obtener_historias_iteracion($iteracion) {
        $idhistorias = $this->obtener_id_historias_iteracion($iteracion);
        $historias = array();
        if (!empty($idhistorias)) {
            $this->db->where_in('id', $idhistorias);
            $this->db->order_by("prioridad", "asc");
            $query = $this->db->get('historia_usuario');

            foreach ($query->result() as $row) {
                $row->estado = $this->obtener_estado_historia($row->id);
                $row->porcentaje = $this->obtener_porcentaje_tareas($row->id);
                array_push($historias, $row);
            }
        }
        return $historias;
    }

    function obtener_estado_historia($id) {
        $this->load->model('m_iteracion');
        $this->load->model('m_proyectos');
        $proyecto = $this->m_proyectos->obtener_id_proyecto_activo();
        $iteracion_cero = $this->m_iteracion->obtener_id_numero_iteracion_proyecto(0, $proyecto);

        $this->db->where('historia_usuario_id', $id);
        $this->db->where('iteracion_id', $iteracion_cero);
        $query = $this->db->get('iteracion_has_historia_usuario');
        if ($query->num_rows() > 0) {
            return "pila";
        } else {
            $this->db->where('historia_usuario_id', $id);
            $query = $this->db->get('tarea');
            $boolfinalizada = false;
            $boolprogreso = false;
            foreach ($query->result() as $row) {
                if ($row->estado_tarea_id == 3 and $row->tipo_tarea_id == 2) {
                    $boolfinalizada = true;
                }
                if ($row->estado_tarea_id == 2) {
                    $boolprogreso = true;
                }
            }

            if ($boolfinalizada) {
                return "finalizada";
            } else {
                if ($boolprogreso) {
                    return "en progreso";
                } else {
                    return "pendiente";
                }
            }
        }
    }

    function obtener_historias_proyecto($proyecto, $inicio = null, $rango = null) {
        $this->load->model('m_iteracion');
        $this->load->model('m_equipo');
        $id_iteracion_cero = $this->m_iteracion->obtener_id_numero_iteracion_proyecto(0, $proyecto);
        $idhistorias = $this->obtener_id_historias_proyecto($proyecto, $id_iteracion_cero);
        $historias = array();
        if (!empty($idhistorias)) {
            $this->db->where('tipo_historia_id !=', 3);
            $this->db->where_in('id', $idhistorias);
            $this->db->order_by('prioridad', 'desc');
            $query = $this->db->get('historia_usuario', $rango, $inicio);
            if ($query->num_rows() > 0) {

                foreach ($query->result() as $row) {
                    $idencargado = $this->obtener_encargado_historia($row->id);
                    if (!empty($idencargado)) {
                        $datosencargado = $this->m_equipo->obtener_datos_integrante($idencargado);
                        $row->encargado = $datosencargado[0]->nombre . " " . $datosencargado[0]->apellidos;
                    }
                    $datosentregable = $this->obtener_entregable_historia($row->id);
                    if (!empty($datosentregable)) {
                        $datosencargado = $this->m_equipo->obtener_datos_integrante($idencargado);
                        $row->entregable = $datosentregable->nombre;
                    }
                    array_push($historias, $row);
                }
            }
        }
        return $historias;
    }

    function obtener_cantidad_historias($proyecto) {
        $this->load->model('m_iteracion');
        $this->load->model('m_equipo');

        $idhistorias = $this->obtener_id_historias_proyecto($proyecto);

        $historias['total'] = 0;
        $historias['normal'] = 0;
        $historias['extra'] = 0;
        $historias['dividida'] = 0;
        $historias['hija'] = 0;
        $historias['incompleta'] = 0;
        $historias['progreso'] = 0;
        $historias['pendiente'] = 0;
        $historias['finalizada'] = 0;
        $historias['pila'] = 0;

        if (!empty($idhistorias)) {
            $this->db->where_in('id', $idhistorias);
            $query = $this->db->get('historia_usuario');
            foreach ($query->result() as $row) {
                if ($row->tipo_historia_id != 5 and $row->tipo_historia_id != 3) {
                    $historias['total']++;
                    switch ($this->obtener_estado_historia($row->id)) {
                        case 'pila':
                            $historias['pila']++;
                            break;

                        case 'en progreso':
                            $historias['progreso']++;
                            break;

                        case 'pendiente':
                            $historias['pendiente']++;
                            break;

                        case 'finalizada':
                            $historias['finalizada']++;
                            break;
                    }
                }

                switch ($row->tipo_historia_id) {
                    case 1:
                        $historias['normal']++;
                        break;

                    case 2:
                        $historias['extra']++;
                        break;

                    case 3:
                        $historias['dividida']++;
                        break;

                    case 4:
                        $historias['hija']++;
                        break;

                    case 5:
                        $historias['incompleta']++;
                        break;
                }
            }
        }
        return $historias;
    }

    function obtener_total_puntos_historia($proyecto) {
        $idhistorias = $this->obtener_id_historias_proyecto($proyecto);

        $total = 0;
        if (!empty($idhistorias)) {
            $this->db->where_in('id', $idhistorias);
            $this->db->where('tipo_historia_id !=', 5);
            $this->db->where('tipo_historia_id !=', 3);
            $query = $this->db->get('historia_usuario');
            foreach ($query->result() as $row) {
                $total = $total + $row->puntos_de_historia;
            }
        }

        return $total;
    }

    function obtener_puntos_historia_finalizados($proyecto) {
        $this->load->model('m_iteracion');
        $this->load->model('m_equipo');

        $idhistorias = $this->obtener_id_historias_proyecto($proyecto);

        $total = 0;
        if (!empty($idhistorias)) {
            $this->db->where_in('id', $idhistorias);
            $this->db->where('tipo_historia_id !=', 5);
            $this->db->where('tipo_historia_id !=', 3);
            $query = $this->db->get('historia_usuario');
            foreach ($query->result() as $row) {
                if ($this->obtener_estado_historia($row->id) == 'finalizada') {
                    $total = $total + $row->puntos_de_historia;
                }
            }
        }

        return $total;
    }

    function obtener_datos_historia($historia) {
        $this->db->where('id', $historia);
        $query = $this->db->get('historia_usuario');
        $resp = null;
        if ($query->num_rows() > 0) {
            $resp = array();
            foreach ($query->result() as $row) {
                $entregable = $this->obtener_entregable_historia($historia);
                if (!empty($entregable)) {
                    $row->entregable = $entregable->nombre;
                } else {
                    $row->entregable = null;
                }
                array_push($resp, $row);
            }
        }
        return $resp;
    }

    function obtener_entregable_historia($historia) {
        $this->db->where('historia_usuario_id', $historia);
        $this->db->where('tipo_tarea_id', 2);
        $query = $this->db->get('tarea', 1);
        $resp = null;
        foreach ($query->result() as $row) {
            $resp = $row;
        }
        return $resp;
    }

    function obtener_encargado_historia($historia) {
        $this->db->order_by("id", "desc");
        $this->db->where('historia_usuario_id', $historia);
        $query = $this->db->get('historia_usuario_has_integrante_equipo', 1);
        $resp = null;
        foreach ($query->result() as $row) {
            $resp = $row->integrante_equipo_id;
        }
        return $resp;
    }

    function obtener_id_historias_proyecto($proyecto, $id_iteracion = null) {
        $this->load->model('m_iteracion');
        if (empty($id_iteracion)) {
            $id_iteracion = $this->m_iteracion->obtener_id_iteraciones_proyecto($proyecto);
        }
        $this->db->select('historia_usuario_id');
        $this->db->from('iteracion_has_historia_usuario ih');

        $this->db->where_in('iteracion_id', $id_iteracion);
        $query = $this->db->get();

        $idhistorias = array();
        if ($query->num_rows() > 0) {
            $idhistorias = array();
            foreach ($query->result() as $row) {
                array_push($idhistorias, $row->historia_usuario_id);
            }
        }
        return $idhistorias;
    }

    function obtener_id_historia_proyecto_prioridad($proyecto, $prioridad) {
        $this->load->model('m_iteracion');
        $iteraciones = $this->m_iteracion->obtener_id_iteraciones_proyecto($proyecto);

        $this->db->from('iteracion_has_historia_usuario, historia_usuario');
        $this->db->where('iteracion_has_historia_usuario.historia_usuario_id = historia_usuario.id');
        $this->db->where('historia_usuario.prioridad', $prioridad);
        $this->db->where_in('iteracion_has_historia_usuario.iteracion_id', $iteraciones);
        $query = $this->db->get();

        $idhistorias = array();
        foreach ($query->result() as $row) {
            array_push($idhistorias, $row->historia_usuario_id);
        }

        return $idhistorias;
    }

    public function editar_historia($id, $nombre, $descripcion, $prioridad) {
        $data = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'prioridad' => $prioridad
        );

        $this->db->where('id', $id);
        $this->db->update('historia_usuario', $data);
    }

    public function precisar_historia($id, $puntos_historia, $entregable) {
        $data = array(
            'puntos_de_historia' => $puntos_historia,
        );
        $this->db->where('id', $id);
        $this->db->update('historia_usuario', $data);


        $this->load->model('m_tareas');
        $tarea_entregable = $this->m_tareas->get_tareas_historia($id, 2);
        //var_dump($tarea_entregable);
        if (!empty($tarea_entregable)) {
            foreach ($tarea_entregable as $value) {

                ($this->m_tareas->eliminar_tarea($value->id));
            }
        }

        $data = array(
            'nombre' => $entregable,
            'historia_usuario_id' => $id,
            'estado_tarea_id' => 1,
            'tipo_tarea_id' => 2,
        );

        $this->db->insert('tarea', $data);
    }

    function vincular_historia_iteracion($historia, $iteracion) {
        $input = array(
            'historia_usuario_id' => $historia,
            'iteracion_id' => $iteracion
        );
        $this->db->insert('iteracion_has_historia_usuario', $input);

        $this->load->model('m_iteracion');
        $this->load->model('m_proyectos');
        $proyecto = $this->m_proyectos->obtener_id_proyecto_activo();
        $id_iteracion_cero = $this->m_iteracion->obtener_id_numero_iteracion_proyecto(0, $proyecto);
        $this->db->delete('iteracion_has_historia_usuario', array('historia_usuario_id' => $historia, 'iteracion_id' => $id_iteracion_cero));
        return true;
    }

    function is_historia_finalizada($id_historia) {
        $this->load->model('m_tareas');
        $tareas_incompletas = $this->m_tareas->tareas_incompletas_historia($id_historia, array('2'));
        return empty($tareas_incompletas);
    }

}

?>