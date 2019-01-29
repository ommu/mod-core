<?php
/**
 * CoreZoneCity
 *
 * CoreZoneCity represents the model behind the search form about `ommu\core\models\CoreZoneCity`.
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 ECC UGM (ecc.ft.ugm.ac.id)
 * @created date 14 September 2017, 22:22 WIB
 * @modified date 24 April 2018, 23:00 WIB
 * @link http://ecc.ft.ugm.ac.id
 *
 */

namespace ommu\core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ommu\core\models\CoreZoneCity as CoreZoneCityModel;

class CoreZoneCity extends CoreZoneCityModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'publish', 'province_id', 'checked', 'creation_id', 'modified_id'], 'integer'],
            [['city_name', 'mfdonline', 'creation_date', 'modified_date', 'updated_date', 'slug',
                'province_search', 'country_search', 'creation_search', 'modified_search'], 'safe'],
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
        $query = CoreZoneCityModel::find()->alias('t');
        $query->joinWith(['province province', 'province.country country', 'creation creation', 'modified modified']);

		// add conditions that should always apply here
		$dataParams = [
			'query' => $query,
		];
		// disable pagination agar data pada api tampil semua
		if(isset($params['pagination']) && $params['pagination'] == 0) {
			$dataParams['pagination'] = false;
		}
		$dataProvider = new ActiveDataProvider($dataParams);

        $attributes = array_keys($this->getTableSchema()->columns);
        $attributes['province_search'] = [
            'asc' => ['province.province_name' => SORT_ASC],
            'desc' => ['province.province_name' => SORT_DESC],
        ];
        $attributes['country_search'] = [
            'asc' => ['country.country_name' => SORT_ASC],
            'desc' => ['country.country_name' => SORT_DESC],
        ];
        $attributes['creation_search'] = [
            'asc' => ['creation.displayname' => SORT_ASC],
            'desc' => ['creation.displayname' => SORT_DESC],
        ];
        $attributes['modified_search'] = [
            'asc' => ['modified.displayname' => SORT_ASC],
            'desc' => ['modified.displayname' => SORT_DESC],
        ];

        $sortParams = [];
        if(!isset($params['sort'])) {
            $sortParams['defaultOrder'] = ['city_id' => SORT_DESC];
        }
        $sortParams = ['attributes' => $attributes];
        $dataProvider->setSort($sortParams);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            't.city_id' => $this->city_id,
            't.province_id' => isset($params['province']) ? $params['province'] : $this->province_id,
            't.checked' => $this->checked,
            'cast(t.creation_date as date)' => $this->creation_date,
            't.creation_id' => isset($params['creation']) ? $params['creation'] : $this->creation_id,
            'cast(t.modified_date as date)' => $this->modified_date,
            't.modified_id' => isset($params['modified']) ? $params['modified'] : $this->modified_id,
            'cast(t.updated_date as date)' => $this->updated_date,
        ]);

        if(isset($params['trash']))
            $query->andFilterWhere(['NOT IN', 't.publish', [0,1]]);
        else {
            if(!isset($params['publish']) || (isset($params['publish']) && $params['publish'] == ''))
                $query->andFilterWhere(['IN', 't.publish', [0,1]]);
            else
                $query->andFilterWhere(['t.publish' => $this->publish]);
        }
        
        if(isset($params['country']))
            $query->andFilterWhere(['country.country_id' => $params['country']]);

        $query->andFilterWhere(['like', 't.city_name', $this->city_name])
            ->andFilterWhere(['like', 't.mfdonline', $this->mfdonline])
            ->andFilterWhere(['like', 't.slug', $this->slug])
            ->andFilterWhere(['like', 'province.province_name', $this->province_search])
            ->andFilterWhere(['like', 'creation.displayname', $this->creation_search])
            ->andFilterWhere(['like', 'modified.displayname', $this->modified_search]);

        return $dataProvider;
    }
}
