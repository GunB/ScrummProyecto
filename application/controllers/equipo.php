<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Equipo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->m_sesion->comprobar_sesion();
        $this->m_proyectos->comprobar_proyecto_activo();
    }

    function index() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');


        $this->load->view('base/body');
        $this->m_sesion->comprobar_sesion();
        $this->m_proyectos->comprobar_proyecto_activo();
        // </editor-fold>
        $this->load->view('site/top-navbar');
        $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
        $this->load->model('m_equipo');
        $this->load->model('m_iteracion');
        $ultima_iteracion = $this->m_iteracion->obtener_ultima_iteracion($this->m_proyectos->obtener_id_proyecto_activo());
        $data["ultima_iteracion"] = $ultima_iteracion->numero;
        $id_ultima_iteracion = $ultima_iteracion->id;
        $data["equipo_trabajo"] = $this->m_equipo->obtener_equipo($id_ultima_iteracion);
        $this->load->view('site/grupo-trabajo', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    function crear_integrante() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');


        $this->load->view('base/body');
        $this->m_sesion->comprobar_sesion();
        $this->m_proyectos->comprobar_proyecto_activo();
        // </editor-fold>
        $this->load->view('site/top-navbar');
        $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
        $this->load->view('site/crear_integrante_equipo', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    function confirmar_equipo() {
        $this->load->model('m_equipo');
        $this->load->model('m_iteracion');
        $this->load->model('m_proyectos');
        $id = $this->m_proyectos->obtener_id_proyecto_activo();
        $iteracion = $this->m_iteracion->obtener_ultima_iteracion($id);
        $integrantes = $this->input->post('check');
        if (!empty($integrantes)) {
            for ($i = 0; $i < sizeof($integrantes); $i++) {
                $this->m_equipo->vincular_integrante_iteracion($integrantes[$i], $iteracion->id);
            }
        }
        $boolequipo = $this->m_equipo->existe_grupo($id, $iteracion->numero);
        if ($boolequipo) {
            $this->m_iteracion->cambiar_estado_iteracion_actual($iteracion->id, 3);
            redirect('proyectos/admin_proyecto');
        } else {
            $data["mensaje"] = "No se ha seleccionado ningún miembro para el equipo";
            $this->load->view('base/mensaje', $data);
        }
    }

    function insertar_integrante() {
        $this->m_sesion->comprobar_sesion();
        $this->m_proyectos->comprobar_proyecto_activo();
        $this->load->model('m_equipo');
        $this->load->model('m_iteracion');
        $nombre = $this->input->post("nombre");
        $apellidos = $this->input->post("apellidos");
        $edad = $this->input->post("edad");
        $correo = $this->input->post("correo");
        $telefono = $this->input->post("telefono");
        $proyecto = $this->m_proyectos->obtener_id_proyecto_activo();
        $ultima_iteracion = $this->m_iteracion->obtener_ultima_iteracion($proyecto);
        $id_ultima_iteracion = $ultima_iteracion->id;
        $this->m_equipo->crear_integrante_equipo($nombre, $apellidos, $edad, $correo, $telefono, $id_ultima_iteracion);
        redirect("proyectos/admin_proyecto");
    }

    public function editar_integrante() {
        $this->m_sesion->comprobar_sesion();
        $this->m_proyectos->comprobar_proyecto_activo();
        $this->load->model('m_equipo');

        $id = $this->uri->segment(3);
        $nombre = $this->input->post("nombre");
        $apellidos = $this->input->post("apellidos");
        $edad = $this->input->post("edad");
        $correo = $this->input->post("correo");
        $telefono = $this->input->post("telefono");

        $this->m_equipo->editar_integrante($id, $nombre, $apellidos, $edad, $correo, $telefono);
        redirect('equipo');
    }

    public function edicion_integrante() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');


        $this->load->view('base/body');
        $this->m_sesion->comprobar_sesion();
        $this->m_proyectos->comprobar_proyecto_activo();
        // </editor-fold>
        $id = $this->uri->segment(3);
        $proyecto = $this->m_proyectos->obtener_id_proyecto_activo();
        $this->load->model('m_equipo');
        $boolintegrante = $this->m_equipo->integrante_en_proyecto($id, $proyecto);
        if ($boolintegrante) {
            $this->load->view('site/top-navbar');
            $data["datos_integrante"] = $this->m_equipo->obtener_datos_integrante($id);
            $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
            $this->load->view('site/crear_integrante_equipo', $data);
            // <editor-fold defaultstate="collapsed" desc="footer">
            $this->load->view('base/foot'); // </editor-fold>
        } else {
            redirect('equipo');
        }
    }

}

?>
