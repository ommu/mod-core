<?php
/**
 * CoreZoneCountry
 *
 * This is the ActiveQuery class for [[CoreZoneCountry]].
 * @see CoreZoneCountry
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 ECC UGM (ecc.ft.ugm.ac.id)
 * @created date 26 April 2018, 20:40 WIB
 * @link https://ecc.ft.ugm.ac.id
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
