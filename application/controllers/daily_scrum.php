<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Daily_scrum extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->m_sesion->comprobar_sesion();
        $this->m_proyectos->comprobar_proyecto_activo();
        $this->load->model('m_iteracion');
        $this->load->model('m_proyectos');
        $this->load->model('m_historias');
        $this->load->model('m_tareas');
        $this->load->model('m_dailyscrum');
    }

    function index() {
        
    }

    function panel_dia() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        $this->load->view('base/body');
        $this->load->view('site/top-navbar');
        // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    function panel_control() {

        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        $this->load->view('base/body');
        $this->load->view('site/top-navbar');
        // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="comment">
        //$data['iteraciones'][$key]->historias = $this->m_historias->obtener_historias_iteracion($value->id);


        /* foreach ($data['iteraciones'][$key]->historias as $key2 => $value2) {
          $data['iteraciones'][$key]->historias[$key2]->tareas = $this->m_tareas->get_tareas_historia($value2->id);
          }// */
        //var_dump($data['iteraciones']);// </editor-fold>
        $iteracion_post = $this->input->post('iteracion');
        $dailyscrum_post = $this->input->post('dia');

        if (empty($iteracion_post)) {
            $data['iteracion'] = $this->m_iteracion->obtener_ultima_iteracion($this->m_proyectos->obtener_id_proyecto_activo());
        } else {
            $data['iteracion'] = $this->m_iteracion->obtener_iteracion_full($iteracion_post);
        }

        if (empty($dailyscrum_post)) {

            $ultimo_daily_scrum = $this->m_dailyscrum->obtener_ultimo_daily_scrum($data['iteracion']->id, 1);

            if (empty($ultimo_daily_scrum)) {
                $ultimo_daily_scrum = $this->m_dailyscrum->obtener_ultimo_daily_scrum($data['iteracion']->id);
                $numero_daily_scrum = 1;
                if (!empty($ultimo_daily_scrum)) {
                    $numero_daily_scrum = intval($ultimo_daily_scrum->dia) + 1;
                }
                $numeromax_daily_scrums = $this->m_proyectos->obtener_duracion_iteracion_proyecto_activo();

                if ($numero_daily_scrum <= intval($numeromax_daily_scrums)) {
                    $ultimo_daily_scrum = $this->m_dailyscrum->obtener_dailyscrum_full($this->m_dailyscrum->crear_daily_scrum($data['iteracion']->id, $numero_daily_scrum));
                }
            }
        } else {
            $ultimo_daily_scrum = $this->m_dailyscrum->obtener_dailyscrum_full($dailyscrum_post);
        }

        $data['daily_scrum'] = $ultimo_daily_scrum;

        $data['historias'] = $this->m_historias->obtener_historias_iteracion($data['iteracion']->id);

        //var_dump($data['daily_scrum']);

        $temp = $this->m_dailyscrum->obtener_tareas_dailyscrum($data['daily_scrum']->id);

        if (!empty($temp)) {
            foreach ($data['historias'] as $key => $value) {
                $data['historias'][$key]->tareas = $this->m_dailyscrum->obtener_tareas_dailyscrum($data['daily_scrum']->id, $data['historias'][$key]->id);
            }
        } else {
            foreach ($data['historias'] as $key => $value) {
                $data['historias'][$key]->tareas = ($this->m_tareas->get_tareas_historia($value->id));
            }
        }

        //var_dump($data);

        $this->load->view('site/daily_scrum', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function actualizar_grafica_proyecto() {
        $this->load->model('m_iteracion');
        $this->load->model('m_dailyscrum');
        $this->load->model('m_proyectos');
        $id = $this->m_proyectos->obtener_id_proyecto_activo();
        $ultima = $this->m_iteracion->obtener_ultima_iteracion($id);
        $daily_scrums = $this->m_dailyscrum->obtener_cantidad_daily_scrums_terminados($ultima->id) + 1;
        $finalizado = $this->m_historias->obtener_puntos_historia_finalizados($id);

        $dias_transcurridos = (($ultima->numero - 1) * $this->m_proyectos->obtener_duracion_iteracion_proyecto_activo());
        $dias_transcurridos = $dias_transcurridos + $daily_scrums;

        $grafica = $this->m_proyectos->obtener_grafica_rendimiento($id);
        if (empty($grafica)) {
            $grafica = array();
            array_push($grafica, array(0, 0));
        } else {
            $grafica = json_decode($grafica, true);
        }

        array_push($grafica, array($dias_transcurridos, $finalizado));
        $this->m_proyectos->actualizar_grafica_rendimiento($id, json_encode($grafica));
    }

    function confirmar_dailyscrum() {
        $confirmar = $this->input->post('confirmar');
        if (!empty($confirmar)) {
            $iteracion_ultima = $this->m_iteracion->obtener_ultima_iteracion($this->m_proyectos->obtener_id_proyecto_activo());
            $historias = $this->m_historias->obtener_historias_iteracion($iteracion_ultima->id);
            $daily_scrum = $this->m_dailyscrum->obtener_ultimo_daily_scrum($iteracion_ultima->id, 1);
            //var_dump($daily_scrum);
            $this->m_dailyscrum->consolidar_dailyscrum($daily_scrum, $historias);
            foreach ($historias as $value) {
                $tareas_entregable_completas = $this->m_tareas->tareas_completas_historia($value->id);
                if (!empty($tareas_entregable_completas)) {

                    $search = $this->m_tareas->tarea_estado_primer_dailyscrum($tareas_entregable_completas[0]->id, $tareas_entregable_completas[0]->estado_tarea_id);
                    if ($search->daily_scrum_id == $daily_scrum->id) {
                        $this->actualizar_grafica_proyecto();
                        $this->m_equipo->actualizar_velocidad();
                        break;
                    } else {
                        //var_dump($search);
                        //var_dump($daily_scrum);
                    }
                }
            }


            $numero_iteraciones = $this->m_proyectos->obtener_cantidad_iteraciones_proyecto_activo();
            $numero_daily_scrums = $this->m_proyectos->obtener_duracion_iteracion_proyecto_activo();

            if (intval($daily_scrum->dia) == $numero_daily_scrums) {
                $historias = $this->m_historias->obtener_historias_iteracion($iteracion_ultima->id);
                foreach ($historias as $key => $value) {
                    $tareas_incompletas = $this->m_tareas->tareas_incompletas_historia($value->id, array(2));
                    if (!empty($tareas_incompletas)) {
                        $this->m_historias->cambiar_tipo_historia($value->id, 5);
                        unset($value->id);
                        unset($value->estado);
                        unset($value->porcentaje);
                        $value->tipo_historia_id = 1;
                        $id_nueva_historia = $this->m_historias->crear_historia($value, $this->m_proyectos->obtener_id_proyecto_activo(), null, true);
                        unset($tareas_incompletas[0]->id);
                        $tareas_incompletas[0]->estado_tarea_id = 1;
                        $this->m_tareas->agregar_tarea($tareas_incompletas[0], $id_nueva_historia);
                    }
                }
            } else {
                //continua normalmente la iteración
            }
            $this->m_dailyscrum->cambiar_estado_dailyscrum($daily_scrum->id, 2); //finalizado el daily scrum
            redirect('proyectos/admin_proyecto');
        } else {
            $this->load->view('base/mensaje');
        }
    }

}

?>
