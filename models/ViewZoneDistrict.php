<?php
/**
 * ViewZoneDistrict
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2015 Ommu Platform (opensource.ommu.co)
 * @modified date 20 January 2018, 06:36 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "_view_core_zone_district".
 *
 * The followings are the available columns in table '_view_core_zone_district':
 * @property string $district_id
 * @property string $district_name
 * @property string $city_id
 * @property string $city_name
 * @property integer $province_id
 * @property string $province_name
 * @property integer $country_id
 * @property string $country_name
 */

class ViewZoneDistrict extends OActiveRecord
{
	public $gridForbiddenColumn = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewZoneDistrict the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		preg_match("/dbname=([^;]+)/i", $this->dbConnection->connectionString, $matches);
		return $matches[1].'._view_core_zone_district';
	}

	/**
	 * @return string the primarykey column
	 */
	public function primaryKey()
	{
		return 'district_id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('district_name', 'required'),
			array('province_id, country_id', 'numerical', 'integerOnly'=>true),
			array('district_id, city_id', 'length', 'max'=>11),
			array('district_name, city_name, province_name, country_name', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('district_id, district_name, city_id, city_name, province_id, province_name, country_id, country_name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'district_id' => Yii::t('attribute', 'District'),
			'district_name' => Yii::t('attribute', 'District'),
			'city_id' => Yii::t('attribute', 'City'),
			'city_name' => Yii::t('attribute', 'City'),
			'province_id' => Yii::t('attribute', 'Province'),
			'province_name' => Yii::t('attribute', 'Province'),
			'country_id' => Yii::t('attribute', 'Country'),
			'country_name' => Yii::t('attribute', 'Country'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.district_id', $this->district_id);
		$criteria->compare('t.district_name', strtolower($this->district_name), true);
		$criteria->compare('t.city_id', $this->city_id);
		$criteria->compare('t.city_name', strtolower($this->city_name), true);
		$criteria->compare('t.province_id', $this->province_id);
		$criteria->compare('t.province_name', strtolower($this->province_name), true);
		$criteria->compare('t.country_id', $this->country_id);
		$criteria->compare('t.country_name', strtolower($this->country_name), true);

		if(!Yii::app()->getRequest()->getParam('ViewZoneDistrict_sort'))
			$criteria->order = 't.district_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['grid-view'] ? Yii::app()->params['grid-view']['pageSize'] : 20,
			),
		));
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->templateColumns) == 0) {
			$this->templateColumns['_option'] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			$this->templateColumns['_no'] = array(
				'header' => Yii::t('app', 'No'),
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
				'htmlOptions' => array(
					'class' => 'center',
				),
			);
			$this->templateColumns['district_id'] = array(
				'name' => 'district_id',
				'value' => '$data->district_id',
			);
			$this->templateColumns['district_name'] = array(
				'name' => 'district_name',
				'value' => '$data->district_name',
			);
			$this->templateColumns['city_id'] = array(
				'name' => 'city_id',
				'value' => '$data->city_id',
			);
			$this->templateColumns['city_name'] = array(
				'name' => 'city_name',
				'value' => '$data->city_name',
			);
			$this->templateColumns['province_id'] = array(
				'name' => 'province_id',
				'value' => '$data->province_id',
			);
			$this->templateColumns['province_name'] = array(
				'name' => 'province_name',
				'value' => '$data->province_name',
			);
			$this->templateColumns['country_id'] = array(
				'name' => 'country_id',
				'value' => '$data->country_id',
			);
			$this->templateColumns['country_name'] = array(
				'name' => 'country_name',
				'value' => '$data->country_name',
			);
		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::model()->findByPk($id,array(
				'select' => $column
			));
			return $model->$column;
			
		} else {
			$model = self::model()->findByPk($id);
			return $model;
		}
	}

}