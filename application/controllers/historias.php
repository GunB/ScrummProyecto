<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Historias extends CI_Controller {

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
        parent::__construct();
        $this->m_sesion->comprobar_sesion();
        $this->m_proyectos->comprobar_proyecto_activo();
    }

    function index() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        $this->load->view('base/body');
        // </editor-fold>
        $this->load->model('m_iteracion');
        $id = $this->m_proyectos->obtener_id_proyecto_activo();
        $ultima = $this->m_iteracion->obtener_ultima_iteracion($id);
        $data['ultima_iteracion'] = $ultima;
        $this->load->view('site/top-navbar');
        $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
        $this->load->model('m_historias');
        $data["boolprecisar"] = false;
        $data["historias"] = $this->m_historias->obtener_historias_proyecto($this->m_proyectos->obtener_id_proyecto_activo());
        if ($ultima->numero > 0) {
            $data['boolcero'] = false;
        } else {
            $data['boolcero'] = true;
        }
        $this->load->view('site/historia-usuario', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function edicion_historia() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        $this->load->view('base/body');
        // </editor-fold>
        $id = $this->uri->segment(3);
        $proyecto = $this->m_proyectos->obtener_id_proyecto_activo();
        $this->load->model('m_historias');
        $boolhistoria = $this->m_historias->historia_en_proyecto($id, $proyecto);
        if ($boolhistoria) {
            $this->load->view('site/top-navbar');
            $data["datos_historia"] = $this->m_historias->obtener_datos_historia($id);
            $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
            $this->load->view('site/crear_historia', $data);
            // <editor-fold defaultstate="collapsed" desc="footer">
            $this->load->view('base/foot'); // </editor-fold>
        } else {
            redirect('historias');
        }
    }

    public function nueva_historia() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        $this->load->view('base/body');
        // </editor-fold>
        $this->load->view('site/top-navbar');
        $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
        $this->load->view('site/crear_historia', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function precision_historia() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        $this->load->view('base/body');
        // </editor-fold>
        $id = $this->uri->segment(3);
        $proyecto = $this->m_proyectos->obtener_id_proyecto_activo();
        $this->load->model('m_iteracion');
        $this->load->model('m_historias');
        $this->load->model('m_equipo');
        $ultima = $this->m_iteracion->obtener_ultima_iteracion($proyecto);
        $boolhistoria = $this->m_historias->historia_en_proyecto($id, $proyecto);
        if ($ultima->numero > 0) {
            $data['boolcero'] = false;
            $boolhistoria = true;
        } else {
            $data['boolcero'] = true;
        }
        if ($boolhistoria) {
            $this->load->view('site/top-navbar');
            $data["datos_historia"] = $this->m_historias->obtener_datos_historia($id);
            $data["equipo"] = $this->m_equipo->obtener_equipo($proyecto);
            $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
            $this->load->view('site/precisar_historia', $data);
            // <editor-fold defaultstate="collapsed" desc="footer">
            $this->load->view('base/foot'); // </editor-fold>
        } else {
            $data["mensaje"] = "La historia no existe en el proyecto activo";
            $this->load->view('base/mensaje', $data);
        }
    }

    public function division_historia() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        $this->load->view('base/body');
        // </editor-fold>
        $id = $this->uri->segment(3);
        $proyecto = $this->m_proyectos->obtener_id_proyecto_activo();
        $this->load->model('m_historias');
        $boolhistoria = $this->m_historias->historia_en_proyecto($id, $proyecto);
        if ($boolhistoria) {
            $this->load->view('site/top-navbar');
            $data["datos_historia"] = $this->m_historias->obtener_datos_historia($id);
            $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
            $this->load->view('site/dividir_historia', $data);
            // <editor-fold defaultstate="collapsed" desc="footer">
            $this->load->view('base/foot'); // </editor-fold>
        } else {
            $data["mensaje"] = "La historia no existe en el proyecto activo";
            $this->load->view('base/mensaje', $data);
        }
    }

    public function continuar_division() {
        if ($this->input->post('cantidad') < 2 or !is_numeric($this->input->post('cantidad'))) {
            $data["mensaje"] = "La historia no pudo ser dividida, el número de particiones no es válido";
            $this->load->view('base/mensaje', $data);
        } else {
            // <editor-fold defaultstate="collapsed" desc="header">
            $this->load->view('base/head');
            $this->load->view('base/body');
            // </editor-fold>
            $id = $this->input->post('historia');
            $proyecto = $this->m_proyectos->obtener_id_proyecto_activo();
            $this->load->model('m_historias');
            $this->load->model('m_equipo');
            $boolhistoria = $this->m_historias->historia_en_proyecto($id, $proyecto);
            if ($boolhistoria) {
                $this->load->view('site/top-navbar');
                $data["cantidad"] = $this->input->post('cantidad');
                $data["equipo"] = $this->m_equipo->obtener_equipo($proyecto);
                $data["datos_historia"] = $this->m_historias->obtener_datos_historia($id);
                $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
                $this->load->view('site/continuar_division', $data);
                // <editor-fold defaultstate="collapsed" desc="footer">
                $this->load->view('base/foot'); // </editor-fold>
            } else {
                //redirect('historias/historias_para_precisar');
                echo "nope";
            }
        }
    }

    public function historias_para_precisar() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');
        $this->load->view('base/body');
        // </editor-fold>
        $this->load->view('site/top-navbar');
        $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
        $this->load->model('m_historias');
        $data["boolprecisar"] = true;
        $data["historias"] = $this->m_historias->obtener_historias_proyecto($this->m_proyectos->obtener_id_proyecto_activo());
        $this->load->view('site/historia-usuario', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function crear_historia() {
        $this->load->model('m_historias');
        $this->load->model('m_iteracion');
        $this->load->model('m_dailyscrum');

        $historia = array(
            'id' => null,
            'nombre' => $this->input->post("nombre"),
            'descripcion' => $this->input->post("descripcion"),
            'prioridad' => $this->input->post("prioridad"),
            'tipo_historia_id' => 1
        );

        $proyecto = $this->m_proyectos->obtener_id_proyecto_activo();

        $iteracion_creada = $this->m_iteracion->obtener_ultima_iteracion($proyecto)->id;
        $data = array();

        $id_nueva_historia = $this->m_historias->crear_historia($historia, $proyecto, $iteracion_creada);

        if (!is_numeric($id_nueva_historia)) {
            $data["mensaje"] = "Historia no creada, la prioridad es igual a otra historia en el mismo proyecto";
            $this->load->view('base/mensaje', $data);
        } else {
            redirect('historias');
        }
    }

    public function crear_historia_extra() {
        $this->load->model('m_historias');
        $this->load->model('m_iteracion');
        $this->load->model('m_dailyscrum');


        $nombre = $this->input->post("nombre");
        $descripcion = $this->input->post("descripcion");
        $prioridad = $this->input->post("prioridad");
        $puntos_de_historia = $this->input->post("puntos_historia");
        $entregable = $this->input->post("entregable");


        $proyecto = $this->m_proyectos->obtener_id_proyecto_activo();

        $iteracion_cero = $this->m_iteracion->obtener_id_numero_iteracion_proyecto(0, $proyecto);
        $data = array();

        if (!is_numeric($this->m_historias->crear_historia_extra($nombre, $descripcion, $prioridad, $puntos_de_historia, $entregable, $proyecto, $iteracion_cero))) {
            $data["mensaje"] = "Historia no creada, la prioridad es igual a otra historia en el mismo proyecto";
            $this->load->view('base/mensaje', $data);
        } else {
            redirect('historias');
        }
    }

    public function editar_historia() {
        $this->load->model('m_historias');

        $id = $this->uri->segment(3);
        $nombre = $this->input->post("nombre");
        $descripcion = $this->input->post("descripcion");
        $prioridad = $this->input->post("prioridad");

        $this->m_historias->editar_historia($id, $nombre, $descripcion, $prioridad);
        redirect('historias');
    }

    public function dividir_historia() {
        $this->load->model('m_historias');
        $this->load->model('m_iteracion');
        $this->load->model('m_dailyscrum');

        $proyecto = $this->m_proyectos->obtener_id_proyecto_activo();
        $cantidad = $encargado = $this->input->post("cantidad");

        $hijas = array();
        $idhijas = array();
        $error = false;

        for ($i = 0; $i < $cantidad; $i++) {

            $input = array(
                'nombre' => $this->input->post("nombre" . $i),
                'prioridad' => $this->input->post("prioridad" . $i),
                'puntos_de_historia' => $this->input->post("puntos_historia" . $i),
                'entregable' => $this->input->post("entregable" . $i),
                'encargado' => $this->input->post("encargado" . $i),
                'descripcion' => $this->input->post("descripcion" . $i),
            );
            $idhistoria = $this->m_historias->obtener_id_historia_proyecto_prioridad($this->m_proyectos->obtener_id_proyecto_activo(), $prioridad);

            if (empty($idhistoria)) {
                $error = true;
            } else {
                array_push($hijas, (object) $input);
            }
        }

        if (!$error) {
            foreach ($hijas as $key => $value) {
                array_push($idhijas, $this->crear_historia_hija($value->nombre, $value->descripcion, $value->prioridad, $value->puntos_de_historia, $value->entregable, $proyecto));
            }
            $idhijas = json_encode($idhijas);
            $this->m_historias->cambiar_estado_dividida($idhijas, $this->input->post("historia"));

            redirect('historias');
        } else {
            $data["mensaje"] = "Historia no dividida, la prioridad de una de las hijas es igual a otra historia en el mismo proyecto";
            $this->load->view('base/mensaje', $data);
        }
    }

    public function precisar_historia() {
        $this->load->model('m_historias');

        $id = $this->uri->segment(3);
        $puntos_historia = $this->input->post("puntos_historia");
        $entregable = $this->input->post("entregable");

        $this->m_historias->precisar_historia($id, $puntos_historia, $entregable);
        redirect('historias/historias_para_precisar');
    }

    public function confirmar_historias_iteracion() {
        $this->load->model('m_historias');
        $this->load->model('m_iteracion');
        $this->load->model('m_proyectos');
        $id = $this->m_proyectos->obtener_id_proyecto_activo();
        $iteracion = $this->m_iteracion->obtener_ultima_iteracion($id);
        $historias = $this->input->post('check');
        if (!empty($historias)) {
            for ($i = 0; $i < sizeof($historias); $i++) {
                $this->m_historias->vincular_historia_iteracion($historias[$i], $iteracion->id);
            }
            $this->m_iteracion->cambiar_estado_iteracion_actual($iteracion->id, 4);
            redirect('proyectos/admin_proyecto');
        } else {
            $data["mensaje"] = "No se ha seleccionado ningún item para la iteración";
            $this->load->view('base/mensaje', $data);
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */