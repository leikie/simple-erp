<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        * {margin: 0px; padding: 0px}
        
        @page { margin: 0 0 0 0 }
 
        body, html { margin-bottom: 20px; font-family: sans-serif; font-size: 11px }
        /** Paper sizes **/
        body.struk        .sheet { width: 58mm; }
        body.struk .sheet        { padding: 2mm; }
        .sheet {
            box-sizing: border-box;
            page-break-after: always;
        }

        .table-print, .table-product {width: 100%; border-collapse: collapse}
        .table-product {margin-top: 15px; font-size: 9px}
        .table-product td, .table-product th {padding: 5px}
        .table-product th {text-align: center !important}

        /* .table-print td {padding: 5px} */

        .center {
            text-align: center
        }

        .header-logo {
            text-align: center;
            font-size: 10px;
            width: 100%;
            margin: auto
        }

        @media print {
            body.struk                 { width: 58mm; text-align: left}
            body.struk .sheet          { padding: 2mm; }
        }
    </style>
</head>
<body class="struk" onload="printOut()">
    <div class="container sheet">
        <table class="table-print">
            <tbody>
                <tr>
                    <td>
                        <div class="header-logo">
                            <span><img style="width: 50px" src="{{ asset('images/logo_endee.png') }}" alt="logo-jnt"></span>
                        </div>
                    </td>
                </tr>
                <tr class="border center">
                    <td>
                        <h3>#{{ $police_number }}</h3>
                    </td>
                </tr>
                <tr class="border center">
                    <td>
                        <div style="font-weight: bold">
                            <span>{{ strtoupper($user_name) }}</span>
                            <p style="margin-top: 3px;">{{ $address }} 
                            </p>
                        </div>
                    
                    </td>
                </tr>
            </tbody>
        </table>
    
        <table class="table-product">
            <tbody>
                <tr class="border" style="text-align: center">
                    <td>Tanggal Pinjam <br> {{ $loan_date }}</td>
                    <td> {{ $quantity }} hari </td>
                    <td>Tanggal Kembali <br> {{ $return_date }}</td>
                    <td>{{ $product_name }} - {{ $merk }}</td>
                    <td>{{ number_format($amount) }}</td>
                </tr>
                <tr style="text-align: center">
                    <td colspan="4"><strong>Sub Total</strong></td>
                    <td>
                        <strong>{{ $total_price }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

<script>
    var lama = 1000;
    t = null;
    function printOut() {
        window.print();
        t = setTimeout("self.close()", lama);
    }
</script>