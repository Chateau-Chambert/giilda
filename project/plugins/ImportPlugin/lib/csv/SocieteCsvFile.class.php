<?php 

class SocieteCsvFile extends CsvFile 
{
    const CSV_ID = 0;
    const CSV_TYPE = 1;
    const CSV_NOM = 2;
    const CSV_NOM_REDUIT = 3;
    const CSV_STATUT = 4;
    const CSV_TYPE_FOURNISSEUR = 5;
    const CSV_SIRET = 6;
    const CSV_CODE_NAF = 7;
    const CSV_TVA_INTRACOMMUNAUTAIRE = 8;
    const CSV_ADRESSE = 9;
    const CSV_ADRESSE_COMPLEMENTAIRE_1 = 10;
    const CSV_ADRESSE_COMPLEMENTAIRE_2 = 11;
    const CSV_ADRESSE_COMPLEMENTAIRE_3 = 12;
    const CSV_CODE_POSTAL = 13;
    const CSV_COMMUNE = 14;
    const CSV_CEDEX = 15;
    const CSV_PAYS = 16;
    const CSV_EMAIL = 17;
    const CSV_TEL_BUREAU = 18;
    const CSV_TEL_PERSO = 19;
    const CSV_MOBILE = 20;
    const CSV_FAX = 21;
    const CSV_WEB = 22;
    const CSV_COMMENTAIRE = 23; 

    private function verifyCsvLine($line) {
        if (!preg_match('/[0-9]+/', $line[self::CSV_ID])) {

            throw new Exception(sprintf('ID invalide : %s', $line[self::CSV_ID]));
        }
    }

    public function importSocietes () {
        $this->errors = array();
        $societes = array();
        $csvs = $this->getCsv();
        foreach ($csvs as $line) {
            try {
              	$this->verifyCsvLine($line);
                $id = sprintf("%06d", $line[self::CSV_ID]);

              	$s = SocieteClient::getInstance()->find($id, acCouchdbClient::HYDRATE_JSON);
                if ($s) {
        	          echo "ERROR: Societe exists (".$id.")\n";
        	          continue;
                }

              	$s = new Societe();
                $s->identifiant = $id;
                $s->constructId();
                $s->raison_sociale = trim($line[self::CSV_NOM]);
        	    $s->raison_sociale_abregee = trim($line[self::CSV_NOM_REDUIT]);
              	$s->interpro = 'INTERPRO-declaration';
                $s->siret = $line[self::CSV_SIRET];
                $s->code_naf = $line[self::CSV_CODE_NAF];
                $s->no_tva_intracommunautaire = $line[self::CSV_TVA_INTRACOMMUNAUTAIRE];
                $s->commentaire = $line[self::CSV_COMMENTAIRE];
                /*if ($line[self::CSV_COOPGROUP] == 'C') {
              		$s->cooperative = 1;
                }*/
                $s->statut = $line[self::CSV_STATUT];
                $s->type_societe = $line[self::CSV_TYPE];
  	            /*if ($line[self::CSV_ENSEIGNE]) {
	                $s->enseignes->add(null, $line[self::CSV_ENSEIGNE]);
                }*/
                /*if($line[self::CSV_CODE_FOURNISSEUR]){
                    $s->code_comptable_fournisseur = sprintf('%08d', $line[self::CSV_CODE_FOURNISSEUR]);                
                }*/
                /*$s->add('type_fournisseur', array());
                if($line[self::CSV_CODE_FOURNISSEUR]){
                    $fournisseur_tag = preg_replace ('/([A-Za-z ]*)(MDV|PLV)/','$2',$line[self::CSV_CODE_FOURNISSEUR]);
                    $s->add('type_fournisseur',array($fournisseur_tag));
                }*/
              	$s->save();

                $c = $s->getContact();
                $c->adresse = trim(preg_replace('/,/', '', $line[self::CSV_ADRESSE]));
                if(preg_match('/[a-z]/i', $line[self::CSV_ADRESSE_COMPLEMENTAIRE_1])) {
                    $c->add('adresse_complementaire',trim(preg_replace('/,/', '', $line[self::CSV_ADRESSE_COMPLEMENTAIRE_1])));
                    if(preg_match('/[a-z]/i', $line[self::CSV_ADRESSE_COMPLEMENTAIRE_2])) {
                        $c->adresse_complementaire .= " ; ".trim(preg_replace('/,/', '', $line[self::CSV_ADRESSE_COMPLEMENTAIRE_2]));
                    }
                }
                $c->code_postal = trim($line[self::CSV_CODE_POSTAL]);

                if(!$c->code_postal) {
                     echo "WARNING: le code postal est vide pour la société ".$id_societe."\n";
                }

                if(!preg_match("/^[0-9]{5}$/", $c->code_postal)) {
                     echo "WARNING: le code postal ne semple pas correct : ".$c->code_postal." pour la société ".$id_societe."\n";
                }

                $c->commune = $line[self::CSV_COMMUNE];
                $c->pays = 'FR';
                $c->email = $this->formatAndVerifyEmail($line[self::CSV_EMAIL]);
                $c->fax = $this->formatAndVerifyPhone($line[self::CSV_FAX]);
                $c->telephone_perso = $this->formatAndVerifyPhone($line[self::CSV_TEL_PERSO]);
                $c->telephone_bureau = $this->formatAndVerifyPhone($line[self::CSV_TEL_BUREAU]);
                $c->telephone_mobile = $this->formatAndVerifyPhone($line[self::CSV_MOBILE]);
                if($line[self::CSV_WEB]) {
                    $c->add('site_internet', $line[self::CSV_WEB]);
                }
                $c->save();

            }catch(Exception $e) {
                echo $e->getMessage()."\n";
                $this->error[] = $e->getMessage();
            }
        }

        return $societes;
    } 

    public function getErrors() {
        return $this->errors;
    }
  
    protected function convertCountry($country) {
        $countries = ConfigurationClient::getInstance()->getCountryList();

        if($country == 'FRA') {
          $country = 'FR';
        }

        if($country == 'TU') {
          $country = 'TR';
        }

        if(!array_key_exists($country, $countries)) {
          
          throw new sfException(sprintf("Code pays '%s' invalide", $country));
        }
        
        return $country;
    }

    protected function formatAndVerifyPhone($phone) {

        $phone = str_replace("+33", "0", trim($phone));
        $phone = preg_replace("/[\._ -]/", "", $phone);

        if($phone && strlen($phone) == 9) {
            $phone = "0".$phone;
        }

        if($phone && !preg_match("/^[0-9]{10}$/", $phone)) {
            echo sprintf("Le numéro de téléphone n'est pas correct %s\n", $phone);
        }

        return $phone;
    }

    protected function formatAndVerifyEmail($email) {
        $email = trim($email);

        if($email && !preg_match("/^[a-z0-9çéèàâê_\.-]+@[a-z0-9\.-]+$/i", $email)) {
            echo sprintf("L'email n'est pas correct %s\n", $email);
        }

        return $email;
    }



}
