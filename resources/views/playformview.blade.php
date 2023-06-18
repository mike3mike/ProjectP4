<!DOCTYPE html>
<html>
<head>
 <title>Factuurgegevens</title>
 <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .page {
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
    }
    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .logo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ccc;
    }

    .header h1 {
        font-size: 24px;
        margin: 0;
    }

    .header h2 {
        font-size: 18px;
        margin: 0;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
    }

    .form-group input[type="text"],
    .form-group textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .form-group .row {
        display: flex;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .form-group .col-half {
        width: 50%;
        padding: 0 5px;
    }

    .form-group .col-half label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group .col-half input[type="text"] {
        width: 100%;
    }

    .form-group .col-half:first-child {
        padding-left: 0;
    }

    .form-group .col-half:last-child {
        padding-right: 0;
    }

    .form-group .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .form-group .table th,
    .form-group .table td {
        padding: 8px;
        border: 1px solid #ddd;
    }

    .form-group .table th {
        font-weight: bold;
    }

    .form-group .table input[type="text"] {
        width: 100%;
        border: none;
    }

    .form-group .signature-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-top: 20px;
    }

    .form-group .signature-container .col-half {
        width: 50%;
    }

    .form-group .signature-container .col-half label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group .signature-container .col-half input[type="text"] {
        width: 100%;
    }

    .form-group textarea {
        height: 100px;
    }
</style>
</head>
<body>
    <div class="page">
        <div class="header">
            <img src="https://lotuskringhwg.nl/wp-content/uploads/2020/09/cropped-logo-192x192.jpg" alt="Logo" class="logo">
            <div>
                <h1>LOTUSKRING “HERE WE GO”</h1>
                <h2>Declaratie / Speelformulier</h2>
            </div>
        </div>
        <div class="form-group">
            <label>Opdracht via de coördinator:</label>
            <div>
                <input type="radio" id="ja" name="coordinator" value="ja">
                <label for="ja">Ja</label>
                <input type="radio" id="nee" name="coordinator" value="nee">
                <label for="nee">Nee</label>
            </div>
        </div>
        <div class="form-group">
            <label>Tarief factuur:</label>
            <div>
                <input type="radio" id="bedrijf-hoofd-tarief" name="tarief" value="bedrijf-hoofd-tarief">
                <label for="bedrijf-hoofd-tarief">Bedrijf hoofdtarief</label>
                <input type="radio" id="vereniging-laag-tarief" name="tarief" value="vereniging-laag-tarief">
                <label for="vereniging-laag-tarief">Vereniging laag tarief</label>
            </div>
        </div>
        <div class="form-group">
            <label for="bedrijfsnaam">Bedrijfs-/ verenigingsnaam:</label>
            <input type="text" id="bedrijfsnaam"  value="{{ $task->client->company_name }}">
        </div>
        <div class="form-group">
            <label for="opdrachtnummer">Opdrachtnummer:</label>
            <input type="text" id="opdrachtnummer" value="{{ $task->id}}">
        </div>
        <div class="form-group">
            <label for="kader">Kader:</label>
            <input type="text" id="kader" value="{{ $task->instructor_name }}">
        </div>
        <div class="form-group">
            <label for="datum">Datum:</label>
            <input type="text" id="datum" value="{{ $task->date }}">
        </div>
        <div class="form-group">
            <label>Speellocatie:</label>
            <div class="row">
                <div class="col-half">
                    <label for="speellocatie-naam">Naam:</label>
                    <input type="text" id="speellocatie-naam" value="{{ $task->play_address_name}}">
                </div>
                <div class="col-half">
                    <label for="speellocatie-adres">Adres:</label>
                    <input type="text" id="speellocatie-adres" value="{{ $task->playAddress->street_name }} {{ $task->playAddress->house_number }}, {{ $task->playAddress->postal_code }}, {{ $task->playAddress->city }}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Indien Nee invullen:</label>
            <div class="row">
                <div class="col-half">
                    <label for="contact-tav">T.a.v:</label>
                    <input type="text" id="contact-tav" value="{{ $task->client->contact_person_name }}">
                </div>
                <div class="col-half">
                    <label for="contact-adres">Adres:</label>
                    <input type="text" id="contact-adres" value="{{ $task->client->address->street_name }} {{ $task->client->address->house_number }}, {{ $task->client->address->postal_code }}, {{ $task->client->address->city }}">
                </div>
            </div>
            <div class="row">
                <div class="col-half">
                    <label for="contact-email">E-mailadres factuur:</label>
                    <input type="text" id="contact-email"  value="{{ $task->client->invoice_email_address }}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Tijd:</label>
            <div class="row">
                <div class="col-half">
                    <label for="begintijd">Begintijd:</label>
                    <input type="text" id="begintijd" value="{{ $task->begin_time }}">
                </div>
                <div class="col-half">
                    <label for="eindtijd">Eindtijd:</label>
                    <input type="text" id="eindtijd" value="{{ $task->end_time}}">
                </div>
            </div>
            <div class="row">
                <div class="col-half">
                    <label for="aantal-uren">Aantal uren:</label>
                    
                    <?php
                        $beginTime = explode(':', $task->begin_time);
                        $endTime = explode(':', $task->end_time);
                        $beginTimeInMinutes = $beginTime[0] * 60 + $beginTime[1];
                        $endTimeInMinutes = $endTime[0] * 60 + $endTime[1];
                        $diffMinutes = $endTimeInMinutes - $beginTimeInMinutes;
            
                        // Bereken het aantal volle uren en het restant aan minuten
                        $hours = floor($diffMinutes / 60);
                        $minutes = $diffMinutes % 60;
            
                        // Formatteer het resultaat
                        $timeDifference = $hours . "." . str_pad($minutes, 2, '0', STR_PAD_LEFT);
            
                        // // Voeg controlelogica toe om de input en output te controleren
                        // echo "Begintijd in uren: " . $beginTime[0] . ":" . $beginTime[1] . "<br>";
                        // echo "Eindtijd in uren: " . $endTime[0] . ":" . $endTime[1] . "<br>";
                        // echo "Uren berekend: " . $timeDifference . "<br>";
                    ?>
                    <input type="text" id="aantal-uren"  value="{{ $timeDifference }}">
                </div>
            </div>
                     
        </div>
        <div class="form-group">
            <label>Lotus Informatie:</label>
            <table class="table">
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
        <div class="form-group">
            <label>Extra kosten zoals grime (€ 3,50), parkeren, kleding (€2,50), bloed etc.:</label>
            <table class="table">
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
                    @foreach($task->userTasks as $userTask)
                    <tr>
                        <td>
                            <input type="text" class="form-control" id="naamlotus" value="{{ $userTask->user->name }}">
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
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <label>Handtekening:</label>
            <div class="signature-container">
                <div class="col-half">
                    <label for="handtekening-bedrijf">Kader of bedrijf:</label>
                    <textarea id="handtekening-bedrijf"></textarea>
                </div>
                <div class="col-half">
                    <label for="handtekening-naam">Naam:</label>
                    <input type="text" id="handtekening-naam">
                    <label for="handtekening-functie">Functie:</label>
                    <input type="text" id="handtekening-functie">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="bijzonderheden">Bijzonderheden:</label>
            <textarea id="bijzonderheden"></textarea>
        </div>
    </div>
</body>
</html>


