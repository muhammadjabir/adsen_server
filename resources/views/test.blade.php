<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
            padding: 10px;
            color: white;
            background-color: #c80a00;
        }
        .pilihan td {
            padding: 10px;
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
                        <h2 style="float: right">RH/sdds</h2>
                    </td>
                </tr>
            </table>
    
        </div>
       
        <div class="info">
            <table>
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td>: </td>
                    </tr>

                    <tr>
                        <td>No HP</td>
                        <td>: </td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td>: </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pilihan">
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>KELAS</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1.</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p>Transfer Via :</p>
        <div class="bank">
            <div class="atm">
                <p>BCA</p>
                <p>A/C : 1213131313</p>
                <p>A/N : 3243243242</p>
            </div>
            <div class="atm">
                <p>BCA</p>
                <p>A/C : 1213131313</p>
                <p>A/N : 3243243242</p>
            </div>
            <div class="atm">
                <p>BCA</p>
                <p>A/C : 1213131313</p>
                <p>A/N : 3243243242</p>
            </div>
        </div>

        <img src="https://redhunter.id/wp-content/uploads/2020/01/logo-redhunter-red.png" class="bg-invoice"  style="opacity: 0.1;" alt="">

        <p>*Silahkan Konfirmasi Pembayaran ke Email ini</p>

    </div>
</body>
</html>