<?php namespace App\Controllers;
use App\Models\Dijeta;
use App\Models\Tipjela;
use App\Models\Ukus;
use App\Models\Jelo;
use App\Models\Por;
use App\Models\Povod;
use App\Models\Kor;
use App\Models\Stavka;

/** Jovana Jankovic - 0586/17 */
/** Filip Lucic - 0188/17   */
/** Funkcionalnosti za menadzera - dodavanje novih jela u bazu - v.0.2   */
/** Funkcionalnosti za menadzera - prikaz porudzbina koje vidi menadzer - v.0.2 */
// 2020-05-19 v0.2 Marko Stanojevic 2017/0081

class Menadzer extends Ulogovani
{    
    /** @var viewdata -- contains the user type and the views required to display all the possible tabs to the user
     */
    protected $viewdata = [
        'tipkor'  => 'Menadzer',
        'tabs'   => [
            'jela'       => ['jela-menadzer', /*'filter-rezultata'*/],
            'porudzbine' => ['porudzbine-menadzer'],
        ],
    ];
    
    /**
     * display the food tab to the client
     */
    public function jela()
    {
        // draw the template page with the food tab open
        $this->drawTemplate($this->viewdata, 'jela');
    }
    
    /**
     * display the orders tab to the client
     */
    public function porudzbine()
    {
        // draw the template page with the orders tab open
        $this->drawTemplate($this->viewdata, 'porudzbine');
    }

    
    /**Autor - Jovana Jankovic 0586/17
     * public function unesiTipove(){...}
     * 
     * pomocna Funkcija koriscena za testiranje tabele Jela
     */
    public function unesiTipove(){   
        $this->receiveAJAX();

        $tip = new Tipjela();        
        $ukus =  new Ukus();
        $dijeta = new Dijeta();
        
        $tip->insert([
            'tipjela_naziv'=>"Pita"
        ]);
        $tip->insert([
            'tipjela_naziv'=>"Rostilj"
        ]);
        $tip->insert([
            'tipjela_naziv'=>"Pica"
        ]);
        $tip->insert([
            'tipjela_naziv'=>"Pasta"
        ]);$tip->insert([
            'tipjela_naziv'=>"Riba"
        ]);
        
        $ukus->insert([
            'ukus_naziv'=>"Slatko"
        ]);
        
        
        $ukus->insert([
            'ukus_naziv'=>"Slano"
        ]);
        $ukus->insert([
            'ukus_naziv'=>"Ljuto"
        ]);
        
        
        $dijeta->insert([
            'dijeta_naziv'=>"Posno"
        ]);
        
        
        $dijeta->insert([
            'dijeta_naziv'=>"Vegetarijansko"
        ]);
        
        
        $dijeta->insert([
            'dijeta_naziv'=>"Bez glutena"
        ]);
        
                    
        $data['success']='SUCCESS';
        $this->sendAJAX($data);
    }
    
    /** Autor: Filip Lucic 17/0188 - omogucava menadzeru da doda novo jelo u bazu podataka.
     * Funkcija dodaje novo jelo u bazu, u skladu sa parametrima koje je menadzer uneo, 
     * a koji se prenose putem AJAX tehnologije. Uspesno dodato jelo se vraca nazad putem AJAX-a,
     * i za njegov ispis je odgovoran javascript */
    public function dodajJelo () {     
        $jelo = $this->receiveAJAX();
      
        $tip = new Tipjela();
        $ukus =  new Ukus();
        $dijeta = new Dijeta();
        $jeloModel=new Jelo();
       
        $tip_id = $tip->dohvIdPoNazivu($jelo['jelo_tipjela']);
        $ukus_id = $ukus->dohvIdPoNazivu($jelo['jelo_ukus']);
        $dijeta_id = $dijeta->dohvIdPoNazivu($jelo['jelo_dijeta']);
        
        $jelo['jelo_id']=$jeloModel->insert([
            'jelo_naziv'=>$jelo['jelo_naziv'],
            'jelo_opis'=>$jelo['jelo_opis'],
            'jelo_cena'=>$jelo['jelo_cena'],
            'jelo_masa'=>$jelo['jelo_masa'],
            'jelo_slika'=>$jelo['jelo_slika'],
            'jelo_tipjela_id'=>$tip_id,
            'jelo_ukus_id'=>$ukus_id,
            'jelo_dijeta_id'=>$dijeta_id 
        ]);      
        $this->sendAJAX($jelo); 
    }
    
