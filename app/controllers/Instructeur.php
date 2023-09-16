<?php

class Instructeur extends BaseController
{
    private $instructeurModel;

    public function __construct()
    {
        $this->instructeurModel = $this->model('InstructeurModel');
    }

    public function overzichtInstructeur()
    {
        $result = $this->instructeurModel->getInstructeurs();

        //  var_dump($result);
        $rows = "";
        foreach ($result as $instructeur) {
            /**
             * Datum in het juiste formaat gezet
             */
            /**
             * Haal alle instructeurs op uit de database (model)
             */
            $instructeurs = $this->instructeurModel->getInstructeurs();

            $aantalInstructeurs = sizeof($instructeurs);


            $date = date_create($instructeur->DatumInDienst);
            $formatted_date = date_format($date, 'd-m-Y');
            
 
            $rows .= "<tr>
                        <td>$instructeur->Voornaam</td>
                        <td>$instructeur->Tussenvoegsel</td>
                        <td>$instructeur->Achternaam</td>
                        <td>$instructeur->Mobiel</td>
                        <td>$formatted_date</td>            
                        <td>$instructeur->AantalSterren</td>  

                                  
                        <td>
                            <a href='" . URLROOT . "/instructeur/overzichtvoertuigen/$instructeur->Id'>
                                <i class='bi bi-car-front'></i>
                            </a>
                        </td>
                       

                      </tr>";
        }

        $data = [
            'title' => 'Instructeurs in dienst',
            'aantalInstructeurs' => $aantalInstructeurs,
            'rows' => $rows
        ];

        $this->view('Instructeur/overzichtinstructeur', $data);
    }

    public function overzichtVoertuigen($instructeurId)
    {

        $instructeurInfo = $this->instructeurModel->getInstructeurById($instructeurId);

        // var_dump($instructeurInfo);
        $naam = $instructeurInfo->Voornaam . " " . $instructeurInfo->Tussenvoegsel . " " . $instructeurInfo->Achternaam;
        $datumInDienst = $instructeurInfo->DatumInDienst;
        $aantalSterren = $instructeurInfo->AantalSterren;

        /**
         * We laten de model alle gegevens ophalen uit de database
         */
        $result = $this->instructeurModel->getToegewezenVoertuigen($instructeurId);


        $tableRows = "";
        if (empty($result)) {
            /**
             * Als er geen toegewezen voertuigen zijn komt de onderstaande tekst in de tabel
             */
            $tableRows = "<tr>
                            <td colspan='6'>
                                Er zijn op dit moment nog geen voertuigen toegewezen aan deze instructeur
                            </td>
                          </tr>";
        } else {
            /**
             * Bouw de rows op in een foreach-loop en stop deze in de variabele
             * $tabelRows
             */
            foreach ($result as $voertuig) {

                /**
                 * Zet de datum in het juiste format
                 */
                $date_formatted = date_format(date_create($voertuig->Bouwjaar), 'd-m-Y');

                $tableRows .= "<tr>
                                    <td>$voertuig->Id</td>
                                    <td>$voertuig->TypeVoertuig</td>
                                    <td>$voertuig->Type</td>
                                    <td>$voertuig->Kenteken</td>
                                    <td>$date_formatted</td>
                                    <td>$voertuig->Brandstof</td>
                                    <td>$voertuig->RijbewijsCategorie</td>   
                                    <td>
                                    <a href='" . URLROOT . "/instructeur/updateVoertuig/$voertuig->Id/$instructeurId'>
                                    <img src = '/public/img/b_edit.png'>
                                    </a> 
                                    </td>    
                                    
                                    <td>
                                    <a href='" . URLROOT . "/instructeur/nietToegewezenVoertuigen'>
                                    +
                                    </a> 
                                    </td> 
                            </tr>";
            }
        }


        $data = [
            'title'     => 'Door instructeur gebruikte voertuigen',
            'tableRows' => $tableRows,
            'naam'      => $naam,
            'datumInDienst' => $datumInDienst,
            'aantalSterren' => $aantalSterren
        ];

        $this->view('Instructeur/overzichtVoertuigen', $data);
    }

    function updateVoertuig($Id, $instructeurId)
    {

        $voertuigInfo = $this->instructeurModel->getToegewezenVoertuig($Id, $instructeurId);

        $data = [
            'title' => 'Update Voertuig',
            'voertuigId' => $Id,
            'instructeurId' => $instructeurId,
            'voertuigInfo' => $voertuigInfo

        ];

        $this->view('Instructeur/updateVoertuig', $data);
    }
    function updateVoertuigSave($instructeurId, $voertuigId)
    {
        $this->instructeurModel->updateVoertuig($voertuigId);
        $this->instructeurModel->updateInstructeur($voertuigId);
        $this->overzichtVoertuigen($instructeurId); 

    }

    // function updateInstructeur() {
    //     $instructeurs = $this->instructeurModel->getInstructeurs();

    //     $data = [
    //         'instructeurs' => $instructeurs
    //     ];

    //     $this->view('Instructeur/updateVoertuig', $data);
        

    // }

     function overzichtNietToegewezenVoertuig() {

        $nietToegewezenVoertuigen = $this->instructeurModel->getNietToegewezenVoertuigen()();

        var_dump($nietToegewezenVoertuigen);

        $data = [
            'result' => $nietToegewezenVoertuigen
        ];

        $this->view('Instructeur/overzichtNietToegewezenVoertuig', $data);
    }
}

