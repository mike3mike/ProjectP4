<!DOCTYPE html>
<html>
<head>
  <title>Factuurgegevens</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .logo-img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #ccc;
    }
    .form-check.custom-margin {
        margin-right: 20px; 
    }
</style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <img src="https://lotuskringhwg.nl/wp-content/uploads/2020/09/cropped-logo-192x192.jpg" alt="Logo" class="logo-img">
            <div class="text-center flex-grow-1">
                <h1>LOTUSKRING “HERE WE GO”</h1>
                <h2>Declaratie / Speelformulier</h2>
            </div>
        </div>
        <div class="card-body">
            <form>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Opdracht via de coördinator:</label>
                    <div class="col-sm-9 d-flex align-items-center">
                        <div class="form-check custom-margin">
                            <input class="form-check-input" type="radio" name="ch" id="ja" value="ja">
                            <label class="form-check-label" for="ja">Ja</label>
                        </div>
                        <div class="form-check ">
                            <input class="form-check-input" type="radio" name="ch" id="nee" value="nee">
                            <label class="form-check-label" for="nee">Nee</label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Tarief factuur:</label>
                    <div class="col-sm-9 d-flex align-items-center">
                        <div class="form-check custom-margin">
                            <input class="form-check-input" type="radio" name="tarief" id="bedrijf-hoofd-tarief" value="bedrijf-hoofd-tarief">
                            <label class="form-check-label" for="bedrijf-hoofd-tarief">Bedrijf hoofdtarief</label>
                        </div>
                        <div class="form-check ">
                            <input class="form-check-input" type="radio" name="tarief" id="vereniging-laag-tarief" value="vereniging-laag-tarief">
                            <label class="form-check-label" for="vereniging-laag-tarief">Vereniging laag tarief</label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3 row">
                    <label for="bedrijfsnaam" class="col-sm-3 col-form-label">Bedrijfs-/ verenigingsnaam:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="bedrijfsnaam" value="{{ $task->client->company_name }}">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="opdrachtnummer" class="col-sm-3 col-form-label">Opdrachtnummer:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="opdrachtnummer" value="{{ $task->task_number}}">
                    </div>
                </div>
            

                <div class="mb-3 row">
                    <label for="kader" class="col-sm-3 col-form-label">Kader:</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="kader" value="{{ $task->instructor_name }}">
                </div>
                </div>

                <div class="mb-3 row">
                    <label for="datum" class="col-sm-3 col-form-label">Datum:</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="datum" value="{{ $task->date }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Speellocatie:</label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="form-label">Naam:</label>
                                <input type="text" class="form-control" value="{{ $task->play_address_name}}">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Adres:</label>
                                <input type="text" class="form-control" value="{{ $task->playAddress->street_name }} {{ $task->playAddress->house_number }}, {{ $task->playAddress->postal_code }}, {{ $task->playAddress->city }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Indien Nee invullen:</label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="form-label">T.a.v:</label>
                                <input type="text" class="form-control" value="{{ $task->client->contact_person_name }}" >
                            </div>
                            <div class="col-sm-3">
                                <label class="form-label">Adres:</label>
                                <input type="text" class="form-control"value="{{ $task->client->address->->street_name }} {{ $task->client->address->house_number }}, {{ $task->client->address->postal_code }}, {{ $task->client->address->city }}">
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">E-mailadres factuur:</label>
                                <input type="text" class="form-control" value="{{ $task->client->invoice_email_address }}" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Tijd:</label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="form-label">Begintijd:</label>
                                <input type="text" class="form-control" value="{{ $task->begin_time }}">
                            </div>
                            <div class="col-sm-3">
                                <label class="form-label">Eindtijd</label>
                                <input type="text" class="form-control"value="{{ $task->end_time}">
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Aantal uren:</label>
                                <?php
                                    $beginTime = explode(':', $task->begin_time);
                                    $endTime = explode(':', $task->end_time);
                                    $beginTimeInHours = $beginTime[0] + $beginTime[1] / 60;
                                    $endTimeInHours = $endTime[0] + $endTime[1] / 60;
                                    $hours = $endTimeInHours - $beginTimeInHours;
                                 ?>
                                <input type="text" class="form-control"  value="{{ $hours }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-form-label">Lotus Informatie:</label>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Naamlotus:</th>
                                <th scope="col">Aantal Km</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($task->userTasks as $userTask)
                            <tr>
                                <td>
                                    <input type="text" class="form-control" id="naamlotus" value="{{ $userTask->user->name }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="aantalKm">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-12 col-form-label">
                        Extra kosten zoals grime (€ 3,50), parkeren, kleding (€2,50), bloed etc.:
                    </label>
                    <div class="col-sm-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Naamlotus:</th>
                                    <th scope="col">Soort</th>
                                    <th scope="col">Aantal/eenheid</th>
                                    <th scope="col">Prijs</th>
                                    <th scope="col">Totaal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" id="naamlotus">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="soort">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="aantal_eenheid">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="prijs">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="totaal">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>  
                <div class="mb-3 row">
                    <label class="col-sm-12 col-form-label">Handtekening:</label>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="form-label">Kader of bedrijf:</label>
                                <textarea class="form-control" rows="4" id="handtekening"></textarea>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Naam:</label>
                                <input type="text" class="form-control">
                                <label class="form-label mt-2">Functie:</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="bijzonderheden" class="col-sm-3 col-form-label">Bijzonderheden:
                        </label>
                    <div class="col-sm-9">
                    <textarea class="form-control" id="bijzonderheden"></textarea>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
