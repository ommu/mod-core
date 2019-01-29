<?php
/**
 * core module definition class
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 22 December 2017, 03:29 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core;

class Module extends \app\components\Module
{
	public $layout = 'main';

	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'ommu\core\controllers';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
	}
}