    /**Autor: Jovana Jankovic 0586/17 
     * public function updateJelo(){...}
     * 
     * Funkcija vrsi update konkretnog jela koje je  menadzer promenio
     * Funkcija koristi AJAX kojim prima nove podatke o jelu koje 
     * treba ubaciti u bazu podataka. Nakon toga ce to kontkretno jelo
     * biti azurirano .
     *  */
    public function updateJelo(){
        
        $jelo = $this->receiveAJAX();
        $tip = new Tipjela();
        $ukus =  new Ukus();
        $dijeta = new Dijeta();
        $jeloModel = new Jelo();
         
        $tip_id = $tip->dohvIdPoNazivu($jelo['jelo_tipjela']);
        $ukus_id = $ukus->dohvIdPoNazivu($jelo['jelo_ukus']);
        $dijeta_id = $dijeta->dohvIdPoNazivu($jelo['jelo_dijeta']);
                
        if(!isset($jelo['jelo_cena']))
         {   
                if(!isset($jelo['jelo_masa'])){    
                $jeloModel->update($jelo['jelo_id'],[
                'jelo_naziv'=>$jelo['jelo_naziv'],
                'jelo_opis'=>$jelo['jelo_opis'],
                'jelo_tipjela_id'=>$tip_id,
                'jelo_ukus_id'=>$ukus_id,
                'jelo_dijeta_id'=>$dijeta_id
                    ]);
                $this->sendAJAX($jelo); 
                return;
          }
             else
             {
                $jeloModel->update($jelo['jelo_id'],[
                'jelo_naziv'=>$jelo['jelo_naziv'],
                'jelo_opis'=>$jelo['jelo_opis'],
                'jelo_masa'=>$jelo['jelo_masa'],
                'jelo_tipjela_id'=>$tip_id,
                'jelo_ukus_id'=>$ukus_id,
                'jelo_dijeta_id'=>$dijeta_id 
            ]);

                $this->sendAJAX($jelo); 
                return;
             }
            
        }
        elseif(!isset($jelo['jelo_masa'])){
            $jeloModel->update($jelo['jelo_id'],[
            'jelo_naziv'=>$jelo['jelo_naziv'],
            'jelo_opis'=>$jelo['jelo_opis'],
            'jelo_cena'=>$jelo['jelo_cena'],
            'jelo_tipjela_id'=>$tip_id,
            'jelo_ukus_id'=>$ukus_id,
            'jelo_dijeta_id'=>$dijeta_id 
        ]);
            $this->sendAJAX($jelo); 
            return;
        }
        else{
        
        $jeloModel->update($jelo['jelo_id'],[
            'jelo_naziv'=>$jelo['jelo_naziv'],
            'jelo_opis'=>$jelo['jelo_opis'],
            'jelo_cena'=>$jelo['jelo_cena'],
            'jelo_masa'=>$jelo['jelo_masa'],
            'jelo_tipjela_id'=>$tip_id,
            'jelo_ukus_id'=>$ukus_id,
            'jelo_dijeta_id'=>$dijeta_id 
        ]);
 
            $this->sendAJAX($jelo); 
        }    
    }
     /**  public function dohvatiSvaJela() {...}
      * Autor: Filip Lucic 17/0188 - omogucava menadzeru da dohvati sva jela, prosledi ih putem AJAX-a javascriptu. Poziva se
      *  pri ucitavanju stranice. */
    public function dohvatiSvaJela() {
        $jeloModel = new Jelo();
        $jela = $jeloModel->dohvatiSveBezSlike();
        $this->sendAJAX($jela);       
    }
    
    /**Autor: Jovana Jankovic 17/0586 -
     * public function obrisiJelo(){...} 
     * 
     * Funkcija pomocu AJAX-a prima jelo koje je menadzer obelezio za brisanje
     * Ova funkcija omogucava brisanje (soft delete) jela iz ponude ketering servisa */
    public function obrisiJelo(){
        $jelo = $this->receiveAJAX();
        $jeloModel = new Jelo();
        $jeloModel->delete($jelo['jelo_id']);
        $data=[
            'success'=>"Uspesno ste izbrisali jelo iz ponude!",
            'jelo_id'=> $jelo['jelo_id']
        ];
        $this->sendAJAX($data);       
    }
    
    /**Autor: Jovana Jankovic 0586/17 - 
     *  public function sakrijJelo(){...}
     * 
     *  Omogucava sakrivanje jela iz ponude ukoliko menadzer
     *  pritisne odredjeno dugme na svom interfejsu. 
     *  Na taj nacin, to jelo vise nece biti prikazano musetiji 
     *  kad bude pregledao sajt. */
    public function sakrijJelo(){
        $jelo = $this->receiveAJAX();
        $jeloModel = new Jelo();
        $jeloModel->update($jelo['jelo_id'],
                ['jelo_datsakriv'=> date('Y-m-d H:i:s')]);
        $data=[
            'success'=>"Uspesno ste sakrili jelo iz ponude!",
            'jelo_id'=> $jelo['jelo_id']
        ];
        $this->sendAJAX($data);   
    }
    
