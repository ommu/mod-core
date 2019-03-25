<?php
/**
 * CoreSettings
 *
 * This is the ActiveQuery class for [[\ommu\core\models\CoreSettings]].
 * @see \ommu\core\models\CoreSettings
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 25 March 2019, 09:13 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\models\query;

class CoreSettings extends \yii\db\ActiveQuery
{
	/*
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
	*/

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\CoreSettings[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\CoreSettings|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
