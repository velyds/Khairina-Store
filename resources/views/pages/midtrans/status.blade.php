@if ($db->status_pay == 'PENDING')
    <p>PENDING</p>
    @elseif ($db->status_pay == 'SUCCESS')
    <p>SUCCESS</p>
    @else
    <p>GAGAL</p>
@endif