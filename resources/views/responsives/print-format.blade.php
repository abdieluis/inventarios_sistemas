<?php

    function fechaCastellano ($fecha) {
        $fecha = substr($fecha, 0, 10);
        $numeroDia = date('d', strtotime($fecha));
        $dia = date('l', strtotime($fecha));
        $mes = date('F', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
        return $numeroDia." de ".$nombreMes." del ".$anio;
    }

?>

<!DOCTYPE html>
<html lang="es_MX">
    <head>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;600;900&display=swap');
        </style>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <style type="text/css">
            body {
                font-family: 'Montserrat', sans-serif !important;
                font-size: 12pt;
            }

            table, th, td {
                border: 1px solid #dadada;
                border-collapse: collapse;
            }

            td {
                padding-left: 6px;
                padding-right: 6px;
                padding-top: 3px;
                padding-bottom: 3px;
            }

            .text-center {
                text-align: center;
            }
            .text-justify {
                text-align: justify;
            }

            .font-bold {
                font-weight: 600;

            }
            .underline {
                text-decoration: underline;
            }

            .check {
                display: inline-block;
                width: 12pt;
                height: 12pt;
                border: 1px solid #888;
                padding: 3pt;
                margin-left: 4pt;
                margin-right: 8pt;
                margin: auto;
                text-align: center;
            }

            .uppercase {

            }

            .watermark-image {
                max-width: 90%;
                position: fixed;
                margin: auto;
                opacity: 0.1;
            }

            .equipment-table {
                border: none;
            }

        </style>
    </head>
    <body>
        @if( isset($data) )

        <div class="texto-encima">

            <div class="">
                <p style="text-align: right;">
                <span style="color: red; letter-spacing: 1px; margin-bottom: 1rem;">FOLIO: {{ str_pad( $data->id, 7, "0", STR_PAD_LEFT) }}</span><br/>
                Morelia, Michoacán, {{ fechaCastellano($data->start_at) }}</p>
            </div>

            <h4 class="uppercase">
                SERVICIOS CORPORATIVOS QUANTUM DE OCCIDENTE, S.C.<br/>
                BELISARIO DOMINGUEZ No. 30 COL. CENTRO<br/>
                MORELIA, MICHOACÁN<br/>
                RFC: SCQ1212149P0<br/>
            </h4>

            <h3 class="text-center">CARTA RESPONSIVA DE EQUIPO DE COMPUTO</h3>

            <p style="font-size: 0.85rem;" class="text-justify">Por medio de la presente, hago constar que recibí el siguiente equipo de computo para uso del desempeño de mis funciones y actividades asignadas en el área de <span class="font-bold underline">{{ $data->employment->area->name ?? '' }}</span>, <b>empleado</b> de la empresa <span class="font-bold underline">{{ $data->employment->branch->name ?? '' }}</span></p>

            <p style=" text-align: justify; font-size: 0.85rem;">Características del equipo son:</p>

            <!--ul>
                <li>
                    <p style=" text-align: justify; margin-left:20px;margin-top:27px">o	Activo fijo: <u> '.str_pad($placa, 7, '0', STR_PAD_LEFT).' </u></p>
                </li>
                <li>
                    <p style=" text-align: justify; margin-left:20px;margin-top:20px">o Marca: <u> '.$marca.' </u></p>
                </li>
                <li>
                    <p style=" text-align: justify; margin-left:20px;margin-top:20px">o Modelo: <u> '.$modelo.' </u></p>
                </li>
                <li>
                    <p style=" text-align: justify; margin-left:20px;margin-top:20px">o Accesorios: <u> '.$accesorios.' </u></p>
                </li>
                <li>
                    <p style=" text-align: justify; margin-left:20px;margin-top:20px">o No. Serie: <u> '.$serie.' </u></p>
                </li>
                <li>
                    <p style=" text-align: justify; margin-left:20px;margin-top:20px">o Procesador: <u> '.$procesador.' </u></p>
                </li>
                <li>
                    <p style=" text-align: justify; margin-left:20px;margin-top:20px">o Memoria RAM: <u> '.$ram.' </u></p>
                </li>
                <li>
                    <p style=" text-align: justify; margin-left:20px;margin-top:20px">o Disco duro: <u> '.$disco.' </u></p>
                </li>
                <li>
                    <p style=" text-align: justify; margin-left:20px;margin-top:20px">o Condiciones del equipo:   Nuevo _______     Usado _______</p>
                </li>
            </ul-->

            <table width="100%" cellspacing="0" cellpadding="0" style="border: none; margin-bottom: 1rem">
                <tbody>
                    <tr>
                        @foreach( $data->equipments as $equipment )
                        <td style="border: none; vertical-align: baseline;">
                            <table width="100%" style="font-size: 0.85rem;">
                                <tr>
                                    @if( $equipment->data->id == 370 )
                                        <td colspan="2" style="text-align: center; font-weight: 600; letter-spacing: 1px; font-size: 1rem;">LINEA SIN EQUIPO</td>
                                    @else
                                        <td colspan="2" style="text-align: center; font-weight: 600; letter-spacing: 1px; font-size: 1rem;">{{ $equipment->data->category->name  ?? '' }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>No. Serie</td>
                                    <td>{{ $equipment->data->serial ?? '' }}</td>
                                </tr>

                                @if( $equipment->data->sku != NULL )
                                <tr>
                                    <td width="30%">Activo fijo</td>
                                    <td width="70%">{{ str_pad( $equipment->data->sku ?? '', 7, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                @endif

                                <tr>
                                    <td>Marca</td>
                                    <td>{{ $equipment->data->brand->name  ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Modelo</td>
                                    <td>{{ $equipment->data->model->name ?? '' }}</td>
                                </tr>

                                @if( is_iterable($equipment->data->features) )
                                    @foreach( $equipment->data->features as $feature )
                                        @if( !in_array($feature['feature_id'], ["9","10","11","20"]) )
                                        <tr>
                                            <td>{{ $db['features'][ $feature['feature_id'] ] ?? '' }}</td>
                                            <td>{{ $feature['name'] ?? '' }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @endif
                                <tr>
                                    <td>Condiciones del equipo</td>
                                    <td>{{ $equipment->data->lifecycle ?? '' }}</td>
                                </tr>
                                @if( $equipment->phoneline!=NULL )
                                <tr>
                                    <td>Linea Teléfonica</td>
                                    <td>{{ $equipment->phoneline->number ?? '' }}</td>
                                </tr>
                                @endif
                            </table>
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>

            <p style="font-size: 0.85rem;">Accesorios: {{ implode( ', ', ($data->accessories->toArray() ?? []) ) }}</p>

            <p style="text-align: justify">Notas: _________________________________________________________________________</p>

            <p><b>Situaciones Extraordinarias.</b></p>
            <p style="font-size: 0.85rem;"><b>Daño:</b> por mal manejo o imprudencia serán mi responsabilidad y asumo las consecuencias, costos que de esto se derive.</p>
            <p style="font-size: 0.85rem;"><b>Robo:</b> Se deberá de reportar al área responsable, de forma inmediata y dejar constancia mediante un acta de hechos, asumiendo las consecuencias que de ahí se deriven. </p>
            <p style="font-size: 0.85rem;"><b>Perdida:</b> Se deberá de reportar al área responsable, de forma inmediata y dejar constancia mediante un acta de hechos y pagar el costo del equipo para su reposición. </p>

            <p style="font-size: 0.85rem;"><b>Nota:</b> Al momento de entregar el equipo, ya sea por cambio o terminación de Contrato Laboral con la Empresa, éste deberá entregarse en óptimas condiciones físicas y bajo ninguna circunstancia el trabajador podrá eliminar la copia de seguridad de la información que se genere en el mismo, de lo contrario se aplicara el uso del pagare correspondiente para cubrir los daños generados.</p>

            <table width="100%" cellspacing="0" cellpadding="0" style="border: none; margin-top: 6rem;">
                <tbody>
                    <tr>
                        <td width="50%" style="padding-left: 2rem; padding-rigth: 2rem; text-align: center; border: none;">
                            <p style="border-bottom: 1.4px solid #202020;">
                                {{ $data->employment->employee->full_name }}
                            </p>
                            <p>Nombre y firma del responsable</p>
                        </td>
                        <td width="50%" style="padding-left: 2rem; padding-rigth: 2rem; text-align: center; border: none;">
                            <p style="border-bottom: 1.4px solid #202020;">
                                {{ Auth::user()->name }}
                            </p>
                            <p>Nombre y firma Entrega</p>
                        </td>
                    </tr>
                </tbody>
            </table>

            @if( $data->type == 'MULTI' )
            <table width="100%" cellspacing="0" cellpadding="0" style="border: none; margin-top: 6rem;">
                <tbody>
                    <tr style="padding-top: 60px">
                        <td colspan="2" style="padding-left: 2rem; padding-rigth: 2rem; text-align: center; border: none; flex: inline; justify-content: center">
                            <p style="">RESPONSABLES ADICIONALES</p>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" style="padding-left: 2rem; padding-rigth: 2rem; text-align: center; border: none;">
                            <p style="">
                                Nombre
                            </p>
                        </td>
                        <td width="50%" style="padding-left: 2rem; padding-rigth: 2rem; text-align: center; border: none;">
                            <p style="">
                                Firma
                            </p>
                        </td>
                    </tr>

                    @foreach( $data->employments as $item )
                    <tr>
                        <td width="50%" style="padding-left: 2rem; padding-rigth: 2rem; text-align: center; border: none;">
                            <p style="border-bottom: 1.4px solid #202020;">
                                {{ $item->data->employee->full_name }}
                            </p>
                        </td>
                        <td width="50%" style="padding-left: 2rem; padding-rigth: 2rem; text-align: center; border: none;">
                            <p style="border-bottom: 1.4px solid #202020; color: transparent">.</p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif


        </div>
        @else
            no hay datos
        @endif
    </body>
</html>
