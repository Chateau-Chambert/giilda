<?php
class StatistiqueLatex extends GenericLatex 
{
	protected $csv;
	protected $type;
	protected $options;

  	function __construct($csv, $type, $options = array()) 
  	{
    	sfProjectConfiguration::getActive()->loadHelpers("Partial", "Url", "MyHelper");
    	$this->csv = $csv;
    	$this->type = $type;
    	$this->options = $options;
  	}

  	public function getNbPages() 
  	{
    	return 1;
  	}

  	public function getLatexFileNameWithoutExtention() 
  	{
    	return $this->getTEXWorkingDir().'statistiques_'.$this->type.'_'.date('c');
  	}

  	public function getLatexFileContents() 
  	{
    	return html_entity_decode(htmlspecialchars_decode(get_partial('statistique/pdf', array('csv' => $this->csv, 'type' => $this->type, 'options' => $this->options)), HTML_ENTITIES));
  	}

  	public function getPublicFileName($extention = '.pdf') 
  	{
    	return 'statistiques_'.$this->type.'_'.date('c').$extention;
  	}
}