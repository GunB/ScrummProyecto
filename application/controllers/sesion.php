<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sesion extends CI_Controller {

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
    public function crear_cuenta() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        
        
        $this->load->view('base/body');
        // </editor-fold>
        
        $bulcreado = $this->m_sesion->crear_cuenta($this->input->post("nombre"), $this->input->post("correo"), $this->input->post("clave"));
        if ($bulcreado) {
            $data["cuenta_creada"] = "Su cuenta se ha creado satisfactoriamente";
        } else {
            $data["cuenta_creada"] = "Su cuenta ya ha sido registrada anteriormente, vuelva a intentarlo...";
        }
        $this->load->view('site/top-navbar');
        $this->load->view('site/cuenta', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function iniciar_sesion() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        
        
        $this->load->view('base/body');
        // </editor-fold>
        
        $bul_encontrado = $this->m_sesion->buscar_sesion($this->input->post("correo"),$this->input->post("clave"));
        if (!is_null($bul_encontrado)) {
            $this->m_sesion->crear_sesion($bul_encontrado);
            $data["cuenta_creada"] = "Sesion iniciada";
        } else {
            $data["cuenta_creada"] = "Datos incorrectos... intenta nuevamente";
        }
        $this->load->view('site/cuenta', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }
    
    public function cerrar_sesion(){
        
        $this->m_sesion->destruir_sesion();
        redirect("inicio");
    }
    
    

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */