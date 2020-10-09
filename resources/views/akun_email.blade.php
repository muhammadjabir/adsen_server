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
        Terimakasih telah menyelesaikan pembayaran anda, silakan untuk akses video dan jadwal kelas.
        <br>
        <br>
        Email : {{$data['email']}}
        <br>
        Password : redhunter123
        <br>
        @php
            $link = 'login';
        @endphp
        login di link berikut : 
        <a href="{{route('home.index',[$link])}}">Link Login</a>
        
        <br>
        <br>
        <table style="width:100%" class="table">
            <thead>
                <tr>
                    <th>Kelas</th>
                    <th>Jadwal</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Trainer</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>{{$data['nama']}}</td>
                 
                    <td>
                        <ul>
                            @foreach ($data['hari'] as $item)
                                <li>{{$item}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{$data['start_class']}} s/d {{$data['end_class']}}</td>
                    <td>{{$data['jam_masuk']}} s/d {{$data['jam_pulang']}}</td>
                    <td>{{$data['trainer']}}</td>
                </tr>
                
            </tbody>
        </table>
        <br>
        <br>
        Tim Redhunter Academy
    </div>
</body>
</html>