    /**  public function otkrijJelo() {...}
     * Autor: Filip Lucic 0188/17 - otkriva jelo tako da se ono opet prikazuje u ponudi musterijama. 
     * Prethodno sakriveno jelo koje nije u ponudi postaje ponovo dostupno nakon poziva ove funkcije.
     * Ono opet postaje vidljivo u pregledu jela obicnog korisnika.
     *      */
    public function otkrijJelo() {
        $jelo = $this->receiveAJAX();
        $jeloModel = new Jelo();
        $jeloModel->update($jelo['jelo_id'],[
                'jelo_datsakriv'=>null                    
        ]);
        $data=[
            'success'=>"Uspesno ste otkrili jelo iz ponude!",
            'jelo_id'=> $jelo['jelo_id']
        ];
        $this->sendAJAX($data);   
    }
    
    /**Autor: Jovana Jankovic 0586/17 -
     * public function dodajPorudzbinu(){...}
     * 
     * Pomocna funkcija za dodavanje porudzbine u bazu.
     * Koriscena je dok jos uvek nije postojala korpa musterije
     * radi testiranje funkcionalnosti za pregled porudzbine.   */
   public function dodajPorudzbinu(){
       $porudzbina=new Por();
       $povod=new Povod();
       $korisnik=new Kor();
       $por_povod_id = $povod->povodId("ostalo");
       $kor_id=$korisnik->dohvatiIdNaOsnovuImena("menadzer");
       $por['por_id']=$porudzbina->insert([
            'por_kor_id'=>$kor_id,
            'por_naziv'=>"Pobeda na sajmu kretena",
            'por_povod_id'=>$por_povod_id,
            'por_br_osoba'=>1200,
            'por_za_dat'=>date("Y-m-d H:i:s"),
            'por_popust_proc'=>10
        ]);         
        $this->sendAJAX($por); 
   }
   
   /**Autor: Jovana Jankovic 0586/17
    * public function dodajStavku(){...}
    
    * Pomocna funkcija za dodavanje stavki u bazu.
    * Koriscena je dok jos uvek nije postojala korpa musterije 
    * radi testiranja funkcionalnosti za pregled porudzbine. */
   public function dodajStavku(){
       $porudzbinaModel=new Por();
       $jeloModel=new Jelo();
       $stavkaModel=new Stavka();
       $porudzbine=$porudzbinaModel->dohvatiSvePorudzbine();
       $jela=$jeloModel->dohvSve();  
       for ($i = 0; $i < count($porudzbine); $i++) {
            $stavkaModel->insert([
                'stavka_por_id'=>$porudzbine[1]->por_id,
                'stavka_jelo_id'=>$jela[$i]->jelo_id,
                'stavka_kol'=>$i+3,
                'stavka_cenakom'=>$jela[$i]->jelo_cena
            ]);
       }        
    $this->sendAJAX($jela); 
   }
   
   /**Autor: Jovana Jankovic 0586/17, Filip Lucic 0188/17 
     * public function dohvatiPorudzbineKorisnik(){...} 
     * 
     * Dohvatanje svih porudzbina za ulogovanog korisnika.
     * Na osnovu id porudzbine dohvatamo stavke te konkretne porudzbine.
     * Iz svake stavke, koriscenjem modela Jela, dohvatamo neophodne 
     * informacije o samom jelu iz konkretne porudzbine
     * i na taj nacin vracamo potrebne podatke kako bi se 
     * porudzbine prikazale korisniku na adekvatan nacin. 
     * Ova metoda vraca niz porudzbina koriscenjem Ajax-a. */
   
