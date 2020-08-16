@component('mail::message')


@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
<div class="container" >
    <div class="header">
        <div class="logo">
            <img src="https://redhunter.id/wp-content/uploads/2020/01/logo-redhunter-background-putih.png" alt="" width="300px">
            <p> Ruko Sedayu Square Blok K No 03, <br>
            Jl. Outer Ring Road Cengkareng, Jakarta Barat <br>
            Daerah Khusus Ibukota Jakarta 11730</p>
        </div>

        <div class="invoice">
            <h2>RH/</h2>
        </div>

    </div>
   
    <div class="info">
        <table>
            <tbody>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
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