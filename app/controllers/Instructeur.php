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

        $rows = "";
        foreach ($result as $instructeur) {
   
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

        $naam = $instructeurInfo->Voornaam . " " . $instructeurInfo->Tussenvoegsel . " " . $instructeurInfo->Achternaam;
        $datumInDienst = $instructeurInfo->DatumInDienst;
        $aantalSterren = $instructeurInfo->AantalSterren;

        $toevoegen = "<a href='" . URLROOT . "/instructeur/overzichtNietToegewezenVoertuigen/$instructeurId'>Toevoegen Voertuig</a>";

        $result = $this->instructeurModel->getToegewezenVoertuigen($instructeurId);


        $tableRows = "";
        if (empty($result)) {
    
            $tableRows = "<tr>
                            <td colspan='6'>
                                Er zijn op dit moment nog geen voertuigen toegewezen aan deze instructeur
                            </td>
                          </tr>";
        } else {
  
            foreach ($result as $voertuig) {


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
                                    
                            </tr>";
            }
        }


        $data = [
            'title'     => 'Door instructeur gebruikte voertuigen',
            'tableRows' => $tableRows,
            'naam'      => $naam,
            'datumInDienst' => $datumInDienst,
            'aantalSterren' => $aantalSterren,
            'toevoegen' => $toevoegen
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

    function overzichtNietToegewezenVoertuigen($instructeurId) {


        $nietToegewezenVoertuigen = $this->instructeurModel->getNietToegewezenVoertuigen();
        $instructeurInfo = $this->instructeurModel->getInstructeurById($instructeurId);

        $naam = $instructeurInfo->Voornaam . " " . $instructeurInfo->Tussenvoegsel . " " . $instructeurInfo->Achternaam;
        $datumInDienst = $instructeurInfo->DatumInDienst;
        $aantalSterren = $instructeurInfo->AantalSterren;


        $tableRows = "";
        if (empty($nietToegewezenVoertuigen)) {
    
            $tableRows = "<tr>
                            <td colspan='6'>
                                Er zijn op dit moment nog geen beschikbare voertuigen
                            </td>
                          </tr>";
        } else {
  
            foreach ($nietToegewezenVoertuigen as $voertuig) {


                $date_formatted = date_format(date_create($voertuig->Bouwjaar), 'd-m-Y');

                $tableRows .= "<tr>
                                  
                                    <td>$voertuig->Typevoertuig</td>
                                    <td>$voertuig->Type</td>
                                    <td>$voertuig->Kenteken</td>
                                    <td>$date_formatted</td>
                                    <td>$voertuig->Brandstof</td>
                                    <td>$voertuig->RijbewijsCategorie</td>
                                    <td>
                                    <a href='" . URLROOT . "/instructeur'>
                                   +
                                   </a> 
                                   </td>

                                    <td>
                                     <a href='" . URLROOT . "/instructeur'>
                                    <img src = '/public/img/b_edit.png'>
                                    </a> 
                                    </td>

                                    
                            </tr>";
            }
        }


        $data = [
            'title' => 'Alle beschikbare voertuigen',
            'nietToegewezenVoertuigen' => $nietToegewezenVoertuigen,
            'tableRows' => $tableRows,
            'naam'      => $naam,
            'datumInDienst' => $datumInDienst,
            'aantalSterren' => $aantalSterren
        ];

    

        $this->view('Instructeur/overzichtNietToegewezenVoertuig', $data);

    }
}

