<?php

class FactureGenerationForm extends BaseForm {

    const TYPE_DOCUMENT_TOUS = "TOUS";
    const TYPE_GENERATION_EXPORT = "EXPORT";

    public function __construct($defaults = array(), $options = array(), $CSRFSecret = null) {
        $defaults['date_facturation'] = date('d/m/Y');
        $this->withExport = false;
        if (isset($options['export']) && $options['export']) {
		$this->withExport = true;
	}
        parent::__construct($defaults, $options, $CSRFSecret);
    }

    public function configure() {
        $this->setWidget('modele', new bsWidgetFormChoice(array('choices' => $this->getChoices(), 'expanded' => true)));
        $this->setWidget('date_mouvement', new bsWidgetFormInputDate());
        $this->setWidget('date_facturation', new bsWidgetFormInputDate());
        $this->setWidget('message_communication', new sfWidgetFormTextarea());

        $this->setValidator('modele', new sfValidatorChoice(array('choices' => array_keys($this->getChoices()), 'required' => true)));
        $this->setValidator('date_mouvement', new sfValidatorString(array('required' => false)));
        $this->setValidator('date_facturation', new sfValidatorString());
        $this->setValidator('message_communication', new sfValidatorString(array('required' => false)));

        $this->widgetSchema->setLabels(array(
            'modele' => "Type de facturation :",
            'message_communication' => 'Cadre de communication :',
            'date_mouvement' => 'Dernière date de prise en compte des mouvements :',
            'date_facturation' => 'Date de facturation :'
        ));
        $this->widgetSchema->setNameFormat('facture_generation[%s]');
    }

    public function getChoices() {
        $choices = array_merge(FactureClient::$type_facture_mouvement);
        $choices = array_merge($choices, array(self::TYPE_GENERATION_EXPORT => 'Export SAGE'));
        return $choices;
    }

}
