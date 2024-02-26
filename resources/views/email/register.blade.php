<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        label {
    font-weight: 600;
    color: #666;
}
body {
  background: #f1f1f1;
}
.box8{
  box-shadow: 0px 0px 5px 1px #999;
}
.mx-t3{
  margin-top: -3rem;
}

</style>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css"></script>

</head>
<body>
    <div class="container mt-3">
        <form method="post" action="{{route('send-email-post')}}">
            @csrf
          <div class="row jumbotron box8">
            <div class="col-sm-12 mb-4">
              <h2 class="text-center text-info">Register As Merchant</h2>
            </div>
            <div class="col-sm-6 form-group">
              <label for="name-f">Your Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name." required>
            </div>


            <div class="col-sm-6 form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email." required>
              </div>


              <div class="col-sm-6 form-group">
                <label for="address-1">Phone</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Your Contact Number." required maxlength="10" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/(\..*?)\..*/g,'$1');" >
              </div>
             

            <div class="col-sm-6 form-group">
              <label for="name-l">Business Name</label>
              <input type="text" class="form-control" id="business" name="business" placeholder="Enter your Business name." required>
            </div>

            <div class="col-sm-12 form-group mb-0">
            <button class="btn btn-secondary float-right ml-3" type="reset">Cancel</button>
              <button class="btn btn-primary float-right">Submit</button>
            </div>
      
          </div>
        </form>
    </div>
</body>

   


</html>