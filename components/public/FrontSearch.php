<?php
/**
 * FrontSearch
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2013 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */

class FrontSearch extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {		
		$this->render('front_search');	
	}

}
?>