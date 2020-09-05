<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            margin: 0;
            padding: 0;
           
        }
        .container{
            padding: 20px 30px 20px 30px;
           width: 700px;
           margin: 0 auto;
        }
        .logo{
            height: 150px;
        }
        .header table p {
            font-size: 12px;
            margin-left: 5%;
            margin-top: -5%; 
        }

        .pilihan table{
            border-collapse: collapse;
            width: 100%;
        }

        .plihan table, .pilihan th, .pilihan td {
        border: 1px solid none;
        text-align: center;
        }
        .pilihan th {
            padding: 15px;
            color: white;
            background-color: #c80a00;
        }
        .pilihan td {
            padding: 15px;
        }

        .header table h2 {
            background-color: #c80a00;
            color: white;
            padding: 10px;
           
        }
        .header {
        }

        .info td {
            padding: 8px;
        }

        .bank {
            display: flex;
        }
        .atm{
            margin: auto;
        }
        .bg-invoice {
            margin-left: 25%; 
            margin-top: -50%;
            width: 350px;
            z-index: -1;
        }
        
    </style>
</head>
<body>
    <style>
        body{
            margin: 0;
            padding: 0;
           
        }
        .container{
            padding: 20px 30px 20px 30px;
           width: 700px;
           margin: 0 auto;
           position: relative !important;
        }
        .logo{
            position: relative !important;
            height: 150px;
        }
        .header table p {
            position: relative;
            font-size: 12px;
            left: 5%;
            top: 50%;
            margin-top: -5%; 
        }

        .pilihan table{
            border-collapse: collapse;
            width: 100%;
        }

        .plihan table, .pilihan th, .pilihan td {
        border: 1px solid none;
        text-align: left;
        }
        .pilihan th {
            padding: 15px;
            color: white;
            background-color: #c80a00;
        }
        .pilihan td {
            padding: 15px;
        }

        .header table h3 {
            background-color: #c80a00;
            color: white;
            padding: 10px;
           
        }
        .header {
            position: relative !important;
        }

        .info td {
            padding: 8px;
        }

        .bank {
            display: flex;
        }
        .atm{
            margin: auto;
        }
        .bg-invoice {
            position: relative !important;
            top: 30%;
            left: 25%;
            margin-top: -50%;
            width: 350px;
            z-index: -1;
        }
        
    </style>
    <div class="container" >
        <div class="header">
            <table style="width: 100%">
                <tr>
                    <td>
                        <img src="https://redhunter.id/wp-content/uploads/2020/01/logo-redhunter-background-putih.png" alt="" width="300px">
                        <p> Ruko Sedayu Square Blok K No 03, <br>
                        Jl. Outer Ring Road Cengkareng, Jakarta Barat <br>
                        Daerah Khusus Ibukota Jakarta 11730</p>
                    </td>
                    <td>
                        <h3 style="float: right">Nomor Tagihan : RH/{{$data->kode_invoice}}</h3>
                    </td>
                </tr>
            </table>
    
        </div>
       
        <div class="info">
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td>: {{$data->nama}}</td>
                        <td style="text-align: right">Nomor Pendaftaran :</td>
                        <td style="text-align: right">20200892</td>
                    </tr>

                    <tr>
                        <td>No HP</td>
                        <td>: {{$data->nohp}}</td>
                        <td style="text-align: right">Tgl Order :</td>
                        <td style="text-align: right">28-06-2020</td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td>: {{$data->email}}</td>
                        <td style="text-align: right">Batas Pembayaran :</td>
                        <td style="text-align: right !important">30-06-2020</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pilihan">
            <table>
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>Kursus</th>
                        <th style="text-align: right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid black">
                        <td style="width: 30%"><strong>{{$data->kelas_pilihan->name}}</strong> </td>
                        <td style="width: 30%">{{$data->kelas_pilihan->courses->name}}</td>
                        <td style="width: 30%;text-align: right">Rp. {{number_format($data->harga,0)}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right"> <strong>Diskon</strong> </td>
                        <td style="text-align: right">{{$data->diskon}}%</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right" ><strong>Potongan</strong> </td>
                        <td style="text-align: right" >Rp. {{number_format(($data->harga * ($data->diskon/100)),0)}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right" ><strong style="color: #c80a00">Total</strong> </td>
                        <td style="text-align: right;color:#c80a00" ><strong> Rp. {{number_format($data->harga - ($data->harga * ($data->diskon/100)),0)}}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- $data->harga - ($data->harga * ($data->diskon/100)) --}}
        <p>Pembayaran Via :</p>
        <div class="transfer">
            <table style="width: 100%">
                <tr >
                    <td style="text-align: center"><img src="https://redhunter.id/wp-content/uploads/2020/01/logo_tokopedia-1.png" alt="" width="180px"></td>
                    <td  style="text-align: center"><img src="https://redhunter.id/wp-content/uploads/2020/01/logo_bukalapak-1.png" alt="" width="180px"></td>
                    <td  style="text-align: center"><img src="https://redhunter.id/wp-content/uploads/2020/01/logo_nusapay-2.png" alt="" width="180px"></td>
                </tr>
            </table>
        </div>

        {{-- <img src="https://redhunter.id/wp-content/uploads/2020/01/logo-redhunter-red.png" class="bg-invoice"  style="opacity: 0.1;" alt=""> --}}

        <p>*Silahkan Konfirmasi Pembayaran ke Email ini</p>

    </div>
</body>
</html>