<?php

namespace Dmcblue\ImageResize;

class Config {
	/** Path to look for image files */
	public $originalPath;
	/** Configs for resizing categories */
	public $sizeConfigs = [];
	
	/**
	 * Class constructor. Accepts either a set of parameters or a single
	 * array.
	 * @param type $originalPath The path to the images OR the config array
	 * @param type $sizeConfigs [Optional] Array of SizeConfigs
	 */
	public function __construct ($originalPath, $sizeConfigs = null) {
		if(is_array($originalPath)) {
			$configArray = $originalPath; //change variable just for clarity
			$this->originalPath = $configArray['originalPath'];
			foreach($configArray['sizeConfigs'] as $sizeConfigVars) {
				$this->sizeConfigs[] = new SizeConfig($sizeConfigVars);
			}
		} else {
			$this->originalPath = (string)$originalPath;
			$this->sizeConfigs = $sizeConfigs;
		}
	}
	
	/**
	 * Validates whether an config array has all the appropriate fields to help
	 * devs troubleshoot
	 * @param array $arrayConfig The configuration array
	 * @return boolean|\Exception
	 */
	static public function validateArray($arrayConfig) {
		if(!array_key_exists('originalPath', $arrayConfig)){
			return new \Exception(sprintf(SizeConfig::ERROR_MISSING_PROPERTY, 'originalPath'));
		} else if(!strlen($arrayConfig['originalPath']) || !realpath($arrayConfig['originalPath'])) {
			return new \Exception(sprintf(SizeConfig::ERROR_INVALID_PATH, $arrayConfig['originalPath']));
		} else if(!array_key_exists('sizeConfigs', $arrayConfig)){
			return new \Exception(sprintf(SizeConfig::ERROR_MISSING_PROPERTY, 'sizeConfigs'));
		} else if(!is_array($arrayConfig['sizeConfigs'])){
			return new \Exception(sprintf(self::ERROR_MISSING_PROPERTY, 'sizeConfigs'));
		} else {
			foreach($arrayConfig['sizeConfigs'] as $sizeConfigArray) {
				$isValid = SizeConfig::validateArray($sizeConfigArray);
				if($isValid !== true) {
					return $isValid;
				}
			}
		}
		
		return true;
	}
}