<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">맴버쉽 구분코드</th>
      <th scope="col">고객번호</th>
      <th scope="col">아이디</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach($customers as $customer)
    <tr>
      <th scope="row">{{ $customer->id }}</th>
      <td>{{ $customer->membership_code }}</td>
      <td>{{ $customer->user_no }}</td>
      <td>{{ $customer->user_id }}</td>
      <td>

        <a href="{{ route('admin.customer.show', $customer->id) }}" class="btn btn-primary">상세</a>

      </td>
    </tr>
    @endforeach
</tbody>
</table>

<!-- pagination -->
<div class="d-flex justify-content-center">
    {{ $customers->links() }}
</div>

</body>
</html>