<?php

class Voiture
{
    //** LES ATTRIBUTS */
    private $marque;
    private $modele;
    private $couleur;
    private $puissanceReelle;
    private $puissanceFiscale;
    private $energie;
    private $boite;
    private $nbPorte;
    private $kilometrage;
    private $autonomie;
    private $vitesse;
    private $contact;

    public function __construct($marque, $modele, $couleur)
    {
        $this->marque = $marque;
        $this->modele = $modele;
        $this->couleur = $couleur;

        // Initialisation des attributs de la voiture dans la session si non définis
        $_SESSION['vitesse'] = $_SESSION['vitesse'] ?? 0;
        $_SESSION['autonomie'] = $_SESSION['autonomie'] ?? 10;
        $_SESSION['contact'] = $_SESSION['contact'] ?? false;
    }

    // ************************* Getters et Setters 
    public function getMarque()
    {
        return $this->marque;
    }

    public function setMarque($marque)
    {
        $this->marque = $marque;
        return $this;
    }

    public function getModele()
    {
        return $this->modele;
    }

    public function setModele($modele)
    {
        $this->modele = $modele;
        return $this;
    }

    public function getCouleur()
    {
        return $this->couleur;
    }

    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;
        return $this;
    }

    public function getPuissanceReelle()
    {
        return $this->puissanceReelle;
    }

    public function setPuissanceReelle($puissanceReelle)
    {
        $this->puissanceReelle = $puissanceReelle;
        return $this;
    }

    public function getPuissanceFiscale()
    {
        return $this->puissanceFiscale;
    }

    public function setPuissanceFiscale($puissanceFiscale)
    {
        $this->puissanceFiscale = $puissanceFiscale;
        return $this;
    }

    public function getEnergie()
    {
        return $this->energie;
    }

    public function setEnergie($energie)
    {
        $this->energie = $energie;
        return $this;
    }

    public function getBoite()
    {
        return $this->boite;
    }

    public function setBoite($boite)
    {
        $this->boite = $boite;
        return $this;
    }

    public function getNbPorte()
    {
        return $this->nbPorte;
    }

    public function setNbPorte($nbPorte)
    {
        $this->nbPorte = $nbPorte;
        return $this;
    }

    public function getKilometrage()
    {
        return $this->kilometrage;
    }

    public function setKilometrage($kilometrage)
    {
        $this->kilometrage = $kilometrage;
        return $this;
    }

    // ************************* Gestion des attributs de session

    // Méthodes pour obtenir la vitesse, l'autonomie et le contact directement de la session
    public function getAutonomie()
    {
        return $_SESSION['autonomie'];
    }

    public function setAutonomie($autonomie)
    {
        $_SESSION['autonomie'] = $autonomie;
        return $this;
    }

    public function getVitesse()
    {
        return $_SESSION['vitesse'];
    }

    public function setVitesse($vitesse)
    {
        $_SESSION['vitesse'] = $vitesse;
        return $this;
    }

    public function getContact()
    {
        return $_SESSION['contact'];
    }

    public function setContact($contact)
    {
        $_SESSION['contact'] = $contact;
        return $this;
    }

    /** 
     * Les Méthodes
     */

    // Démarrer la voiture (mettre le contact)
    public function demarrer()
    {
        if (!$this->getContact()) {
            $this->setContact(true);
            echo "Le contact est allumé.";
        } else {
            echo "Le contact est déjà allumé.";
        }
    }

    // Accélérer (augmenter la vitesse)
    public function accelerer()
    {
        if (!$this->getContact()) {
            echo "Le contact est éteint. Démarrez la voiture pour accélérer.<br>";
            return;
        }
    
        if ($_SESSION['autonomie'] > 0) {
            $_SESSION['vitesse'] += 10;
            $_SESSION['autonomie'] -= 1;
            echo "Vitesse actuelle : " . $_SESSION['vitesse'] . " km/h<br>";
            echo "Autonomie restante : " . $_SESSION['autonomie'] . "/10<br>";
        } else {
            echo "Autonomie épuisée. Faites le plein.<br>";
        }
    }
    

    // Freiner (diminuer la vitesse)
    public function freiner()
    {
        if ($this->getVitesse() > 0) {
            $vitesse = $this->getVitesse();
            $vitesse -= 10;
            $this->setVitesse($vitesse);
            echo "Attention, je freine ! Vitesse actuelle : " . $this->getVitesse() . " km/h";
        } else {
            echo "Tu es déjà à l'arrêt.";
        }
    }

    // Couper le contact
    public function couperContact()
    {
        if ($this->getContact()) {
            $this->setContact(false);
            $this->setVitesse(0);  // Arrêter la voiture
            echo "Le contact est maintenant coupé.";
        } else {
            echo "Le contact est déjà coupé.";
        }
    }

    // Faire le plein (remplir l'autonomie)
    public function faireLePlein()
    {
        if ($this->getAutonomie() < 10) {
            $this->setAutonomie(10);
            echo "Le plein est fait !";
        } else {
            echo "Tu as déjà le plein.";
        }
    }
}
