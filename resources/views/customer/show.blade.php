<!DOCTYPE html>
<html>
  <head>
    <title>Customer {{ $customer->id }}</title>
  </head>
  <body>
    <h1>Customer {{ $customer->id }}</h1>
    <ul>
      <li>Name: {{ $customer->name }}</li>
      <li>Email: {{ $customer->email }}</li>
      <li>Address: {{ $customer->address }}</li>
    </ul>
  </body>
</html>