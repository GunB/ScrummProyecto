<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Proyectos extends CI_Controller {

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
    public function proyecto_creado() {
        $this->m_sesion->comprobar_sesion();

        $multiplicador = $this->input->post("multiplicador");
        $nombre = $this->input->post("nombre");
        $entidad = $this->input->post("entidad");
        $usuario = $this->m_sesion->obtener_id_sesion();
        $descripcion = $this->input->post("descripcion");


        $this->m_proyectos->crear_proyecto($nombre, $entidad, $usuario, $descripcion);
        redirect("proyectos/index");
    }

    public function index() {
        $this->listado_proyectos();
    }

    public function admin_proyecto() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');


        $this->load->view('base/body');
        $this->m_sesion->comprobar_sesion();
        // </editor-fold>
        $this->load->view('site/top-navbar');
        $this->load->model('m_historias');
        $this->load->model('m_equipo');
        $this->load->model('m_iteracion');
        $this->load->model('m_dailyscrum');

        $id = $this->m_proyectos->obtener_id_proyecto_activo();
        $estado = $this->m_proyectos->estado_proyecto($id);
        $data["datos_proyecto"] = $this->m_proyectos->obtener_proyecto_activo();

        $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);

        switch ($estado) {
            case 1:
            $data["boolequipo"] = $this->m_equipo->existe_grupo($id, 0);
            $data["boolhistorias"] = $this->m_historias->existe_historia($id);
            $data["boolprecision"] = $this->m_historias->comprobar_precision($id);
            $data["boolduracion"] = $this->m_proyectos->existe_duracion_iteracion($id);

            $this->load->view('site/portada', $data);
        break;
            case 2:
            $ultima_iteracion = $this->m_iteracion->obtener_ultima_iteracion($id);
            $estado = $this->m_iteracion->obtener_ultimo_estado_iteracion($ultima_iteracion->id);
            
            if ($estado == '1') {
                $data["ultima_iteracion"] = $ultima_iteracion->numero;
                $this->load->view('site/crear_iteracion', $data);
            } else {
                if ($estado == '2') {
                    $equipo = $this->m_equipo->obtener_equipo($ultima_iteracion->id);
                    $data["equipo_trabajo"] = $this->m_equipo->obtener_equipo_completo($id, $ultima_iteracion->id);
                    $data["datos_equipo"] = $equipo;
                    $data["ultima_iteracion"] = $ultima_iteracion->numero;
                    $this->load->view('site/seleccionar_equipo_iteracion', $data);
                } else {
                    if ($estado == '3') {
                        $id_iteracion_cero = $this->m_iteracion->obtener_id_numero_iteracion_proyecto(0, $id);
                        $data["datos_historias"] = $this->m_historias->obtener_historias_proyecto($id, $id_iteracion_cero);
                        $this->load->view('site/seleccionar_historias_iteracion', $data);
                    } else {
                        $data["iteracion"] = $ultima_iteracion;
                        $dscrums = $this->m_dailyscrum->obtener_cantidad_daily_scrums_terminados($ultima_iteracion->id);
                        $data["daily_scrums_restantes"] = $this->m_proyectos->obtener_duracion_iteracion_proyecto_activo() - $dscrums;
                        $data['historias'] = $this->m_historias->obtener_historias_iteracion($ultima_iteracion->id);
                        $data['equipo'] = $this->m_equipo->obtener_equipo($ultima_iteracion->id);
                        $iteraciones_totales = $this->m_proyectos->obtener_cantidad_iteraciones_proyecto_activo();
                        $iteraciones_restantes = intval($iteraciones_totales) - intval($data["iteracion"]->numero);
                        
                        if($iteraciones_restantes == 0){
                            $data['fin_proyecto'] = true;
                        }
                        $this->load->view('site/proyecto', $data);
                    }
                }
            }
            break;
            case 3:
                
                $this->load->view('site/proyecto-finalizado',$data);
                break;
        }
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function informacion_proyecto() {

        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');


        $this->load->view('base/body');
        $this->m_sesion->comprobar_sesion();
        // </editor-fold>
        $this->load->view('site/top-navbar');
        $this->load->model('m_equipo');
        $this->load->model('m_historias');
        $id = $this->m_proyectos->obtener_id_proyecto_activo();
        $duracion = $this->m_proyectos->obtener_duracion_iteracion_proyecto_activo();

        
        $puntos_grafica_rendimiento = json_decode($this->m_proyectos->obtener_grafica_rendimiento($id));
        $total = $this->m_historias->obtener_total_puntos_historia($id);
        
        foreach ($puntos_grafica_rendimiento as $key => $value) {
            $puntos_grafica_rendimiento[$key][1] = $total - $value[1]; 
        }
        
        $data['puntos_grafica_rendimiento'] = json_encode($puntos_grafica_rendimiento);
        $data['puntos_grafica_velocidad'] = $this->m_equipo->grafica_velocidad($id);

        $data['duracion_proyecto'] = $this->m_proyectos->obtener_duracion_proyecto_activo();
        $data['cantidad_iteraciones'] = $this->m_proyectos->obtener_cantidad_iteraciones_proyecto_activo();

        $data['porcentajes'] = $this->m_proyectos->porcentajes_proyecto($id);
        $data["velocidad_dia"] = $this->m_equipo->calcular_velocidad($id);
        $data["velocidad_iteracion"] = $data["velocidad_dia"] * $duracion;
        $data["historias"] = $this->m_historias->obtener_cantidad_historias($id);
        $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
        $data["datos_proyecto"] = $this->m_proyectos->obtener_proyecto_activo();
        $this->load->view('site/info_proyecto', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function listado_proyectos() {

        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');


        $this->load->view('base/body');
        $this->m_sesion->comprobar_sesion();
        // </editor-fold>
        $usu = $this->m_sesion->obtener_id_sesion();
        $data["datos_proyectos"] = $this->m_proyectos->proyectos_usuario($usu);
        $this->load->view('site/top-navbar');
        $this->load->view('site/dashboard', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function nuevo_proyecto() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');


        $this->load->view('base/body');
        $this->m_sesion->comprobar_sesion();
        // </editor-fold>
        $this->load->view('site/top-navbar');
        //$data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
        $this->load->view('site/crear_proyecto');
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function duracion_iteracion() {
        // <editor-fold defaultstate="collapsed" desc="header">
        $this->load->view('base/head');


        $this->load->view('base/body');
        $this->m_sesion->comprobar_sesion();
        // </editor-fold>
        $this->load->view('site/top-navbar');
        $data["datos_proyecto"] = $this->m_proyectos->obtener_proyecto_activo();
        $data["menu_principal"] = $this->load->view('site/menu-principal', '', true);
        $this->load->view('site/duracion-iteracion', $data);
        // <editor-fold defaultstate="collapsed" desc="footer">
        $this->load->view('base/foot'); // </editor-fold>
    }

    public function abrir_proyecto() {
        $id = $this->uri->segment(3);
        $datos_proyecto = $this->m_proyectos->datos_proyecto($id);
        $nombre = $datos_proyecto['nombre'];
        $entidad = $datos_proyecto['entidad'];
        $duracion = $datos_proyecto['duracion'];
        $duracion_iteracion = $datos_proyecto['duracion_iteracion'];
        $cantidad_iteraciones = $datos_proyecto['cantidad_iteraciones'];
        $this->m_proyectos->activar_proyecto($id, $nombre, $entidad, $duracion, $duracion_iteracion, $cantidad_iteraciones);
        redirect("proyectos/admin_proyecto");
    }

    public function editar_duracion_iteracion() {
        $duracion_iteracion = $this->input->post("duracion_iteracion");
        $duracion = $this->input->post("duracion");
        $multiplicador = $this->input->post("multiplicador");
        $duracion = $duracion * $multiplicador;
        $id = $this->m_proyectos->obtener_id_proyecto_activo();
        $this->m_proyectos->set_duracion($id, $duracion_iteracion, $duracion);
        redirect('proyectos/abrir_proyecto/' . $id);
    }

    public function iniciar_scrum() {
        $this->load->model('m_iteracion');
        $this->load->model('m_dailyscrum');
        $this->load->model('m_proyectos');
        $id = $this->m_proyectos->obtener_id_proyecto_activo();
        $ultima = $this->m_iteracion->obtener_ultima_iteracion($id);

        if ($ultima->numero == 0) {
            $this->m_proyectos->set_estado_en_progreso($id);
            $this->m_iteracion->cambiar_estado_iteracion_actual($ultima->id, 5);

            $this->m_iteracion->crear_iteracion($id, 1);
        } else {
            if ($this->m_dailyscrum->obtener_cantidad_daily_scrums_terminados($ultima->id) == $this->m_proyectos->obtener_duracion_iteracion_proyecto_activo()) {
                $this->m_iteracion->cambiar_estado_iteracion_actual($ultima->id, 5);
                if ($ultima->numero == $this->m_proyectos->obtener_cantidad_iteraciones_proyecto_activo()) {
                    //finalizar proyecto
                    $this->m_proyectos->set_estado_proyecto($id, 3);
                } else {
                    $nueva = $ultima->numero + 1;
                    $this->m_iteracion->crear_iteracion($id, $nueva);
                }
            } else {
                $data["mensaje"] = "No se han completado todos los daily scrums de la iteración actual";
                $this->load->view('base/mensaje', $data);
            }
        }
        redirect('proyectos/admin_proyecto');
    }

    public function grafica() {
        
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */