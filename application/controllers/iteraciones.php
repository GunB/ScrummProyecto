<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Iteraciones extends CI_Controller {

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
        $this->load->model('m_iteracion');
    }

    function index() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        $this->load->view('base/body');

        // </editor-fold>
        /*
          $this->load->view('site/top-navbar');
          $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
          $this->load->model('m_historias');
          $data["boolprecisar"] = false;
          $data["historias"] = $this->m_historias->obtener_historias_proyecto($this->m_proyectos->obtener_id_proyecto_activo());
          $this->load->view('site/historia-usuario', $data); */
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }
    
    public function crear_iteracion_extra(){
        $this->m_proyectos->agregar_iteracion_extra($this->m_proyectos->obtener_id_proyecto_activo());
        redirect('proyectos/iniciar_scrum');
    }

    public function listado_iteraciones() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');


        $this->load->view('base/body');
        $this->m_sesion->comprobar_sesion();
        // </editor-fold>

        $this->load->model(array('m_dailyscrum', 'm_historias', 'm_tareas'));
        $this->load->view('site/top-navbar');
        $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
        $id_proyecto_actual = $this->m_proyectos->obtener_id_proyecto_activo();
        $data['iteraciones'] = $this->m_iteracion->obtener_iteraciones_proyecto($id_proyecto_actual);

        foreach ($data['iteraciones'] as $key => $value) {
            $data['iteraciones'][$key]->daily_scrums = $this->m_dailyscrum->obtener_dailyscrums_iteraciones($value->id);
            
        }
        $this->load->view('site/iteraciones', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function iteracion_creada() {

        $proyecto = $this->m_proyectos->obtener_id_proyecto_activo();
        $ultima = $this->m_iteracion->obtener_ultima_iteracion($proyecto);
        $id = $ultima->id;

        $meta = $this->input->post("meta");
        $fecha_entregable = $this->input->post("fecha_entregable");
        $lugar_dscrum = $this->input->post("lugar_dscrum");
        $hora_dscrum = $this->input->post("hora_dscrum");

        $this->m_iteracion->editar_iteracion($id, $meta, $fecha_entregable, $lugar_dscrum, $hora_dscrum);
        $this->m_iteracion->cambiar_estado_iteracion_actual($id, 2);

        redirect("proyectos/admin_proyecto");
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */