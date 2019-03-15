<?php
/**
 * CoreZoneDistrict
 *
 * CoreZoneDistrict represents the model behind the search form about `ommu\core\models\CoreZoneDistrict`.
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 15 September 2017, 10:26 WIB
 * @modified date 30 January 2019, 17:14 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ommu\core\models\CoreZoneDistrict as CoreZoneDistrictModel;

class CoreZoneDistrict extends CoreZoneDistrictModel
{
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['district_id', 'publish', 'city_id', 'checked', 'creation_id', 'modified_id'], 'integer'],
			[['district_name', 'mfdonline', 'creation_date', 'modified_date', 'updated_date', 'slug',
				'cityName', 'creationDisplayname', 'modifiedDisplayname', 'provinceName', 'countryName'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Tambahkan fungsi beforeValidate ini pada model search untuk menumpuk validasi pd model induk. 
	 * dan "jangan" tambahkan parent::beforeValidate, cukup "return true" saja.
	 * maka validasi yg akan dipakai hanya pd model ini, semua script yg ditaruh di beforeValidate pada model induk
	 * tidak akan dijalankan.
	 */
	public function beforeValidate() {
		return true;
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params, $column=null)
	{
		if(!($column && is_array($column)))
			$query = CoreZoneDistrictModel::find()->alias('t');
		else
			$query = CoreZoneDistrictModel::find()->alias('t')->select($column);
		$query->joinWith([
			'city city', 
			'creation creation', 
			'modified modified',
			'city.province province',
			'city.province.country country',
		]);

		// add conditions that should always apply here
		$dataParams = [
			'query' => $query,
		];
		// disable pagination agar data pada api tampil semua
		if(isset($params['pagination']) && $params['pagination'] == 0)
			$dataParams['pagination'] = false;
		$dataProvider = new ActiveDataProvider($dataParams);

		$attributes = array_keys($this->getTableSchema()->columns);
		$attributes['cityName'] = [
			'asc' => ['city.city_name' => SORT_ASC],
			'desc' => ['city.city_name' => SORT_DESC],
		];
		$attributes['creationDisplayname'] = [
			'asc' => ['creation.displayname' => SORT_ASC],
			'desc' => ['creation.displayname' => SORT_DESC],
		];
		$attributes['modifiedDisplayname'] = [
			'asc' => ['modified.displayname' => SORT_ASC],
			'desc' => ['modified.displayname' => SORT_DESC],
		];
		$attributes['provinceName'] = [
			'asc' => ['province.province_name' => SORT_ASC],
			'desc' => ['province.province_name' => SORT_DESC],
		];
		$attributes['countryName'] = [
			'asc' => ['country.country_name' => SORT_ASC],
			'desc' => ['country.country_name' => SORT_DESC],
		];
		$dataProvider->setSort([
			'attributes' => $attributes,
			'defaultOrder' => ['district_id' => SORT_DESC],
		]);

		$this->load($params);

		if(!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			't.district_id' => $this->district_id,
			't.city_id' => isset($params['city']) ? $params['city'] : $this->city_id,
			't.checked' => $this->checked,
			'cast(t.creation_date as date)' => $this->creation_date,
			't.creation_id' => isset($params['creation']) ? $params['creation'] : $this->creation_id,
			'cast(t.modified_date as date)' => $this->modified_date,
			't.modified_id' => isset($params['modified']) ? $params['modified'] : $this->modified_id,
			'cast(t.updated_date as date)' => $this->updated_date,
		]);

		if(isset($params['province']))
			$query->andFilterWhere(['province.province_id' => $params['province']]);
		if(isset($params['country']))
			$query->andFilterWhere(['country.country_id' => $params['country']]);

		if(isset($params['trash']))
			$query->andFilterWhere(['NOT IN', 't.publish', [0,1]]);
		else {
			if(!isset($params['publish']) || (isset($params['publish']) && $params['publish'] == ''))
				$query->andFilterWhere(['IN', 't.publish', [0,1]]);
			else
				$query->andFilterWhere(['t.publish' => $this->publish]);
		}

		$query->andFilterWhere(['like', 't.district_name', $this->district_name])
			->andFilterWhere(['like', 't.mfdonline', $this->mfdonline])
			->andFilterWhere(['like', 't.slug', $this->slug])
			->andFilterWhere(['like', 'city.city_name', $this->cityName])
			->andFilterWhere(['like', 'creation.displayname', $this->creationDisplayname])
			->andFilterWhere(['like', 'modified.displayname', $this->modifiedDisplayname])
			->andFilterWhere(['like', 'province.province_name', $this->provinceName])
			->andFilterWhere(['like', 'country.country_name', $this->countryName]);

		return $dataProvider;
	}
}
