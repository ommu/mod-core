<?php
/**
 * CorePages
 *
 * CorePages represents the model behind the search form about `ommu\core\models\CorePages`.
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 ECC UGM (ecc.ft.ugm.ac.id)
 * @created date 2 October 2017, 16:08 WIB
 * @modified date 20 April 2018, 09:57 WIB
 * @link http://ecc.ft.ugm.ac.id
 *
 */

namespace ommu\core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ommu\core\models\CorePages as CorePagesModel;

class CorePages extends CorePagesModel
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['page_id', 'publish', 'name', 'desc', 'quote', 'media_show', 'media_type', 'creation_id', 'modified_id'], 'integer'],
			[['media', 'creation_date', 'modified_date', 'updated_date', 'slug', 
				'name_i', 'desc_i', 'quote_i', 'creation_search', 'modified_search', 'view_search', 'media_search'], 'safe'],
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
		$query = CorePagesModel::find()->alias('t');
		$query->joinWith([
			'view view', 
			'title title', 
			'description description', 
			'quoteRltn quoteRltn', 
			'creation creation', 
			'modified modified'
		]);

		// add conditions that should always apply here
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$attributes = array_keys($this->getTableSchema()->columns);
		$attributes['name_i'] = [
			'asc' => ['title.message' => SORT_ASC],
			'desc' => ['title.message' => SORT_DESC],
		];
		$attributes['desc_i'] = [
			'asc' => ['description.message' => SORT_ASC],
			'desc' => ['description.message' => SORT_DESC],
		];
		$attributes['quote_i'] = [
			'asc' => ['quoteRltn.message' => SORT_ASC],
			'desc' => ['quoteRltn.message' => SORT_DESC],
		];
		$attributes['creation_search'] = [
			'asc' => ['creation.displayname' => SORT_ASC],
			'desc' => ['creation.displayname' => SORT_DESC],
		];
		$attributes['modified_search'] = [
			'asc' => ['modified.displayname' => SORT_ASC],
			'desc' => ['modified.displayname' => SORT_DESC],
		];
		$attributes['media_search'] = [
			'asc' => ['view.media' => SORT_ASC],
			'desc' => ['view.media' => SORT_DESC],
		];
		$attributes['view_search'] = [
			'asc' => ['view.views' => SORT_ASC],
			'desc' => ['view.views' => SORT_DESC],
		];
		$dataProvider->setSort([
			'attributes' => $attributes,
			'defaultOrder' => ['page_id' => SORT_DESC],
		]);

		$this->load($params);

		if(!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			't.page_id' => $this->page_id,
			't.name' => $this->name,
			't.desc' => $this->desc,
			't.quote' => $this->quote,
			't.media_show' => $this->media_show,
			't.media_type' => $this->media_type,
			'cast(t.creation_date as date)' => $this->creation_date,
			't.creation_id' => isset($params['creation']) ? $params['creation'] : $this->creation_id,
			'cast(t.modified_date as date)' => $this->modified_date,
			't.modified_id' => isset($params['modified']) ? $params['modified'] : $this->modified_id,
			'cast(t.updated_date as date)' => $this->updated_date,
			'view.media' => $this->media_search,
			'view.views' => $this->view_search,
		]);

		if(isset($params['trash']))
			$query->andFilterWhere(['NOT IN', 't.publish', [0,1]]);
		else {
			if(!isset($params['publish']) || (isset($params['publish']) && $params['publish'] == ''))
				$query->andFilterWhere(['IN', 't.publish', [0,1]]);
			else
				$query->andFilterWhere(['t.publish' => $this->publish]);
		}

		$query->andFilterWhere(['like', 't.media', $this->media])
			->andFilterWhere(['like', 't.slug', $this->slug])
			->andFilterWhere(['like', 'title.message', $this->name_i])
			->andFilterWhere(['like', 'description.message', $this->desc_i])
			->andFilterWhere(['like', 'quoteRltn.message', $this->quote_i])
			->andFilterWhere(['like', 'creation.displayname', $this->creation_search])
			->andFilterWhere(['like', 'modified.displayname', $this->modified_search]);

		return $dataProvider;
	}
}
