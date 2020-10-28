<form action="https://pga.growinc.dev/webapi/pay/create" method="POST">
    {{-- @csrf --}}
    <input type="hidden" name="signature" value="{{$data->encrypt_invoice}}">
    <input type="hidden" name="merchant_code" value="PGA20MSVE">
    <input type="hidden" name="invoice_no" value="{{$data->kode_invoice}}">
    <input type="hidden" name="description" value="vla val val">
    <input type="hidden" name="amount" :value="{{$data->harga}}">
<input type="hidden" name="customer_name" value="{{$data->nama}}">
    <input type="hidden" name="customer_email" value="{{$data->email}}">
    <input type="hidden" name="customer_phone" value="{{$data->nohp}}">
    <input type="hidden" name="redirect_url" value="https://development.codehunter.academy/api/v1/payment/courses">
    <input type="hidden" name="expired" value="24">
    <input type="submit" value="Create">
</form>