<?php
/**
 * CoreZoneCountry
 *
 * CoreZoneCountry represents the model behind the search form about `ommu\core\models\CoreZoneCountry`.
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 11 September 2017, 10:39 WIB
 * @modified date 24 April 2018, 22:41 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ommu\core\models\CoreZoneCountry as CoreZoneCountryModel;

class CoreZoneCountry extends CoreZoneCountryModel
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['country_id', 'creation_id', 'modified_id'], 'integer'],
			[['country_name', 'code', 'creation_date', 'modified_date', 'slug',
				'creation_search', 'modified_search'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
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
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = CoreZoneCountryModel::find()->alias('t');
		$query->joinWith([
			'creation creation', 
			'modified modified'
		]);

		// add conditions that should always apply here
		$dataParams = ['query' => $query];
		if(isset($params['pagination']) && $params['pagination'] == 0)
			$dataParams['pagination'] = false;

		$dataProvider = new ActiveDataProvider($dataParams);

		$attributes = array_keys($this->getTableSchema()->columns);
		$attributes['creation_search'] = [
			'asc' => ['creation.displayname' => SORT_ASC],
			'desc' => ['creation.displayname' => SORT_DESC],
		];
		$attributes['modified_search'] = [
			'asc' => ['modified.displayname' => SORT_ASC],
			'desc' => ['modified.displayname' => SORT_DESC],
		];
		$dataProvider->setSort([
			'attributes' => $attributes,
			'defaultOrder' => ['country_id' => SORT_DESC],
		]);

		$this->load($params);

		if(!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			't.country_id' => $this->country_id,
			'cast(t.creation_date as date)' => $this->creation_date,
			't.creation_id' => isset($params['creation']) ? $params['creation'] : $this->creation_id,
			'cast(t.modified_date as date)' => $this->modified_date,
			't.modified_id' => isset($params['modified']) ? $params['modified'] : $this->modified_id,
		]);

		$query->andFilterWhere(['like', 't.country_name', $this->country_name])
			->andFilterWhere(['like', 't.code', $this->code])
			->andFilterWhere(['like', 't.slug', $this->slug])
			->andFilterWhere(['like', 'creation.displayname', $this->creation_search])
			->andFilterWhere(['like', 'modified.displayname', $this->modified_search]);

		return $dataProvider;
	}
}
