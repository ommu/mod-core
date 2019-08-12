<?php
/**
 * CoreLanguages
 *
 * This is the ActiveQuery class for [[\ommu\core\models\CoreLanguages]].
 * @see \ommu\core\models\CoreLanguages
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 22 March 2019, 17:03 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\models\query;

class CoreLanguages extends \yii\db\ActiveQuery
{
	/*
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
	*/

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\CoreLanguages[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\CoreLanguages|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
