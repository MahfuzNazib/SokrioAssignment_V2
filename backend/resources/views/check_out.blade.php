<h2>Employee Check Out Email Notification</h2>
<table class="table table-bordered">
    <tr>
        <td><strong>Employee Name</strong></td>
        <td>{{ $data['emp_name'] }}</td><br>
        
        <td><strong>Date</strong></td>
        <td>{{ $data['date'] }}</td><br>

        <td><strong>Check Out Time</strong></td>
        <td>{{$data['check_out']}}</td><br>
    </tr>
</table>