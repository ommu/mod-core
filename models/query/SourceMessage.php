<?php
/**
 * SourceMessage
 *
 * This is the ActiveQuery class for [[\ommu\core\models\SourceMessage]].
 * @see \ommu\core\models\SourceMessage
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 22 March 2019, 18:23 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\models\query;

class SourceMessage extends \yii\db\ActiveQuery
{
	/*
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
	*/

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\SourceMessage[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\SourceMessage|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
