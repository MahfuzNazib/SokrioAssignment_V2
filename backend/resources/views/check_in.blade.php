<h2>Employee Check In Email Notification</h2>
<table class="table table-bordered">
    <tr>
        <td><strong>Employee Name</strong></td>
        <td>{{ $data['emp_name'] }}</td><br>
        
        <td><strong>Date</strong></td>
        <td>{{ $data['date'] }}</td><br>

        <td><strong>Check In Time</strong></td>
        <td>{{$data['check_in']}}</td><br>
    </tr>
</table>