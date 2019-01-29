<?php
/**
 * CoreZoneCountry
 *
 * This is the ActiveQuery class for [[CoreZoneCountry]].
 * @see CoreZoneCountry
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.co)
 * @created date 26 April 2018, 20:40 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\models\query;

class CoreZoneCountry extends \yii\db\ActiveQuery
{
	/**
	 * @inheritdoc
	 * @return IpediaCompanies[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * @inheritdoc
	 * @return IpediaCompanies|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
