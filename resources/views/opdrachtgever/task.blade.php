@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-3">Opdracht Informatie</h1>

        {{-- <form method="post" action="{{ route('opdracht.store') }}"> --}}
            @csrf
            <div class="form-group">
                <label for="opdrachtnaam">Opdrachtnaam:</label>
                <input type="text" id="opdrachtnaam" name="opdrachtnaam" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="opdrachtnummer">Opdrachtnummer:</label>
                <input type="text" id="opdrachtnummer" name="opdrachtnummer" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="datum">Datum:</label>
                <input type="date" id="datum" name="datum" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="kader_instructeur">Kader instructeur:</label>
                <input type="text" id="kader_instructeur" name="kader_instructeur" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="speellocatie_naam">Speellocatie naam:</label>
                <input type="text" id="speellocatie_naam" name="speellocatie_naam" class="form-control" required>
            </div>

            <h2>Adres speellocatie:</h2>
            <div class="form-group">
                <label for="city">Stad:</label>
                <input type="text" id="city" name="speellocatie[city]" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="street">Straat:</label>
                <input type="text" id="street" name="speellocatie[street]" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="house_number">Huisnummer:</label>
                <input type="text" id="house_number" name="speellocatie[house_number]" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="postcode">Postcode:</label>
                <input type="text" id="postcode" name="speellocatie[postcode]" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="begintijd">Begintijd:</label>
                <input type="time" id="begintijd" name="begintijd" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="eindtijd">Eindtijd:</label>
                <input type="time" id="eindtijd" name="eindtijd" class="form-control" required>
            </div>

            <h2>Griemadres:</h2>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="same_address" name="same_address">
                <label class="form-check-label" for="same_address">Gelijk aan speellocatie adres</label>
            </div>
            <div class="griemadres-container" id="griemadres">
            <div class="form-group">
                <label for="city">Stad:</label>
                <input type="text" id="city" name="griemlocatie[city]" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="street">Straat:</label>
                <input type="text" id="street" name="griemlocatie[street]" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="house_number">Huisnummer:</label>
                <input type="text" id="house_number" name="griemlocatie[house_number]" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="postcode">Postcode:</label>
                <input type="text" id="postcode" name="griemlocatie[postcode]" class="form-control" required>
            </div>
        </div>


            <div class="form-group">
                <label>Soort opdracht:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="bhv" value="bhv" name="soort_opdracht[]">
                    <label class="form-check-label" for="bhv">BHV</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="ehbo" value="ehbo" name="soort_opdracht[]">
                    <label class="form-check-label" for="ehbo">EHBO</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="examen" value="examen" name="soort_opdracht[]">
                    <label class="form-check-label" for="examen">Examen</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Opslaan</button>
        </form>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('#same_address').change(function(){
        if(this.checked)
            $('#griemadres').fadeOut('slow');
        else
            $('#griemadres').fadeIn('slow');
    });
});
</script>
@endsection
