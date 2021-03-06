<?php namespace App\Controllers;
// 2020-05-20 v0.3 Jovana Pavic 2017/0099
// 2020-05-19 v0.2 Marko Stanojevic 2017/0081

use App\Models\Kor;
use App\Models\Tipkor;

/**
 * Admin - klasa kontrolera, sva interakcija
 *         korisnika sa privilegijom admina sa bazom 
 *         se realizuje pomocu ove klase  
 * 
 * @version 0.3
 */
class Admin extends Ulogovani
{
    /** @var viewdata -- contains the user type and the views required to display all the possible tabs to the user
     */
    protected $viewdata = [
        'tipkor' => 'Admin',
        'tabs'   => [
            'nalozi' => ['nalozi'],
        ],
    ];
    
    /**
     * display the accounts tab to the client
     */
    public function nalozi()
    {
        // draw the template page with the accounts tab open
        $this->drawTemplate($this->viewdata, 'nalozi');
    }
    
    
    //-----------------------------------------------
    /** public function loadAllUsers(){...}
     * Dohvata sve korisnike iz baze i salje ih AJAX-om
     *  u vidu niza objekata
     */
    public function loadAllUsers()
    {        
        $korModel = new Kor();
        $tipModel = new Tipkor();
        
        $korisnici = $korModel->sviKorisnici();
        
        //podaci koji se salju
        $kor_id = [];
        $kor_naziv = [];
        $kor_mail = [];
        $kor_datkre = [];
        $kor_tipkor = [];
        
        //rasporedjivanje dohvacenih podataka
        for ($i = 0; $i < count($korisnici); $i++) {
            $kor_id[$i] = $korisnici[$i]->kor_id;
            $kor_naziv[$i] = $korisnici[$i]->kor_naziv;
            $kor_mail[$i] = $korisnici[$i]->kor_email;
            $kor_datkre[$i] = $korisnici[$i]->kor_datkre;
            $kor_tipkor[$i] = $tipModel->dohvatiNazivTipaKorisnika($korisnici[$i]->kor_tipkor_id);
        }
        
        //pravljenje odgovarajuce strukture za slanjem AJAX-om
        $user = [
            'kor_id' => $kor_id,
            'kor_ime' => $kor_naziv,
            'kor_mail' => $kor_mail,
            'kor_datkre' => $kor_datkre,
            'kor_tipkor' => $kor_tipkor
        ];
        
        //slanje podataka AJAX-om
        $this->sendAJAX($user);           
    }
    
    //-----------------------------------------------
    /** public function removeUser(){...}
     * Uklanja iz baze nalog ciji id dobije AJAX-om
     */
    public function removeUser() 
    {
        $korModel = new Kor();
        $elemDelete = $this->receiveAJAX();
        $korModel->delete($elemDelete['kor_id']);
    }
    
    //-----------------------------------------------
    /** public function changePrivileges(){...}
     * Menja privilegiju korisnika u bazi  
     *   na onu koju je dobio AJAX zahtevom
     */
    public function changePrivileges() 
    {
        $tipMod = new Tipkor();
        $korMod = new Kor();
        
        $elemChange = $this->receiveAJAX();
        
        $tipkor_opis = '';
        switch ($elemChange['nova_priv']){
            case 0: $tipkor_opis = 'Admin';
                break;
            case 1: $tipkor_opis = 'Menadzer';
                break;
            case 2: $tipkor_opis = 'Kuvar';
                break;
            case 3: $tipkor_opis = 'Korisnik';
        }
        $kor_tipkor_id = $tipMod->dohvatiIDTipaKorisnika($tipkor_opis);
        
        $korMod->update($elemChange['kor_id'], ['kor_tipkor_id' => $kor_tipkor_id]);
    }
    
    //-----------------------------------------------
    /** public function loadUser(){...}
     * Dohvata korisnika iz baze po id-u koji dobije AJAX-om
     * Salje informacije o korisniku putem AJAX-a
     */
    public function loadUser() 
    {
        $korModel = new Kor();
        $tipModel = new Tipkor();
        
        $elemLoad = $this->receiveAJAX();
        
        $korisnik = $korModel->dohvatiKorisnika($elemLoad['kor_id']);
        
        $kor_id = $korisnik->kor_id;
        $kor_naziv = $korisnik->kor_naziv;
        $kor_mail = $korisnik->kor_email;
        $kor_datkre = $korisnik->kor_datkre;
        $kor_tipkor = $tipModel->dohvatiNazivTipaKorisnika($korisnik->kor_tipkor_id);
        
        $user = [
            'kor_id' => $kor_id,
            'kor_ime' => $kor_naziv,
            'kor_mail' => $kor_mail,
            'kor_datkre' => $kor_datkre,
            'kor_tipkor' => $kor_tipkor
        ];
        $this->sendAJAX($user);
    }
    
}
