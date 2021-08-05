@php
   $numeracion = str_replace("PRO-","", $data->numeracion);
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Proforma</title>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }
        @font-face {
            font-family: 'Arial';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url("{{ public_path('fonts/arial.ttf') }}") format("truetype");
        }
        body {
            margin: 2cm 1cm 1cm;
        }
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            text-align: center;
            line-height: 30px;
        }
        main {
            margin-top: 60px;
        }
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #02082a;
            color: white;
            text-align: center;
            line-height: 35px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }
        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 20px;
            text-align: right;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 13px;
        }

        table td.grand {
            border-top: 1px solid #5D6975;;
        }

        .row {
            display: inline-flex;
            width: 100%;
        }
        #company {
            width: 50%;
            float: right;
        }
        #customer {
            width: 100%;
        }

        #customer span {
            color: #2b303b;
            text-align: right;
            margin-right: 10px;
            font-size: 13px;
            font-weight: bold;
        }

        hr{
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<header>

    <div class="row">
        <table>
            <tr style="background: #fff">
                <td width="50%" style="background: #fff; text-align: left">
                <img src="{{ public_path('images/empresa.png') }}" alt="" width="150">
                </td>
                <td width="50%" style="background: #fff; font-size: 13px; line-height: 13px; text-align: left">

                    EMPRESA SAC <br>
                        Tu direccion de empresa <br>
                        Tel.: 042-530431 Cel.945 057 517 #9445 225 124 <br>
                        Email.: empresa@gmail.com
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; padding: 5px">
                    <strong>PROFORMA N° {{ $numeracion }}</strong>
                </td>
            </tr>
        </table>


    </div>


</header>

<main>

    <div class="row">
        <table>
            <tr style="background: #fff">
                <td width="50%" style="background: #fff; text-align: left">
                    <div id="customer">
                        <div><span>CLIENTE: </span> {{ $data->customer->razon_social }}</div>
                        <div><span>DOCUMENTO: </span> {{ $data->customer->documento }}</div>
                        <div><span>EMAIL: </span> <a href="mailto:{{ $data->customer->email }}">{{ $data->customer->email }}</a></div>
                        <div><span>FECHA EMISION: </span> {{ $data->fecha_emision }}</div>
                        <div><span>FECHA VENCIMIENTO: </span> {{ $data->fecha_vencimiento }}</div>
                    </div>
                </td>
                <td width="50%" style="background: #fff; font-size: 13px; line-height: 13px; text-align: left">

                    <div id="customer">
                        <div><span>VENDEDOR: </span> {{ $data->user->name }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <br><br>
    <table>
        <thead>
        <tr>
            <th class="service">ITEM</th>
            <th class="desc">PRODUCTO</th>
            <th>MARCA</th>
            <th>CANT.</th>
            <th>PRECIO</th>
            <th>DSCTO</th>
            <th>SUBTOTAL</th>
        </tr>
        </thead>
        <tbody>
        @php
            $i = 1;
            $subtotal = 0;
            $moneda = getSignoMoneda($data->moneda);
        @endphp
        @foreach($products as $dato)
        <tr>
            <td class="item">{{ $i++ }}</td>
            <td class="desc">{{ $dato->producto->codigo }}</td>
            <td class="brand">{{ $dato->producto->brand->name }}</td>
            <td class="qty">{{ $dato->qty }}</td>
            <td class="unit">{{ $dato->price }}</td>
            <td class="dscto">{{ $dato->descuento }}</td>
            <td class="total"> {{ $dato->importe }}</td>
        </tr>
            @php
                $subtotal = $subtotal + $dato->importe;
            @endphp
        @endforeach
        @php
            if ($data->aplica_igv == 1){
                $igv = $subtotal * 0.18;
            }else{
                $igv = 0;
            }
            $total = $subtotal + $igv;
        @endphp
        <tr>
            <td colspan="6">SUBTOTAL</td>
            <td class="total">{{ $moneda }} {{ round($subtotal, 2) }}</td>
        </tr>
        <tr>
            <td colspan="6">IGV 18%</td>
            <td class="total">{{ $moneda }} {{ $igv }} </td>
        </tr>
        <tr>
            <td colspan="6" class="grand total">TOTAL</td>
            <td class="grand total">{{ $moneda }} {{ $total }}</td>
        </tr>
        </tbody>
    </table>

</main>
<footer>
   <table style="margin-top: -50px">
       <tr>
           <td width="33%" style="background: #f2f3f4; text-align: center">
           <img src="{{ public_path('images/cuentas/bank.png') }}" alt="" width="220">  
           </td>
           <td width="33%" style="background: #f2f3f4; text-align: center">
           <img src="{{ public_path('images/cuentas/bank2.png') }}" alt="" width="220">  
           </td>
           <td width="33%" style="background: #f2f3f4; text-align: center">
           <img src="{{ public_path('images/cuentas/bank3.png') }}" alt="" width="220">  
           </td>
       </tr>
   </table>
</footer>
</body>
</html>