   /** Filip Lucic 0188/17 - dopuna statusa za porudzbine u skladu sa bazom*/
   public function dohvatiPorudzbine(){
         $porudzbina=new Por();
         $por=$porudzbina->svePoslatePorudzbine();
         $korisnikModel=new Kor();
         $stavkaModel=new Stavka();
         $jeloModel=new Jelo();
         $povodModel=new Povod();
         
        $naziv_jela;
        $masa_jela;
        $kol_jela;
        $cena_jela;
         
          for ($i = 0; $i < count($por); $i++) {
           $ime=$korisnikModel->dohvatiImeNaOsnovuId($por[$i]->por_kor_id);
           $telefon=$korisnikModel->dohvatiBrojTelefona($por[$i]->por_kor_id); 
           $stavke=$stavkaModel->dohvatiStavke($por[$i]->por_id);
            
                for($j=0; $j<count($stavke); $j++){
                    $naziv_jela[$j]=$jeloModel->dohvatiNazivJela($stavke[$j]->stavka_jelo_id);      
                    $masa_jela[$j]=$jeloModel->dohvatiMasu($stavke[$j]->stavka_jelo_id);
                    $kol_jela[$j]=$stavke[$j]->stavka_kol;
                    $cena_jela[$j]=$stavke[$j]->stavka_cenakom;
                }
                 
            //dodavanje atributa objektu
            $por[$i]->ime_korisnika=$ime;
            $por[$i]->telefon_korisnika=$telefon;
            $por[$i]->naziv_jela=$naziv_jela;
            $por[$i]->masa_jela=$masa_jela;
            $por[$i]->kol_jela=$kol_jela;
            $por[$i]->cena_jela=$cena_jela;
            
            if($por[$i]->por_popust_proc!=0){
                $por[$i]->popust=true;
            }else{
              $por[$i]->popust=false;
            }
            
            $opis=$povodModel->povodOpis($por[$i]->por_povod_id);
            $por[$i]->por_naziv=$opis;
           
            
            if($por[$i]->por_datodluke==null)
                $por[$i]->status = 0;
            if($por[$i]->por_odluka==='prihvacena')
                $por[$i]->status = 1;
            if($por[$i]->por_odluka==='odbijena')
                $por[$i]->status = 2;    
            if($por[$i]->por_datizrade!=null)
                $por[$i]->status = 3;
            if($por[$i]->por_datpreuz!=null)
                $por[$i]->status = 4;
            
            $naziv_jela = null;
            $masa_jela = null;
            $kol_jela = null;
            $cena_jela = null;
          }  
         $this->sendAJAX($por); 
   }
   /**  public function prihvatiPorudzbinu() {...}
    * Autor:Filip Lucic 0188/17 v0.1 - funkcija za prihvatanje porudzbine 
    * Funkcija postavlja datum odluke i pozitivnu odluku u bazu podataka.
    * Menadzer i korisnik mogu videti rezultat ove funkcije u prikazu porudzbina
    * na svojim stranicama.
    * 
    *     */
   public function prihvatiPorudzbinu() {
       $prihv = $this->receiveAJAX();
       $por = new Por();
       $por->update($prihv['por_id'], [
           'por_datodluke'=>date("Y-m-d H:i:s"),
           'por_odluka'=>'prihvacena'
       ]);
       $prihv['status']=1;
       $this->sendAJAX($prihv);    
   }
    /** public function odbijPorudzbinu() {...} 
     * Autor:Filip Lucic 0188/17 v0.1 - funkcija za odbijanje porudzbine
    * Funkcija postavlja datum odluke i negativnu odluku u bazu podataka.
    * Menadzer i korisnik mogu videti rezultat ove funkcije u prikazu porudzbina
    * na svojim stranicama.
    *      */
   public function odbijPorudzbinu() {
       $odb = $this->receiveAJAX();
       $por = new Por();
       $por->update($odb['por_id'], [
           'por_datodluke'=>date("Y-m-d H:i:s"),
           'por_odluka'=>'odbijena'
       ]);
       $odb['status']=2;
       $this->sendAJAX($odb);  
   }
   
    /** public function arhivirajPorudzbinu() {...}
     * Autor:Filip Lucic 0188/17 v0.1 - funkcija za arhiviranje porudzbine
     * Funkcija arhivira konkretnu porudzbinu, promena je vidljiva kod menadzerovog prikaza.
     *      */
   public function arhivirajPorudzbinu() {
       $arh = $this->receiveAJAX();
       $por = new Por();
       $por->update($arh['por_id'], [
           'por_datpreuz'=>date("Y-m-d H:i:s"),
           'por_odluka'=>'arhivirana'
       ]);
       $arh['status']=4;
       $this->sendAJAX($arh);  
   }
   
    //-----------------------------------------------
    /** public function dohvatiSliku(){...}
     * Dohvata sliku za jelo ciji id dobije AJAX-om
     */
    public function dohvatiSliku() 
    {
        $jelo = new Jelo();
        $data = $this->receiveAJAX();
        
        $slika = $jelo->dohvatiSliku($data['jelo_id']);
        
        $data = [
            "jelo_slika" => $slika
        ];
        $this->sendAJAX($data);
    }
    
    //-----------------------------------------------
    /** public function updateSlika(){...}
     * Cuva sliku dobijenu AJAX-om za jelo ciji id isto dobije     
     */
    public function updateSlika()
    {
        $jeloModel = new Jelo();
        $jelo = $this->receiveAJAX();
        $jeloModel->update($jelo['jelo_id'], ['jelo_slika' => $jelo['jelo_slika']]);
    }
}
