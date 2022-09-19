
<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8" />
<style>

.clickme {
    background-color: #EEEEEE;
    padding: 8px 20px;
    text-decoration:none;
    font-weight:bold;
    border-radius:5px;
    cursor:pointer;
}

    .primary {
    background-color:#007bff;
    color: #FFFFFF;
    }
</style>

</head>
<body>

<table>
  <thead>
    <tr>
        <th>  name </th>
    </tr>
  </thead>

  <tbody>
    <tr>
        <td><div class="form-control"><p> Welcome {{$name}}</p> <br> <p><b>You need to verify your email to create a Company</b> <br> 
          <a href="{{ route('emails.emailVerificationEmail',($test_message)) }}"><button class="clickme primary">Verify</button></a> <br> Thank you for your support <br> Team AIT </p></div>
        </td>
    </tr>
  </tbody>
</table>

< /body>
< /html>