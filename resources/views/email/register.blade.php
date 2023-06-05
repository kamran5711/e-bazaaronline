
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-bazaar</title>
    <style>
        body{
            background-color: #F6F6F6;
            margin: 0;
            padding: 0;
        }
        
        .container{
            width: 90%;
            margin-right: auto;
            margin-left: auto;
        }
        .row{
            display: flex;
            flex-wrap: wrap;
        }
        .col-12{
            width: 50%;
            flex: 0 0 auto;
        }

    </style>

</head>
<body>

<div class="container">
    @if($template_data->mention_receiver_name === "true")
      <div class="row">
          <div class="col-12">
              <h3>Dear {{ $name }},</h3>
          </div>
      </div>
    @endif
    <div class="row">
        <div class="col-12">
          {!! $template_data->contents !!}
        </div>
    </div>
</div>

</body>
</html>
