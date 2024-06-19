<?php
/**
 * CoreZoneCountry
 *
 * This is the ActiveQuery class for [[\ommu\core\models\CoreZoneCountry]].
 * @see \ommu\core\models\CoreZoneCountry
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2018 OMMU (www.ommu.id)
 * @created date 26 April 2018, 20:40 WIB
 * @modified date 30 January 2019, 16:07 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\models\query;

class CoreZoneCountry extends \yii\db\ActiveQuery
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
	public function suggest()
	{
		return $this->select(['country_id', 'country_name', 'code']);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\CoreZoneCountry[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\CoreZoneCountry|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
