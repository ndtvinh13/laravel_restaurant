<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="{{asset('public/backend/css/stylelogin.css')}}" />
        <title>Login</title>
    </head>
    <body>
        <div class="container-login">
            <h1>Admin Login</h1>
            <div class="error-output">
                {{-- For outputing error message --}}
                @if(Session::has('msg'))
                <span class="text-danger">*{{ Session::get('msg') }}*</span>
            </div>
            <div>
                @endif
                @foreach ($errors->all() as $allErrors)
                    <ul>
                        <li>{{$allErrors}}</li>
                    </ul>
                @endforeach
            </div>
            <div class="container">
                <form action="{{route('login')}}" method="POST">
                    @csrf
                    <!-- Username -->
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Username-Email*</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="admin_email">
                    </div>
                    <!-- Password -->
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password*</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="admin_password">
                    </div>
                    {{-- Captcha --}}
                    <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
                    <br/>
                    @if($errors->has('g-recaptcha-response'))
                    <span class="invalid-feedback" style="display:block">
                        <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                    </span>
                    @endif
                    <div class="cont-btn">
                        <button type="submit" class="btn" name="login">Log in</button>
                    </div>
                    
                </form>
            </div>
        </div>
    

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </body>
</html>