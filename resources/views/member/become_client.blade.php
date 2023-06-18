@extends('layouts.memberLayout')

@section('content')
<div class="container">
    @if (session('info'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Become a Client') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('task.submit_become_client') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="company_name" class="col-md-4 col-form-label text-md-right">{{ __('Company Name') }}</label>

                            <div class="col-md-6">
                                <input id="company_name" type="text" placeholder="Voer uw bedrijf naam in" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company_name" autofocus>

                                @error('company_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact_person" class="col-md-4 col-form-label text-md-right">{{ __('Contact Person') }}</label>

                            <div class="col-md-6">
                                <input id="contact_person" placeholder="Voer de naam van de contactpersoon in" type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ old('contact_person') }}">

                                @error('contact_person')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact_person_phone" class="col-md-4 col-form-label text-md-right">{{ __('Contact Person Phone') }}</label>

                            <div class="col-md-6">
                                <input id="contact_person_phone" type="text" placeholder="Voer het telefoonnummer van de contactpersoon in" class="form-control @error('contact_person_phone') is-invalid @enderror" name="contact_person_phone" value="{{ old('contact_person_phone') }}">

                                @error('contact_person_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="billing_email" class="col-md-4 col-form-label text-md-right">{{ __('Billing Email') }}</label>

                            <div class="col-md-6">
                                <input id="billing_email" type="text" placeholder="Voer uw facturatie e-mailadres in" class="form-control @error('billing_email') is-invalid @enderror" name="billing_email" value="{{ old('billing_email') }}">

                                @error('billing_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                            <div class="col-md-6">
                                <input id="city" type="text" placeholder="Voer uw stad in" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}">

                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="street" class="col-md-4 col-form-label text-md-right">{{ __('Street') }}</label>

                            <div class="col-md-6">
                                <input id="street" type="text" placeholder="Voer uw straatnaam in" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street') }}">

                                @error('street')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="postal_code" class="col-md-4 col-form-label text-md-right">{{ __('Postal Code') }}</label>

                            <div class="col-md-6">
                                <input id="postal_code" type="text" placeholder="Voer uw postcode in" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code') }}">

                                @error('postal_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message .' nnnn<spatie>MM'}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="house_number" class="col-md-4 col-form-label text-md-right">{{ __('House Number') }}</label>

                            <div class="col-md-6">
                                <input id="house_number" type="text" placeholder="Voer uw huisnummer in" class="form-control @error('house_number') is-invalid @enderror" name="house_number" value="{{ old('house_number') }}">

                                @error('house_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection