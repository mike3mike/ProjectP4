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
    .header-text {
      text-align: center;
      margin-top: 0px;
    }
    /* .container {
      display: flex;
      justify-content: space-between;
    }
    .info-container {
      width: 70%;
    } */
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col">
        <img src="https://lotuskringhwg.nl/wp-content/uploads/2020/09/cropped-logo-192x192.jpg" alt="Logo" class="logo-img">
        <div class="header-text">
          <h2>LOTUSKRING 'HERE WE GO'</h2>
          <h3>Declaratie / Speelformulier</h3>
        </div>
        <p>Opdracht via de coördinator</p>
        <div class="form-check form-check-inline">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="ch" value="ja"> Ja
          </label>
        </div>
        <div class="form-check form-check-inline">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="ch" value="nee"> Nee
          </label>
        </div>
        <p>(indien Nee gekleurde vlak verplicht invullen!)</p>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <h4>Tarief factuur:</h4>
        <div class="form-check form-check-inline">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="tarief" value="bedrijf-hoofd-tarief"> Bedrijf hoofdtarief
          </label>
        </div>
        <div class="form-check form-check-inline">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="tarief" value="vereniging-laag-tarief"> Vereniging laag tarief
          </label>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <h4>Factuurgegevens:</h4>
        <div class="form-group">
          <label for="bedrijfsnaam">Bedrijfs-/verenigingsnaam:</label>
          <input type="text" class="form-control" id="bedrijfsnaam" ">
        </div>
        <div class="form-group">
          <label for="opdrachtnummer">Opdrachtnummer:</label>
          <input type="text" class="form-control" id="opdrachtnummer" ">
        </div>
        <div class="form-group">
          <label for="kader">Kader:</label>
          <input type="text" class="form-control" id="kader" ></input>
        </div>
        <div class="form-group">
          <label for="datum">Datum:</label>
          <input type="text" class="form-control" id="datum" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <h4>Speellocatie:</h4>
        <div class="form-group">
          <label for="naam">Naam:</label>
          <input type="text" class="form-control" id="naam" >
        </div>
        <div class="form-group">
          <label for="adres">Adres:</label>
          <input type="text" class="form-control" id="adres" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <h4>Indien Nee invullen:</h4>
        <div class="form-group">
          <label for="contactpersoon">T.a.v:</label>
          <input type="text" class="form-control" id="contactpersoon" >
        </div>
        <div class="form-group">
          <label for="contactadres">Adres:</label>
          <input type="text" class="form-control" id="contactadres" >
        </div>
        <div class="form-group">
          <label for="factuuremail">Emailadres Factuur:</label>
          <input type="text" class="form-control" id="factuuremail">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <h4>Tijd:</h4>
        <div class="form-group">
          <label for="begintijd">Begintijd:</label>
          <input type="text" class="form-control" id="begintijd">
        </div>
        <div class="form-group">
          <label for="eindtijd">Eindtijd:</label>
          <input type="text" class="form-control" id="eindtijd" >
        </div>
        <div class="form-group">
          <label for="aantaltijd">Aantal tijd:</label>
          <input type="text" class="form-control" id="aantaltijd" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Naamlotus:</th>
              <th scope="col">Aantal Km</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="text" class="form-control" ></td>
              <td><input type="text" class="form-control" ></td>
            </tr>
          </tbody>
        </table>
        <h4>Extra kosten zoals grime (€3.50), parkeren, kleding (€2.50), bloed, etc:</h4>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Naam lotus</th>
              <th scope="col">Soort</th>
              <th scope="col">Aantal/eenheid</th>
              <th scope="col">Prijs</th>
              <th scope="col">Totaal</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="text" class="form-control" ></td>
              <td><input type="text" class="form-control" ></td>
              <td><input type="text" class="form-control" ></td>
              <td><input type="text" class="form-control" ></td>
              <td><input type="text" class="form-control" ></td>
            </tr>
          </tbody>
        </table>
        <div class="form-group">
          <label for="handtekening">Handtekening:</label>
          <textarea class="form-control" id="handtekening" rows="3"></textarea>
        </div>
        <div class="form-group">
          <label for="bedrijfnaam">Naam:</label>
          <input type="text" class="form-control" id="bedrijfnaam" >
        </div>
        <div class="form-group">
          <label for="functie">Functie:</label>
          <input type="text" class="form-control" id="functie" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <h4>Bijzonderheden:</h4>
        <div class="form-group">
          <textarea class="form-control" id="bijzonderheden" rows="3"></textarea>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
