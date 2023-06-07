<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/signup_style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
</head>
<body class="body">
<div class="register-page">
    <div class="form">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <img src="https://lotuskringhwg.nl/wp-content/uploads/2020/09/cropped-logo-192x192.jpg" alt="Logo" class="logo-img">
                        <br>
                        <br>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                                <input id="name" type="text"  placeholder="Voer uw naam in" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                                <input id="email" type="email" placeholder="Voer uw e-mailadres in" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="password-container">
                                <input id="password" type="password" placeholder="Voer uw wachtwoord in" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility('password', this)"></i>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="password-container">
                                <input id="password-confirm" type="password"  placeholder="Bevestig uw wachtwoord" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility('password-confirm', this)"></i>
                        </div>

                        <div class="form-group">
            
                                <input id="phoneNumber" type="text" placeholder="Voer uw telefoonnummer in" class="form-control @error('phoneNumber') is-invalid @enderror" name="phoneNumber" value="{{ old('phoneNumber') }}" required>
                                @error('phoneNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                         
                        </div>

                        <div class="form-group">
                                <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" value="{{ old('role') }}" required>
                                    <option value="">Selecteer een rol...</option>
                                    <option value="opdrachtgever" onclick="toggleExtraFields(true)">Opdrachtgever</option>
                                    <option value="coordinator" onclick="toggleExtraFields(false)">coordinator</option>
                                    <option value="lid" onclick="toggleExtraFields(false)">lid</option>
                                    <!-- Voeg hier extra rollen toe -->
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          
                        </div>

                        <!-- Velden voor opdrachtgever -->
                    <div id="extra-fields" style="display: none;">
                        <div class="form-group" id="company_name">
                
                                <input id="company_name" type="text" placeholder="Voer uw bedrijfsnaam in" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}">
                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                         
                        </div>
                        <div class="form-group" id="billing_email">
                        
                                <input id="billing_email" type="text"  placeholder="Voer uw facturatie e-mailadres in" class="form-control @error('billing_email') is-invalid @enderror" name="billing_email" value="{{ old('billing_email') }}">
                                @error('billing_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                        </div>
                        <div class="form-group" id="contact_person">
                         
                                <input id="contact_person"  placeholder="Voer de naam van de contactpersoon in" type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ old('contact_person') }}">
                                @error('contact_person')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        
                        </div>
                        <div class="form-group" id="contact_person_phone">
                                <input id="contact_person_phone" type="text" placeholder="Voer het telefoonnummer van de contactpersoon in" class="form-control @error('contact_person_phone') is-invalid @enderror" name="contact_person_phone" value="{{ old('contact_person_phone') }}">
                                @error('contact_person_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           
                        </div>
                        <div class="form-group" id="street">
                           
                                <input id="street" type="text" placeholder="Voer uw straatnaam in" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street') }}">
                                @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           
                        </div>
                        <div class="form-group" id="city">
                       
                                <input id="city" type="text" placeholder="Voer uw stad in" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}">
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           
                        </div>
                        <div class="form-group" id="postal_code">
                          
                                <input id="postal_code" type="text" placeholder="Voer uw postcode in" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message .' nnnn<spatie>MM'}}</strong>
                                    </span>
                                @enderror
                        
                        </div>
                        <div class="form-group" id="house_number">
                      
                                <input id="house_number" type="text" placeholder="Voer uw huisnummer in" class="form-control @error('house_number') is-invalid @enderror" name="house_number" value="{{ old('house_number') }}">
                                @error('house_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                       
                        </div>
                    </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

function togglePasswordVisibility(inputId, eyeIcon) {
    var passwordInput = document.getElementById(inputId);
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}

function toggleExtraFields(show) {
        var extraFields = document.getElementById("extra-fields");
        var inputs = extraFields.querySelectorAll("input");
        if (show) {
            extraFields.style.display = "block";
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].required = true;
            }
        } else {
            extraFields.style.display = "none";
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].required = false;
            }
        }
    }




window.onload = function() {
        // voeg event listeners toe aan de select element
        var roleSelect = document.getElementById('role');
        roleSelect.addEventListener('change', function() {
            if (this.value === 'opdrachtgever') {
                toggleExtraFields(true);
            } else {
                toggleExtraFields(false);
            }
        });

        // zorg dat de juiste velden worden weergegeven gebaseerd op de geselecteerde rol
        if (roleSelect.value === 'opdrachtgever') {
            toggleExtraFields(true);
        } else {
            toggleExtraFields(false);
        }
    };






</script>
</body>
</html>


{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/signup_style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600" rel="stylesheet" type="text/css" />
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
</head>

<body class="body">
    <div class="login-page">
        <div class="form">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <img src="https://lotuskringhwg.nl/wp-content/uploads/2020/09/cropped-logo-192x192.jpg" alt="Logo" class="logo-img">
                <br>
                <br>
                <input id="name" type="text" placeholder="full name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="email" type="email" placeholder="email address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="password" type="password" placeholder="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="password-confirm" type="password" placeholder="confirm password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                <i class="fas fa-eye" onclick="show()"></i>
                <br>
                <br>
                {{-- <div id="extra-fields" style="display: none;">
                    <input id="company-name" type="text" placeholder="Bedrijfsnaam" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company_name" autofocus>
                    @error('company_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input id="contact-person" type="text" placeholder="Contactpersoon" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ old('contact_person') }}" required autocomplete="contact_person" autofocus>
                    @error('contact_person')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input id="billing-address" type="text" placeholder="Factuuradres" class="form-control @error('billing_address') is-invalid @enderror" name="billing_address" value="{{ old('billing_address') }}" required autocomplete="billing_address" autofocus>
                    @error('billing_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <input id="billing-emailAddress" type="text" placeholder="Factuur E-mailadres" class="form-control @error('billing_address') is-invalid @enderror" name="billing_address" value="{{ old('billing_emailAddress') }}" required autocomplete="billing_emailAddress" autofocus>
                    @error('billing_emailAddress')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}
                {{-- <div class="radio-container">
                    <input type="radio" id="role" name="role" value="coordinator" required autocomplete="new-role" >
                    <label for="coordinator">Coordinator</label>
                    <input type="radio" id="role" name="role" value="opdrachtgever" required autocomplete="new-role" >
                    <label for="opdrachtgever">Opdrachtgever</label>
                    <input type="radio" id="role" name="role" value="lid" required autocomplete="new-role" >
                    <label for="lid">Lid</label>
                </div>
                <br>
                <button type="submit" class="btn btn-primary" >SIGN UP</button>
            </form>
        </div>
    </div>

    <script>
        function show() {
            var password = document.getElementById("password");
            var passwordConfirm=document.getElementById("password-confirm");
            var icon = document.querySelector(".fas.fa-eye");
            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } 
            if (passwordConfirm.type === "password") {
                passwordConfirm.type = "text";
            }else {
                password.type = "password";
                passwordConfirm.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
        function toggleExtraFields(show) {
            var extraFields = document.getElementById("extra-fields");
            if (show) {
                extraFields.style.display = "block";
            } else {
                extraFields.style.display = "none";
            }
        }
   
    </script>
</body>
</html>  --}}



{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
