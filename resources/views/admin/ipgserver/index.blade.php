<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>IPG Server List</title>
</head>
<body>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">서버명</th>
      <th scope="col">서버위치</th>
      <th scope="col">아이피 주소</th>
      <th scope="col">유형</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach($ipgServers as $ipgServer)
    <tr>
      <th scope="row">{{ $ipgServer->id }}</th>
      <td>{{ $ipgServer->server_name }}</td>
      <td>{{ $ipgServer->server_position }}</td>
      <td>{{ $ipgServer->ip_address }}</td>
      <td>{{ $ipgServer->transaction_type }}</td>
      <td>

        <a href="{{ route('admin.ipgserver.show', $ipgServer->id) }}" class="btn btn-primary">상세</a>

      </td>
    </tr>
    @endforeach
</tbody>
</table>

<!-- pagination -->
<div class="d-flex justify-content-center">
    {{ $ipgServers->links() }}
</div>

</body>
</html>