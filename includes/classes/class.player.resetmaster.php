<?php
/**
 * WebEngine CMS
 * https://webenginecms.org/
 * 
 * @version 2.0.0
 * @author Lautaro Angelico <https://lautaroangelico.com/>
 * @copyright (c) 2013-2018 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * https://opensource.org/licenses/MIT
 */

class PlayerResetMaster extends Player {
	
	private $_configurationFile = 'character.resetmaster';
	
	protected $_defaultMasterLevel = 0;
	protected $_defaultMasterLevelExp = 0;
	protected $_defaultMasterLevelPoint= 0;
	protected $_rebirthIncrement = 1;
	
	protected $_requiredMastelLevel = 400;
	protected $_requiredZen = 0;
	protected $_resetSkills = false;
	protected $_resetLevelUpPoints = false;
	protected $_rewardLevelUpPoints = 0;
	protected $_multiplyRewardLevelUpPoints = false;
	protected $_resetMasterLimit = 0;
	
	function __construct() {
		parent::__construct();
		
		$cfg = loadModuleConfig($this->_configurationFile);
		if(!is_array($cfg)) throw new Exception(lang('error_66'));
		
		$this->_requiredMastelLevel = $cfg['required_master_level'];
		$this->_requiredZen = $cfg['required_zen'];
		$this->_resetSkills= $cfg['reset_skills'];
		$this->_resetLevelUpPoints = $cfg['reset_leveluppoints'];
		$this->_rewardLevelUpPoints = $cfg['reward_leveluppoints'];
		$this->_multiplyRewardLevelUpPoints = $cfg['multiply_reward_leveluppoints'];
		$this->_resetMasterLimit = $cfg['reset_master_limit'];
		
	}
	
	public function rebirth() {
		if(!check($this->_player)) throw new Exception(lang('error_24'));
		
		// get player information
		$playerInformation = $this->getPlayerInformation();
		if(!is_array($playerInformation)) throw new Exception(lang('error_67'));
		
		// get player master level information
		$playerMLInformation = $this->getPlayerMasterLevelInformation();
		if(!is_array($playerMLInformation)) throw new Exception(lang('error_67'));
		
		// check if player belongs to account
		if(!$this->belongsToAccount()) throw new Exception(lang('error_32'));
		
		// edits begin
		$currentReset = $playerInformation[_CLMN_CHR_MRSTS_];
		$newReset = $currentReset+$this->_rebirthIncrement;
		
		// reset master limit
		if($this->_resetMasterLimit >= 1) {
			if($currentReset >= $this->_resetMasterLimit) throw new Exception(lang('error_230'));
		}
		
		// Master level requirement
		if($this->_requiredMastelLevel >= 1) {
			if($playerMLInformation[_CLMN_ML_LVL_] < $this->_requiredMastelLevel) throw new Exception(lang('error_33'));
			$this->_editValue(_CLMN_ML_LVL_, $this->_defaultMasterLevel);
            $this->_editValue(_CLMN_ML_EXP_, $this->_defaultMasterLevelExp);
		}
		
		// zen requirement
		if($this->_requiredZen >= 1) {
			if($playerInformation[_CLMN_CHR_ZEN_] < $this->_requiredZen) throw new Exception(lang('error_34'));
			$this->_editValue(_CLMN_CHR_ZEN_, ($playerInformation[_CLMN_CHR_ZEN_]-$this->_requiredZen));
		}
		
		// reset skills
		if($this->_resetSkills) {
            // clear skill tree
            if(!$this->_clearMagicList()) throw new Exception(lang('error_74'));
		}
		
		// reset level up points
		if($this->_resetLevelUpPoints) {
            $this->_editValue(_CLMN_ML_POINT_, $this->_defaultMasterLevelPoint);
		}
		
		// reward level up points
		if($this->_rewardLevelUpPoints >= 1) {
			
			$currentLevelUpPoints = $this->_resetLevelUpPoints ? 0 : $playerMLInformation[_CLMN_ML_POINT_];
			$newLevelUpPoints = $currentLevelUpPoints+$this->_rewardLevelUpPoints;
			
			if($this->_multiplyRewardLevelUpPoints) {
				$newLevelUpPoints = $currentLevelUpPoints+($newReset*$this->_rewardLevelUpPoints);
			}
			
			$this->_editValue(_CLMN_ML_POINT_, $newLevelUpPoints);
		}
		
		// rebirth increment
		$this->_editValue(_CLMN_CHR_MRSTS_, $newReset);
		
		// rebirth
		if(!$this->_saveEdits()) throw new Exception(lang('error_68'));
	}
	
	private function _clearMagicList() {
		if(!check($this->_player)) return;
		
		$result = $this->db->query("UPDATE "._TBL_CHR_." SET "._CLMN_CHR_MAGIC_L_." = null WHERE "._CLMN_CHR_NAME_." = ?", array($this->_player));
		if(!$result) return;
		return true;
	}
	
	
}