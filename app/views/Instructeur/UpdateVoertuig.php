<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= URLROOT ?>/css/style.css">
    <title>Wijzigen voertuigegevens</title>
</head>

<body>
    <u>
        <h2>Wijzigen voertuigegevens</h2>
    </u>

    <form action="<?= URLROOT ?>/instructeur/updateVoertuigSave/<?= $data['instructeurId'] ?>/<?= $data['voertuigId'] ?>" method="POST">

        <label for="instructeur">instructeur:</label>
        <select name="instructeur" id="instructeur">
            <option value="5" <?= $data['instructeurId'] == 5 ? "Selected" : "" ?>>Mohammed El Yassidi </option>
            <option value="4" <?= $data['instructeurId'] == 4 ? "Selected" : "" ?>>Bert van Sali</option>
            <option value="1" <?= $data['instructeurId'] == 1 ? "Selected" : "" ?>>Li Zhan</option>
            <option value="3" <?= $data['instructeurId'] == 3 ? "Selected" : "" ?>>Yoeri van Veen</option>
            <option value="2" <?= $data['instructeurId'] == 2 ? "Selected" : "" ?>>Leroy Boerhaven</option>
        </select><br><br>

        <label for="typevoertuig">Type Voertuig:</label>
        <select name="typevoertuig" id="typevoertuig">
            <option value="Personenauto" <?= $data['voertuigInfo'][0]->TypeVoertuig == "Personenauto" ? "Selected" : "" ?>>Personenauto</option>
            <option value="Vrachtwagen" <?= $data['voertuigInfo'][0]->TypeVoertuig == "Vrachtwagen" ? "Selected" : "" ?>>Vrachtwagen</option>
            <option value="Bus" <?= $data['voertuigInfo'][0]->TypeVoertuig == "Bus" ? "Selected" : "" ?>>Bus</option>
            <option value="Bromfiets" <?= $data['voertuigInfo'][0]->TypeVoertuig == "Bromfiets" ? "Selected" : "" ?>>Bromfiets</option>
        </select><br><br>

        <label for="type">Type:</label>
        <input type="text" name="type" id="type" value="<?php echo $data['voertuigInfo'][0]->Type ?>"><br><br>

        <label for="bouwjaar">Bouwjaar:</label>
        <input type="date" name="bouwjaar" value="<?= $data['voertuigInfo'][0]->Bouwjaar ?>"  ><br><br>

        <label for="kenteken">Kenteken:</label>
        <input type="text" name="kenteken" id="kenteken" value="<?php echo $data['voertuigInfo'][0]->Kenteken ?>"><br><br>
        <label for="brandstof">Brandstof:</label>
        <select name="brandstof" id="brandstof">
            <option value="Benzine" <?= $data['voertuigInfo'][0]->Brandstof == "Benzine" ? "Selected" : "" ?>>Benzine</option>
            <option value="Diesel" <?= $data['voertuigInfo'][0]->Brandstof == "Diesel" ? "Selected" : "" ?>>Diesel</option>
            <option value="Elektrisch" <?= $data['voertuigInfo'][0]->Brandstof == "Elektrisch" ? "Selected" : "" ?>>Elektrisch</option>
        </select><br><br>



        <button type="submit">Wijzig</button>
    </form>
</body>

</html>