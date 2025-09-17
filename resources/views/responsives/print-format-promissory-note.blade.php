<?php

function unidad($numuero){

    switch ($numuero){

        case 9:

        {

            $numu = "NUEVE";

            break;

        }

        case 8:

        {

            $numu = "OCHO";

            break;

        }

        case 7:

        {

            $numu = "SIETE";

            break;

        }

        case 6:

        {

            $numu = "SEIS";

            break;

        }

        case 5:

        {

            $numu = "CINCO";

            break;

        }

        case 4:

        {

            $numu = "CUATRO";

            break;

        }

        case 3:

        {

            $numu = "TRES";

            break;

        }

        case 2:

        {

            $numu = "DOS";

            break;

        }

        case 1:

        {

            $numu = "UNO";

            break;

        }

        case 0:

        {

            $numu = "";

            break;

        }

    }

    return $numu;

}

function decena($numdero){

    if ($numdero >= 90 && $numdero <= 99)

    {

        $numd = "NOVENTA ";

        if ($numdero > 90)

            $numd = $numd."Y ".(unidad($numdero - 90));

    }

    else if ($numdero >= 80 && $numdero <= 89)

    {

        $numd = "OCHENTA ";

        if ($numdero > 80)

            $numd = $numd."Y ".(unidad($numdero - 80));

    }

    else if ($numdero >= 70 && $numdero <= 79)

    {

        $numd = "SETENTA ";

        if ($numdero > 70)

            $numd = $numd."Y ".(unidad($numdero - 70));

    }

    else if ($numdero >= 60 && $numdero <= 69)

    {

        $numd = "SESENTA ";

        if ($numdero > 60)

            $numd = $numd."Y ".(unidad($numdero - 60));

    }

    else if ($numdero >= 50 && $numdero <= 59)

    {

        $numd = "CINCUENTA ";

        if ($numdero > 50)

            $numd = $numd."Y ".(unidad($numdero - 50));

    }

    else if ($numdero >= 40 && $numdero <= 49)

    {

        $numd = "CUARENTA ";

        if ($numdero > 40)

            $numd = $numd."Y ".(unidad($numdero - 40));

    }

    else if ($numdero >= 30 && $numdero <= 39)

    {

        $numd = "TREINTA ";

        if ($numdero > 30)

            $numd = $numd."Y ".(unidad($numdero - 30));

    }

    else if ($numdero >= 20 && $numdero <= 29)

    {

        if ($numdero == 20)

            $numd = "VEINTE ";

        else

            $numd = "VEINTI".(unidad($numdero - 20));

    }

    else if ($numdero >= 10 && $numdero <= 19)

    {

        switch ($numdero){

        case 10:

        {

            $numd = "DIEZ ";

            break;

        }

        case 11:

        {

            $numd = "ONCE ";

            break;

        }

        case 12:

        {

            $numd = "DOCE ";

            break;

        }

        case 13:

        {

            $numd = "TRECE ";

            break;

        }

        case 14:

        {

            $numd = "CATORCE ";

            break;

        }

        case 15:

        {

            $numd = "QUINCE ";

            break;

        }

        case 16:

        {

            $numd = "DIECISEIS ";

            break;

        }

        case 17:

        {

            $numd = "DIECISIETE ";

            break;

        }

        case 18:

        {

            $numd = "DIECIOCHO ";

            break;

        }

        case 19:

        {

            $numd = "DIECINUEVE ";

            break;

        }

        }

    }

    else $numd = unidad($numdero);
    return $numd;

}


function centena($numc){

    if ($numc >= 100)

    {

        if ($numc >= 900 && $numc <= 999)

        {

            $numce = "NOVECIENTOS ";

            if ($numc > 900)

                $numce = $numce.(decena($numc - 900));

        }

        else if ($numc >= 800 && $numc <= 899)

        {

            $numce = "OCHOCIENTOS ";

            if ($numc > 800)

                $numce = $numce.(decena($numc - 800));

        }

        else if ($numc >= 700 && $numc <= 799)

        {

            $numce = "SETECIENTOS ";

            if ($numc > 700)

                $numce = $numce.(decena($numc - 700));

        }

        else if ($numc >= 600 && $numc <= 699)

        {

            $numce = "SEISCIENTOS ";

            if ($numc > 600)

                $numce = $numce.(decena($numc - 600));

        }

        else if ($numc >= 500 && $numc <= 599)

        {

            $numce = "QUINIENTOS ";

            if ($numc > 500)

                $numce = $numce.(decena($numc - 500));

        }

        else if ($numc >= 400 && $numc <= 499)

        {

            $numce = "CUATROCIENTOS ";

            if ($numc > 400)

                $numce = $numce.(decena($numc - 400));

        }

        else if ($numc >= 300 && $numc <= 399)

        {

            $numce = "TRESCIENTOS ";

            if ($numc > 300)

                $numce = $numce.(decena($numc - 300));

        }

        else if ($numc >= 200 && $numc <= 299)

        {

            $numce = "DOSCIENTOS ";

            if ($numc > 200)

                $numce = $numce.(decena($numc - 200));

        }

        else if ($numc >= 100 && $numc <= 199)

        {

            if ($numc == 100)

                $numce = "CIEN ";

            else

                $numce = "CIENTO ".(decena($numc - 100));

        }

    }

    else

        $numce = decena($numc);


    return $numce;

}

