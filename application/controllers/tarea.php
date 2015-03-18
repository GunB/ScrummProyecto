<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tarea extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->m_sesion->comprobar_sesion();
        $this->m_proyectos->comprobar_proyecto_activo();
        $this->load->model('m_tareas');
    }

    function subir_estado() {
        $id_tarea = $this->input->post('tarea');
        if (!empty($id_tarea)) {
            $tarea = $this->m_tareas->get_tarea($id_tarea);
            $nuevo_estado = (intval($tarea->estado_tarea_id) + 1);

            if ($nuevo_estado <= 3) {
                if ($tarea->tipo_tarea_id == 2 && $nuevo_estado == 3) {
                    $tareas_incompletas = $this->m_tareas->tareas_incompletas_historia($tarea->historia_usuario_id);
                    if (!empty($tareas_incompletas)) {
                        header("HTTP/1.0 301 AUN_TAREAS_SIN_TERMINAR");
                    } else {
                        $this->m_tareas->cambiar_estado_tarea($id_tarea, $nuevo_estado);
                    }
                } else {
                    $this->m_tareas->cambiar_estado_tarea($id_tarea, $nuevo_estado);
                }
            } else {
                header("HTTP/1.0 300 EXCEDEED");
            }
        }
    }

    function bajar_estado() {
        $id_tarea = $this->input->post('tarea');
        if (!empty($id_tarea)) {
            $tarea = $this->m_tareas->get_tarea($id_tarea);
            $nuevo_estado = (intval($tarea->estado_tarea_id) - 1);
            if ($nuevo_estado >= 1) {
                if ($tarea->tipo_tarea_id == 1) {  // si el entregable fué entregado solo el entregable se puede bajar de estado
                    $tareas_incompletas = $this->m_tareas->tareas_incompletas_historia($tarea->historia_usuario_id, array('2'));
                    if (!empty($tareas_incompletas)) {
                        $this->m_tareas->cambiar_estado_tarea($id_tarea, $nuevo_estado);
                    } else {
                        header("HTTP/1.0 300 ENTREGABLE_ENTREGADO");
                    }
                } else {
                    $search = $this->m_tareas->tarea_estado_primer_dailyscrum($tarea->id, 3);
                    if (empty($search)) {
                        $this->m_tareas->cambiar_estado_tarea($id_tarea, $nuevo_estado);
                    } else {
                        header("HTTP/1.0 301 ENTREGABLE_ENTREGADO_ANTERIORMENTE");
                    }
                }
            } else {
                header("HTTP/1.0 300 EXCEDEED");
            }
        }
    }

    function nueva_tarea() {
        $this->load->model('m_data');
        $id_historia_usuario = $this->input->post('id');
        if (!empty($id_historia_usuario)) {
            $entregable = $this->m_tareas->get_tareas_historia($id_historia_usuario, 2);
            if ($entregable[0]->estado_tarea_id != 3) {
                
                $tarea = $this->m_data->crear_input('tarea', $this->m_data->get_all_post(array('id')));
                $this->m_tareas->agregar_tarea($tarea, $id_historia_usuario);
            } else {
                header("HTTP/1.0 301 ENTREGABLE_ENTREGADO");
                
            }
        } else {
            header("HTTP/1.0 400 NOT_FOUND");
        }
    }

    function eliminar_tarea() {
        $id_tarea = $this->input->post('id');
        if (!empty($id_tarea)) {
            if (!$this->m_tareas->eliminar_tarea($id_tarea)) {
                header("HTTP/1.0 305 ACCION_IMPOSIBLE");
            }
        } else {
            header("HTTP/1.0 400 NOT_INPUT");
        }
    }

}

?>
