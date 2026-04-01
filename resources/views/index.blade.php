<! DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE = edge">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <title>  PDF </title>
    <! - Bootstrap5 CSS ->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

   <style>
   table, th, td {
  border: 1px solid black;
}
 th, td {
  border-color: #96D4D4;
 
}
.col1{
   width:100px;
}
.col2{
   width:500px;;
}

   </style>
</head>
<body>
    <div class = "container mt-4">
        <div class = "row">
            <div class = "col-md-8">
                <h2> Customer list </h2>
            </div>
            <div class = "col-md-4">
                <div class = "mb-4 d-flex justify-content-end">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-12">
                <table class = "table">
                    <caption> Customer list </caption>
                    <thead>
                      <tr>
                        <th scope = "col" class="col1"> First Name </th>
                        <th scope = "col" class="col1"> Last Name </th>
                        <th scope = "col" class="col1"> Email </th>
                        <th scope = "col" class="col2"> Phone No.</th>
                        <th scope = "col" class="col1"> Address</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <th  class="col1" scope = "row"> {{$product['first_name']}} </th>
                            <td class="col1" > {{$product['last_name']}} </td>
                            <td class="col1" > {{$product['email']}} </td>
                            <td class="col1" > {{$product['user_phone']}} </td>
                            <td class="col1" > {{$product['user_address']}} </td>   
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
   
    <script src = "https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity = "sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KinkN" crossorigin="anonymous"></script>
   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <script src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"> </script>
   
</body>
</html>