function miles($nummero){

    if ($nummero >= 1000 && $nummero < 2000){

        $numm = "MIL ".(centena($nummero%1000));

    }

    if ($nummero >= 2000 && $nummero <10000){

        $numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));

    }

    if ($nummero < 1000)

        $numm = centena($nummero);


    return $numm;

}

function decmiles($numdmero){

    if ($numdmero == 10000)

        $numde = "DIEZ MIL";

    if ($numdmero > 10000 && $numdmero <20000){

        $numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));

    }

    if ($numdmero >= 20000 && $numdmero <100000){

        $numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));

    }

    if ($numdmero < 10000)

        $numde = miles($numdmero);


    return $numde;

}


function cienmiles($numcmero){

    if ($numcmero == 100000)

        $num_letracm = "CIEN MIL";

    if ($numcmero >= 100000 && $numcmero <1000000){

        $num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));

    }

    if ($numcmero < 100000)

        $num_letracm = decmiles($numcmero);

    return $num_letracm;

}

function millon($nummiero){

    if ($nummiero >= 1000000 && $nummiero <2000000){

        $num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));

    }

    if ($nummiero >= 2000000 && $nummiero <10000000){

        $num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));

    }

    if ($nummiero < 1000000)

        $num_letramm = cienmiles($nummiero);


    return $num_letramm;

}

function decmillon($numerodm){

    if ($numerodm == 10000000)

        $num_letradmm = "DIEZ MILLONES";

    if ($numerodm > 10000000 && $numerodm <20000000){

        $num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));

    }

    if ($numerodm >= 20000000 && $numerodm <100000000){

        $num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));

    }

    if ($numerodm < 10000000)

        $num_letradmm = millon($numerodm);


    return $num_letradmm;

}

function cienmillon($numcmeros){

    if ($numcmeros == 100000000)

        $num_letracms = "CIEN MILLONES";

    if ($numcmeros >= 100000000 && $numcmeros <1000000000){

        $num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));

    }

    if ($numcmeros < 100000000)

        $num_letracms = decmillon($numcmeros);

    return $num_letracms;

}

function milmillon($nummierod){

    if ($nummierod >= 1000000000 && $nummierod <2000000000){

        $num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));

    }

    if ($nummierod >= 2000000000 && $nummierod <10000000000){

        $num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));

    }

    if ($nummierod < 1000000000)

        $num_letrammd = cienmillon($nummierod);


    return $num_letrammd;

}

function convertir($numero){
    $num = str_replace(",","",$numero);
    $num = number_format($num,2,'.','');
    $cents = substr($num,strlen($num)-2,strlen($num)-1);
    $num = (int)$num;
    $numf = milmillon($num);
    return "" . $numf . " " . $cents . "/100";
}



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
    return $nombredia . " " . $numeroDia." de ".$nombreMes." del ".$anio;
}
    
?>

