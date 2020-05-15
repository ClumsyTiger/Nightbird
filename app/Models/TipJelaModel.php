<?php namespace App\Models;


use CodeIgniter\Model;

class TipJelaModel extends Model {
        protected $table      = 'tipjela';
        protected $primaryKey = 'tipjela_id';
        protected $returnType = 'object';
        protected $allowedFields = ['tipjela_id','tipjela_naziv'];
        
       
        protected $validationRules    = [
                        'tipjela_naziv' => 'trim|required|is_unique[tipjela.tipjela_naziv]'];
        protected $validationMessages = ['tipjela_naziv' => ['required' => 'Naziv tipa jela je obavezan!']];
        protected $skipValidation = false;
       
       //dohvata se tip, pa se u kontroleru dohvata naziv;
        public function dohvTip($id) {
             $id = \UUID::codeId($id);
             return $this->find($id);
        }
        //direktno dohvata naziv
        public function dohvNazivTipa($id) {
            $id = \UUID::codeId($id);
            $naziv = $this->find($id);
            return $naziv->tipjela_naziv;
        }
         public function insert($data=NULL, $returnID=true) {
             $id = \UUID::generateId();        
             $data['tipjela_id'] = $id;
             if(parent::insert($data, $returnID) === false){
                 echo '<h3>Greske u formi unosa:</h3>';
                 $errors = $this->errors();
                 foreach ($errors as $error) {
                     echo "<p>->$error</p>";   
                 }
                 return false;
             }
             return \UUID::decodeId($id);
         }


         public function delete($id=NULL, $purge=false) {
             if ($id != null) {
                 $id = \UUID::codeId($id);
             }
             return parent::delete($id, $purge);
         }

    
    
    
}