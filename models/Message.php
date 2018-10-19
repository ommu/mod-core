<?php
/**
 * Message
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 Ommu Platform (www.ommu.co)
 * @created date 5 November 2017, 18:28 WIB
 * @modified date 20 January 2018, 06:27 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "message".
 *
 * The followings are the available columns in table 'message':
 * @property integer $id
 * @property string $language
 * @property string $translation
 *
 * The followings are the available model relations:
 * @property SourceMessage $id0
 */
class Message extends OActiveRecord
{
	public $gridForbiddenColumn = array();

	// Variable Search
	public $phrase_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Message the static model class
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
		return $matches[1].'.message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, language, translation', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('language', 'length', 'max'=>16),
			array('', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, language, translation, 
				phrase_search', 'safe', 'on'=>'search'),
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
			'phrase' => array(self::BELONGS_TO, 'SourceMessage', 'id'),
			'language_r' => array(self::BELONGS_TO, 'OmmuLanguages', 'language'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('attribute', 'Phrase'),
			'language' => Yii::t('attribute', 'Language'),
			'translation' => Yii::t('attribute', 'Translation'),
			'phrase_search' => Yii::t('attribute', 'Phrase'),
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

		// Custom Search
		$criteria->with = array(
			'phrase' => array(
				'alias' => 'phrase',
				'select' => 'message',
			),
		);
		
		$criteria->compare('t.id', Yii::app()->getRequest()->getParam('phrase') ? Yii::app()->getRequest()->getParam('phrase') : $this->id);
		$criteria->compare('t.language', Yii::app()->getRequest()->getParam('language') ? Yii::app()->getRequest()->getParam('language') : $this->language);
		$criteria->compare('t.translation', strtolower($this->translation), true);

		$criteria->compare('phrase.message', strtolower($this->phrase_search), true);

		if(!Yii::app()->getRequest()->getParam('Message_sort'))
			$criteria->order = 't.id DESC';

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
			if(!Yii::app()->getRequest()->getParam('phrase')) {
				$this->templateColumns['phrase_search'] = array(
					'name' => 'phrase_search',
					'value' => '$data->phrase->message',
				);
			}
			if(!Yii::app()->getRequest()->getParam('language')) {
				$this->templateColumns['language'] = array(
					'name' => 'language',
					'value' => '$data->language_r->name',
					'filter' => OmmuLanguages::getLanguage(null, 'code'),
					'type' => 'raw',
				);
			}
			$this->templateColumns['translation'] = array(
				'name' => 'translation',
				'value' => '$data->translation',
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
}