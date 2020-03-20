<?php
/**
 * CoreZoneProvince
 *
 * This is the ActiveQuery class for [[\ommu\core\models\CoreZoneProvince]].
 * @see \ommu\core\models\CoreZoneProvince
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.id)
 * @created date 26 April 2018, 20:40 WIB
 * @modified date 30 January 2019, 16:08 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\models\query;

class CoreZoneProvince extends \yii\db\ActiveQuery
{
	/*
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
	*/

	/**
	 * {@inheritdoc}
	 */
	public function published() 
	{
		return $this->andWhere(['t.publish' => 1]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function unpublish() 
	{
		return $this->andWhere(['t.publish' => 0]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function deleted() 
	{
		return $this->andWhere(['t.publish' => 2]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function suggest() 
	{
		return $this->select(['province_id', 'country_id', 'province_name'])
			->published();
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\CoreZoneProvince[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\CoreZoneProvince|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
