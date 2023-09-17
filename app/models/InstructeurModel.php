<?php

class InstructeurModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getInstructeurs()
    {
        $sql = "SELECT Id
                      ,Voornaam
                      ,Tussenvoegsel
                      ,Achternaam
                      ,Mobiel
                      ,DatumInDienst
                      ,AantalSterren
                FROM  Instructeur
                ORDER BY AantalSterren DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getToegewezenVoertuigen($Id)
    {
        $sql = "SELECT      
                            VOER.Id
                            ,VOER.Type
                            ,VOER.Kenteken
                            ,VOER.Bouwjaar
                            ,VOER.Brandstof
                            ,TYVO.TypeVoertuig
                            ,TYVO.RijbewijsCategorie

                FROM        Voertuig    AS  VOER
                
                INNER JOIN  TypeVoertuig AS TYVO

                ON          TYVO.Id = VOER.TypeVoertuigId
                
                INNER JOIN  VoertuigInstructeur AS VOIN
                
                ON          VOIN.VoertuigId = VOER.Id
                
                WHERE       VOIN.InstructeurId = $Id
                
                ORDER BY    TYVO.RijbewijsCategorie asc";

        $this->db->query($sql);
        return $this->db->resultSet();
    }
    public function getToegewezenVoertuig($Id, $instructeurId)
    {
        $sql = "SELECT      
                            VOER.Id
                            ,VOER.Type
                            ,VOER.Kenteken
                            ,VOER.Bouwjaar
                            ,VOER.Brandstof
                            ,TYVO.TypeVoertuig
                            ,TYVO.RijbewijsCategorie

                FROM        Voertuig    AS  VOER
                
                INNER JOIN  TypeVoertuig AS TYVO

                ON          TYVO.Id = VOER.TypeVoertuigId
                
                INNER JOIN  VoertuigInstructeur AS VOIN
                
                ON          VOIN.VoertuigId = VOER.Id
                
                WHERE       VOIN.InstructeurId = $instructeurId AND VOER.Id = $Id
                
                ORDER BY    TYVO.RijbewijsCategorie desc";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getInstructeurById($Id)
    {
        $sql = "SELECT Voornaam
                      ,Tussenvoegsel
                      ,Achternaam
                      ,DatumInDienst
                      ,AantalSterren
                FROM  Instructeur
                WHERE Id = $Id";

        $this->db->query($sql);

        return $this->db->single();
    }

        function updateVoertuig($id) 
    {
        $sql = "UPDATE Voertuig AS Voertuig
        JOIN TypeVoertuig AS TypeVoertuig
        ON Voertuig.TypeVoertuigId = TypeVoertuig.Id
        SET Voertuig.Type = :type, Voertuig.Brandstof = :brandstof, Voertuig.Kenteken = :kenteken, Voertuig.Bouwjaar = :bouwjaar, TypeVoertuig.TypeVoertuig = :typevoertuig
        WHERE Voertuig.Id = $id";


        $this->db->query($sql);
        $this->db->bind(':type', $_POST['type']);
        $this->db->bind(':brandstof', $_POST['brandstof']);
        $this->db->bind(':kenteken', $_POST['kenteken']);
        $this->db->bind(':bouwjaar', $_POST['bouwjaar']);
        $this->db->bind(':typevoertuig', $_POST['typevoertuig']);
        return $this->db->resultSet();
    }

    function updateInstructeur($id) {
        $sql = "UPDATE VoertuigInstructeur
                SET InstructeurId = :instructeurid
                WHERE voertuigId = $id";

        $this->db->query($sql);
        $this->db->bind(':instructeurid', $_POST['instructeur']);
        return $this->db->resultSet();
    }  

    function getNietToegewezenVoertuigen() {
        $sql = "SELECT V.Type, V.Kenteken, V.Bouwjaar, V.Brandstof, TV.Typevoertuig, TV.RijbewijsCategorie 
                FROM Voertuig V
                LEFT JOIN VoertuigInstructeur VI
                ON V.Id = VI.VoertuigId
                INNER JOIN TypeVoertuig TV
                ON TV.Id = V.TypeVoertuigId
                WHERE InstructeurId IS NULL";

    $this->db->query($sql);
    return $this->db->resultSet();    }


}