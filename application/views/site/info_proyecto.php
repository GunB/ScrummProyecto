<?php
$id_proyecto = $this->m_proyectos->obtener_id_proyecto_activo();
$proyecto = $this->m_proyectos->datos_proyecto($id_proyecto);
?>

<script src="<?php echo base_url(); ?>plugin/js/highcharts.js"></script>    
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <?php echo $menu_principal; ?>
        </div>
        <div class="span9">
            <table class="table">
                <tr>
                    <td colspan="2"><h1><?php echo $proyecto['nombre']; ?></h1></td>
                </tr>
                <tr>
                    <td>Duración</td>
                    <td><?php echo $proyecto['duracion']; ?> días</td>
                </tr>
                <tr>
                    <td>Duración de iteración</td>
                    <td><?php echo $proyecto['duracion_iteracion']; ?> días</td>
                </tr>
                <tr>
                    <td>Entidad Interesada</td>
                    <td><?php echo $proyecto['entidad']; ?></td>
                </tr>
                <tr>
                    <td>Descripción</td>
                    <td><?php echo $proyecto['descripcion']; ?></td>
                </tr>
            </table>
            <table class="table">
                <tr>
                    <td><h1><?php //echo ucfirst($datos_proyecto['nombre']); ?></h1></td>
                </tr>
                <tr>
                    <td><h3>Porcentaje de proyecto terminado:</h3> <?php echo $porcentajes['porcentaje_terminado'] . " %"; ?><br>
                        <div class="progress progress-success progress-striped">
                            <div class="bar" style="width: <?php echo $porcentajes['porcentaje_terminado'] . '%'; ?>"></div><br>
                        </div>
                        <?php
                        if ($porcentajes['estado'] == 'atrasado') {
                            echo "<div class='alert alert-error'>¡Tu equipo debe esforzarse mas! su trabajo no es acorde a sus estimados iniciales, tienes <b>" . $porcentajes['dias'] . "</b> días de retraso</div>";
                            echo "Trabaja en aumentar la velocidad de tu equipo, tal vez existen problemas de ánimo<br>";
                            echo "Las iteraciones extra siempre son una opción para ti, pero tal vez no para tu cliente";
                        } else {
                            if ($porcentajes['estado'] == 'adelantado') {
                                echo "<div class='alert alert-success'>¡Tu equipo responde muy bien! te encuentras <b>" . $porcentajes['dias'] . "</b> días por debajo de tus estimados</div>";
                                echo "¿No crees que están poniendo metas demasiado fáciles?<br><br>";
                            } else {
                                echo "<div class='alert'>Te encuentras justo dentro de tus estimaciones de tiempo</div>";
                                echo "Un poco de días bajo el estimado no estaría mal tampoco<br><br>";
                            }
                        }
                        //echo "<br><br>y = ".(-1*$porcentajes['total_puntos_historia']/$duracion_proyecto)."x + ".$porcentajes['total_puntos_historia']; 
                        ?>
                        <div id="chart1"></div>
                    </td>    
                </tr>
                <tr>
                    <td><h3>Velocidad promedio del equipo:</h3> <?php echo $velocidad_dia . " puntos de historia / día"; ?><br><?php echo $velocidad_iteracion . " puntos de historia / iteracion"; ?>
                        <br><br>
                        <div id="chartv"></div>
                    </td>    
                </tr>
                <tr>
                    <td><h3>Información de PBIs:</h3></td>    
                </tr>
                <tr><td>
<?php
if ($historias['incompleta'] > 0) {
    echo "<div class='alert'>Has fallado en terminar <b>" . $historias['incompleta'] . "</b> PBI durante tus iteraciones, apóyate en la velocidad ponderada de tu equipo y su estado de ánimo para tomar mejores decisiones</div></br><br>";
}
if ($historias['extra'] > 0) {
    echo "<div class='alert'>Has creado <b>" . $historias['extra'] . "</b> PBI que no se  tuvieron en cuenta antes de iniciar las iteraciones. Controla esto con mejores prácticas en las reuniones preliminares.<br><br></div>";
}
?>
                        <h5>Total:</h5><?php echo $historias['total']; ?>  
                        <h5>En el listado del producto:</h5><?php echo $historias['pila']; ?>  
                        <h5>En progreso:</h5><?php echo $historias['progreso'] + $historias['pendiente']; ?>    
                        <h5>Finalizados:</h5><?php echo $historias['finalizada']; ?>       
                        <h5>Divididos:</h5><?php echo $historias['dividida']; ?> ( No entra en el total )    
                        <h5>Hijos:</h5><?php echo $historias['hija']; ?></td>
                <tr>
            </table>
        </div>
    </div>
</div><!--/.fluid-container-->
<script>

    $(function() {
        $('#chart1').highcharts({
            chart: {
                type: 'line',
                zoomType: 'xy'
            },
            title: {
                text: 'Gráfica de Rendimiento'
            },
            subtitle: {
                text: 'Puntos de historia terminados en el tiempo'
            },
            xAxis: {
                title: {
                    enabled: true,
                    text: 'Días'
                },
                startOnTick: true,
                endOnTick: true,
                showLastLabel: true
            },
            yAxis: {
                title: {
                    text: 'Puntos de historia terminados'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 250,
                floating: true,
                backgroundColor: '#FFFFFF',
                borderWidth: 1
            },
            plotOptions: {
                scatter: {
                    marker: {
                        radius: 5,
                        states: {
                            hover: {
                                enabled: true,
                                lineColor: 'rgb(100,100,100)'
                            }
                        }
                    },
                    states: {
                        hover: {
                            marker: {
                                enabled: false
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br>',
                        pointFormat: '{point.x} días, {point.y} puntos de historia'
                    }
                }
            },
            series: [{
                    name: 'Puntos de por finalizar',
                    data: <?php echo $puntos_grafica_rendimiento; ?>
                }, {
                    name: 'Puntos de historia según cronograma',
                    data:
<?php

$total = $porcentajes['total_puntos_historia'];
echo '[[0,' . $total . '],[' . $duracion_proyecto . ',0]]';
?>
                }]
        });
    });

    $(function() {
        $('#chartv').highcharts({
            chart: {
                type: 'line',
                zoomType: 'xy'
            },
            title: {
                text: 'Velocidad del equipo de trabajo'
            },
            subtitle: {
                text: 'Iteraciones'
            },
            xAxis: {
                title: {
                    enabled: true,
                    text: 'Iteraciones'
                },
                startOnTick: true,
                endOnTick: true,
                showLastLabel: true
            },
            yAxis: {
                title: {
                    text: 'Velocidad (puntos de historia)'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                backgroundColor: '#FFFFFF',
                borderWidth: 1
            },
            plotOptions: {
                scatter: {
                    marker: {
                        radius: 5,
                        states: {
                            hover: {
                                enabled: true,
                                lineColor: 'rgb(100,100,100)'
                            }
                        }
                    },
                    states: {
                        hover: {
                            marker: {
                                enabled: false
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br>',
                        pointFormat: '{point.x} cm, {point.y} kg'
                    }
                }
            },
            series: [{
                    name: 'Velocidad del equipo',
                    data: <?php echo $puntos_grafica_velocidad; ?>
                }, {
                    name: 'Velocidad promedio',
                    data:
<?php
$total = $porcentajes['total_puntos_historia'];
echo '[[0,' . $velocidad_iteracion . '],[' . $cantidad_iteraciones . ',' . $velocidad_iteracion . ']]';
?>
                }]
        });
    });
</script>
