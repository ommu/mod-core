<?php
/**
 * CorePageViewHistory
 *
 * This is the ActiveQuery class for [[\ommu\core\models\CorePageViewHistory]].
 * @see \ommu\core\models\CorePageViewHistory
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 31 January 2019, 16:07 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\models\query;

class CorePageViewHistory extends \yii\db\ActiveQuery
{
	/*
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
	*/

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\CorePageViewHistory[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\CorePageViewHistory|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
