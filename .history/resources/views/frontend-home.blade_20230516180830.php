<!DOCTYPE html>

<html lang="en">

<head>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <meta charset="utf-8" />
  <link rel="icon" href="%PUBLIC_URL%/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#000000" />
  <meta name="" content="" />
  <title>Product Filters</title>
  <!-- <script defer="defer" src="/assets/filter_1inova_v1.0/js/main.js"></script> -->
  <!-- <link href="/assets/filter_1inova_v1.0/css/main.css" rel="stylesheet"> -->
</head>
<body>
  <script>
    var data_json = {!! json_encode($filterData) !!};
  </script>
  </head>
  <div id="root"></div>
</body>

</html>
