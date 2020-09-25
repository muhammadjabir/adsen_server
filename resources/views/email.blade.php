<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .table {
      border-collapse: collapse;
      
  }
    table, th, td {
    border: 1px solid #efefef;
    }
  .table tr td, .table tr th {
      padding: 20px;
      text-align: left;
  }
 .table tr th {
     background-color:#f5f5f5;
     color: black;
 }
    </style>
</head>
<body>
    <div class="container" >
    
        Kepada {{$data['nama']}}

        <br>
        Terimakasih Telah mendaftar di Redhunter Academy, kami dari Tim CS Redhunter Academy mendapat kabar bahwa anda ingin melakukan pembayaran Kursus yang telah disepakati.
        <br>
        <br>
        @php
            $link = 'pembayaran/courses/'.$data['encrypt_invoice'] ;
        @endphp
        untuk link pembayaran silakan klik : 
        <a href="{{route('home.index',[$link])}}">Link Pembayaran</a>
        
        <br>
        <br>
        <table style="width:100%" class="table">
            <thead>
                <tr>
                    <th>Kelas</th>
                    <th>Kategori Kursus</th>
                    <th>Kursus</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>{{$data['kelas_pilihan']}}</td>
                    <td>{{$data['category_courses']}}</td>
                    <td>
                        <ul>
                            @foreach ($data['courses'] as $item)
                                <li>{{$item->name}}</li>
                            @endforeach
                        </ul>
                        
                    </td>
                </tr>
                
            </tbody>
        </table>
        <br>
        <br>
        Tim Redhunter Academy
    </div>
</body>
</html>