<!DOCTYPE html>
<html lang="es_MX">
    <head>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;600;900&display=swap');
        </style>
        <style type="text/css">
            body {
                font-family: 'Montserrat', sans-serif !important;
                font-size: 12pt;
            }

            table, th, td {
                border: 1px solid #c0c0c0;
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

        </style>
        <script>
            var numeroALetras = (function() {
                // Código basado en el comentario de @sapienman
                // Código basado en https://gist.github.com/alfchee/e563340276f89b22042a
                function Unidades(num) {

                    switch (num) {
                        case 1:
                            return 'UN';
                        case 2:
                            return 'DOS';
                        case 3:
                            return 'TRES';
                        case 4:
                            return 'CUATRO';
                        case 5:
                            return 'CINCO';
                        case 6:
                            return 'SEIS';
                        case 7:
                            return 'SIETE';
                        case 8:
                            return 'OCHO';
                        case 9:
                            return 'NUEVE';
                    }

                    return '';
                } //Unidades()

                function Decenas(num) {

                    let decena = Math.floor(num / 10);
                    let unidad = num - (decena * 10);

                    switch (decena) {
                        case 1:
                            switch (unidad) {
                                case 0:
                                    return 'DIEZ';
                                case 1:
                                    return 'ONCE';
                                case 2:
                                    return 'DOCE';
                                case 3:
                                    return 'TRECE';
                                case 4:
                                    return 'CATORCE';
                                case 5:
                                    return 'QUINCE';
                                default:
                                    return 'DIECI' + Unidades(unidad);
                            }
                        case 2:
                            switch (unidad) {
                                case 0:
                                    return 'VEINTE';
                                default:
                                    return 'VEINTI' + Unidades(unidad);
                            }
                        case 3:
                            return DecenasY('TREINTA', unidad);
                        case 4:
                            return DecenasY('CUARENTA', unidad);
                        case 5:
                            return DecenasY('CINCUENTA', unidad);
                        case 6:
                            return DecenasY('SESENTA', unidad);
                        case 7:
                            return DecenasY('SETENTA', unidad);
                        case 8:
                            return DecenasY('OCHENTA', unidad);
                        case 9:
                            return DecenasY('NOVENTA', unidad);
                        case 0:
                            return Unidades(unidad);
                    }
                } //Unidades()

                function DecenasY(strSin, numUnidades) {
                    if (numUnidades > 0)
                        return strSin + ' Y ' + Unidades(numUnidades)

                    return strSin;
                } //DecenasY()

                function Centenas(num) {
                    let centenas = Math.floor(num / 100);
                    let decenas = num - (centenas * 100);

                    switch (centenas) {
                        case 1:
                            if (decenas > 0)
                                return 'CIENTO ' + Decenas(decenas);
                            return 'CIEN';
                        case 2:
                            return 'DOSCIENTOS ' + Decenas(decenas);
                        case 3:
                            return 'TRESCIENTOS ' + Decenas(decenas);
                        case 4:
                            return 'CUATROCIENTOS ' + Decenas(decenas);
                        case 5:
                            return 'QUINIENTOS ' + Decenas(decenas);
                        case 6:
                            return 'SEISCIENTOS ' + Decenas(decenas);
                        case 7:
                            return 'SETECIENTOS ' + Decenas(decenas);
                        case 8:
                            return 'OCHOCIENTOS ' + Decenas(decenas);
                        case 9:
                            return 'NOVECIENTOS ' + Decenas(decenas);
                    }

                    return Decenas(decenas);
                } //Centenas()

                function Seccion(num, divisor, strSingular, strPlural) {
                    let cientos = Math.floor(num / divisor)
                    let resto = num - (cientos * divisor)

                    let letras = '';

                    if (cientos > 0)
                        if (cientos > 1)
                            letras = Centenas(cientos) + ' ' + strPlural;
                        else
                            letras = strSingular;

                    if (resto > 0)
                        letras += '';

                    return letras;
                } //Seccion()

                function Miles(num) {
                    let divisor = 1000;
                    let cientos = Math.floor(num / divisor)
                    let resto = num - (cientos * divisor)

                    let strMiles = Seccion(num, divisor, 'UN MIL', 'MIL');
                    let strCentenas = Centenas(resto);

                    if (strMiles == '')
                        return strCentenas;

                    return strMiles + ' ' + strCentenas;
                } //Miles()

                function Millones(num) {
                    let divisor = 1000000;
                    let cientos = Math.floor(num / divisor)
                    let resto = num - (cientos * divisor)

                    let strMillones = Seccion(num, divisor, 'UN MILLON DE', 'MILLONES DE');
                    let strMiles = Miles(resto);

                    if (strMillones == '')
                        return strMiles;

                    return strMillones + ' ' + strMiles;
                } //Millones()

                return function NumeroALetras(num, currency) {
                    currency = currency || {};
                    let data = {
                        numero: num,
                        enteros: Math.floor(num),
                        centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
                        letrasCentavos: '',
                        letrasMonedaPlural: currency.plural || 'PESOS CHILENOS', //'PESOS', 'Dólares', 'Bolívares', 'etcs'
                        letrasMonedaSingular: currency.singular || 'PESO CHILENO', //'PESO', 'Dólar', 'Bolivar', 'etc'
                        letrasMonedaCentavoPlural: currency.centPlural || 'CHIQUI PESOS CHILENOS',
                        letrasMonedaCentavoSingular: currency.centSingular || 'CHIQUI PESO CHILENO'
                    };

                    if (data.centavos > 0) {
                        data.letrasCentavos = 'CON ' + (function() {
                            if (data.centavos == 1)
                                return Millones(data.centavos) + ' ' + data.letrasMonedaCentavoSingular;
                            else
                                return Millones(data.centavos) + ' ' + data.letrasMonedaCentavoPlural;
                        })();
                    };

                    if (data.enteros == 0)
                        return 'CERO ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos;
                    if (data.enteros == 1)
                        return Millones(data.enteros) + ' ' + data.letrasMonedaSingular + ' ' + data.letrasCentavos;
                    else
                        return Millones(data.enteros) + ' ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos;
                };

            })();
        </script>
    </head>
    <body>
        @if( isset($data) )

        <!--img src="css/logo2.png" style="filter:alpha(opacity=10); opacity:.1; margin-top:155px" /-->
        <div class="texto-encima">

            <h4 class="text-center">Pagaré</h4>
            
            <p class="text-justify">La cantidad de $ {{ number_format($data->amount,2) ?? '' }} ( {{ convertir($data->amount) }} M.N.)</p>
            <p class="text-justify">Por este Pagare, C. <span class="font-bold underline"> {{ $data->responsive->employment->employee->full_name ?? '' }} </span> (en lo sucesivo el “Suscriptor y/o Deudor”), una persona física de nacionalidad mexicana, con domicilio en: <span class="font-bold underline"> {{ $data->responsive->employment->employee->address ?? '' }} </span>

            @if( $data->responsive->type == 'MULTI' )
                @foreach( $data->responsive->employments as $item )
                    <span>C. <span class="font-bold underline"> {{ $item->data->employee->full_name ?? '' }} </span> (en lo sucesivo el “Deudor”), una persona física de nacionalidad mexicana, con domicilio en: <span class="font-bold underline"> {{ $item->data->employee->address ?? '' }} </span></span>
                @endforeach
            @endif

            . PROMETE INCONDICIONALMENTE PAGAR a la orden de <b>SERVICIOS CORPORATIVOS QUANTUM DE OCCIDENTE, S.C.</b> una persona moral de nacionalidad mexicana (en lo sucesivo “El Tenedor”), con domicilio legal en; <b>BELISARIO DOMINGUEZ No. 30 COL. CENTRO Morelia, Michoacán</b>, LA SUERTE PRINCIPAL, precisamente el día ______ de ______________ 20_____  (en lo sucesivo “la Fecha de Pago”).</p>
            <p class="text-justify">Intereses. En el evento de que el Suscriptor incurra en mora respecto del pago oportuno de la Suerte Principal de la Fecha de Pago, se causaran a partir del día siguiente, Intereses Moratorios a una tasa del 4%( cuatro por ciento) mensual, sobre la suerte principal o saldos insolutos, los cuales se generaran en su caso hasta en tanto la Suerte Principal quede íntegramente cubierta a favor del Tenedor, sin perjuicio del pago de los intereses ordinarios en materia mercantil, a razón del 4%( cuatro por ciento) anual sobre la cantidad principal.</p>
            <p class="text-justify">Todo pago de la Suerte Principal, de intereses ordinarios, y en su caso de los moratorios, que se deriven del presente pagare se hará en el domicilio del Tenedor.</p>
            <p class="text-justify">Aplicación de Pagos. Cualesquiera pagos efectuados por el Suscriptor a favor del Tenedor, se aplicarán estrictamente y sin excepción o condición alguna, para cubrir los importes que a tales fechas se adeuden por concepto de interese moratorios y por último cubrir la Suerte Principal.</p>
            <p class="text-justify">Jurisdicción y Ley.  Para todo lo relativo a la interpretación, cumplimiento o requerimiento judicial de las obligaciones contraídas conforme a este Pagare, el Suscriptor se somete irrevocablemente y expresamente a la jurisdicción de los tribunales competentes en la ciudad de Morelia, Michoacán de Ocampo, México, renunciando a cualquier otro fuero que por razón de su domicilio presente o futuro o por cualquier otra causa pudiere corresponderle.</p>
            <p class="text-justify">Este Pagare se interpretará y regirá de acuerdo a las Leyes de los Estados Unidos Mexicanos.</p>
            <p class="text-justify">Este Pagare consta de 1(una) página por el anverso, se suscribe y se entrega el día {{ fechaCastellano($data->responsive->start_at) }}, Morelia, Michoacán, México.</p>
            <br>
            <p style=" text-align: justify;margin-bottom:10px"><b>El Suscriptor</b></p>
            <p style=" text-align: justify;margin-bottom:10px"><b>C.  __________________________________________</b></p>
            <p style=" text-align: justify;margin-bottom:10px">Firma: <b> ______________________________________</b></p>

            @if( $data->responsive->type == 'MULTI' )

                <p style="">RESPONSABLES ADICIONALES</p>
                    
                @foreach( $data->responsive->employments as $item )
                <p style=" text-align: justify;margin-bottom:10px"><b>C.  __________________________________________</b></p>
                <p style=" text-align: justify;margin-bottom:10px">Firma: <b> ______________________________________</b></p>

                @endforeach

            @endif


            <!--table>
                <tbody>
                    <tr>
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
                    
                    @foreach( $data->responsive->employments as $item )
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
            </table-->
        </div>

        @else
            no hay datos
        @endif
    </body>
</html>
