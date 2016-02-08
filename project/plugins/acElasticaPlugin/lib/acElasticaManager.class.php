<?php


class acElasticaManager {
    protected static $_instance;

    
    private function __construct()
    {
    }

    public static function getInstance()
    {
      if ( ! isset(self::$_instance)) {
	self::$_instance = new self();
      }
      return self::$_instance;
    }

    public static function initializeClient($dsn, $dbname) {
      self::getInstance()->_client = new acElasticaClient($dsn, $dbname);
      if (!self::getInstance()->_client->getDefaultIndex())
	throw new Exception($dbname." does not exist");
      return self::getInstance()->_client;
    }

    /**
     *
     * @param string $model
     * @return acCouchdbClient 
     */
    public static function getClient() {
      return self::getInstance()->_client;
    }

    public static function getIndex() {
      if (!isset(self::getInstance()->_client)) 
	throw new sfException('ElasticSearch not reacheable');
      return self::getInstance()->_client->getDefaultIndex();
    }

    public static function getType($type, $elasticType = null) {
    	$statistiquesConfig = sfConfig::get('app_statistiques_'.$type);
    	if (!$statistiquesConfig) {
    		throw new sfException($type.' doesn\'t exist in elasticsearch configuration.');
    	}
    	$client = acElasticaManager::initializeClient($statistiquesConfig['elasticsearch_host'], $statistiquesConfig['elasticsearch_dbname']);
    	$elasticType = ($elasticType)? $elasticType : $statistiquesConfig['elasticsearch_type'];
    	$index = $client->getDefaultIndex()->getType($elasticType);
    	return $index;
    }

}
