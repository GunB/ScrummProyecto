<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inicio extends CI_Controller {

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
    public function index() {
        $this->m_sesion->comprobar_sesion();
        redirect("proyectos");
    }

    public function grupo_trabajo() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        
        
        $this->load->view('base/body');
        $this->m_sesion->comprobar_sesion();
        // </editor-fold>
        $this->load->view('site/top-navbar');
        $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
        $this->load->view('site/grupo-trabajo', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function login() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        
        
        $this->load->view('base/body');
        // </editor-fold>
        
        $this->load->view('site/top-navbar');
        $this->load->view('site/login-crear_cuenta');
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function descripcion() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        
        
        $this->load->view('base/body');
        $this->m_sesion->comprobar_sesion();
        // </editor-fold>
        $this->load->view('site/top-navbar');
        $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
        $this->load->view('site/descripcion', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function historia_usuario() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        
        
        $this->load->view('base/body');
        $this->m_sesion->comprobar_sesion();
        // </editor-fold>
        $this->load->view('site/top-navbar');
        $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
        $this->load->view('site/historia-usuario', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function nuevo_integrante() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        
        
        $this->load->view('base/body');
        $this->m_sesion->comprobar_sesion();
        // </editor-fold>
        $this->load->view('site/top-navbar');
        $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
        $this->load->view('site/nuevo-integrante', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }
    
    public function pendejadas(){
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        
        
        $this->load->view('base/body');
        $this->m_sesion->comprobar_sesion();
        // </editor-fold>
        $id = $this->m_proyectos->obtener_id_proyecto_activo();
        $data['puntos_grafica_rendimiento'] = $this->m_proyectos->obtener_grafica_rendimiento($id);
        $this->load->view('site/grafica', $data);
        
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */