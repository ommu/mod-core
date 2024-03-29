<?php
/**
 * OmmuPluginPhrase
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @modified date 20 January 2018, 06:30 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_plugin_phrase".
 *
 * The followings are the available columns in table 'ommu_core_plugin_phrase':
 * @property string $phrase_id
 * @property integer $plugin_id
 * @property string $location
 * @property string $en_us
 * @property string $id
 *
 * The followings are the available model relations:
 * @property OmmuPlugins $plugin
 */

class OmmuPluginPhrase extends OActiveRecord
{
	public $gridForbiddenColumn = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OmmuPluginPhrase the static model class
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
		return $matches[1].'.ommu_core_plugin_phrase';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('en_us', 'required'),
			array('plugin_id', 'numerical', 'integerOnly'=>true),
			array('phrase_id', 'length', 'max'=>11),
			array('location', 'length', 'max'=>32),
			array('plugin_id, location, 
				id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('phrase_id, plugin_id, location, en_us, id', 'safe', 'on'=>'search'),
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
			'plugin' => array(self::BELONGS_TO, 'OmmuPlugins', 'plugin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'phrase_id' => Yii::t('attribute', 'Phrase'),
			'plugin_id' => Yii::t('attribute', 'Plugin'),
			'location' => Yii::t('attribute', 'Location'),
			'en_us' => Yii::t('attribute', 'En'),
			'id' => Yii::t('attribute', 'ID'),
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

		$criteria->compare('t.phrase_id', $this->phrase_id);
		$criteria->compare('t.plugin_id', Yii::app()->getRequest()->getParam('module') ? Yii::app()->getRequest()->getParam('module') : $this->plugin_id);
		$criteria->compare('t.location', strtolower($this->location), true);
		$criteria->compare('t.en_us', strtolower($this->en_us), true);
		$criteria->compare('t.id', strtolower($this->id), true);

		if(!Yii::app()->getRequest()->getParam('OmmuPluginPhrase_sort'))
			$criteria->order = 't.phrase_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['grid-view'] ? Yii::app()->params['grid-view']['pageSize'] : 50,
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
			$this->templateColumns['phrase_id'] = array(
				'header' => 'ID',
				'name' => 'phrase_id',
				'value' => '$data->phrase_id',
				'htmlOptions' => array(
					'class' => 'center',
				),
			);
			$this->templateColumns['plugin_id'] = array(
				'name' => 'plugin_id',
				'value' => '$data->plugin->name',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' =>OmmuPlugins::getPlugin(0, 'id'),
				'type' => 'raw',
			);
			$this->templateColumns['location'] = array(
				'name' => 'location',
				'value' => '$data->location',
			);
			$this->templateColumns['en_us'] = array(
				'name' => 'en_us',
				'value' => '$data->en_us',
			);
			$this->templateColumns['id'] = array(
				'name' => 'id',
				'value' => '$data->id',
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
			$model = self::model()->findByPk($id, array(
				'select' => $column,
			));
 			if(count(explode(',', $column)) == 1)
 				return $model->$column;
 			else
 				return $model;
			
		} else {
			$model = self::model()->findByPk($id);
			return $model;
		}
	}

	/**
	 * getOrder
	 */
	public static function getOrder($id)
	{
		$model = self::model()->count(array(
			'condition' => 'plugin_id = :plugin',
			'params' => array(':plugin'=>$id)
		));
		$order = $model;

		return $order;
	}

}