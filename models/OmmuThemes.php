<?php
/**
 * OmmuThemes
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @modified date 20 January 2018, 06:31 WIB
 * @link https://github.com/ommu/ommu-core
 *
 * This is the model class for table "ommu_core_themes".
 *
 * The followings are the available columns in table 'ommu_core_themes':
 * @property integer $theme_id
 * @property string $group_page
 * @property integer $default_theme
 * @property string $folder
 * @property string $layout
 * @property string $name
 * @property string $thumbnail
 * @property string $config
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 */

class OmmuThemes extends OActiveRecord
{
	public $gridForbiddenColumn = array('thumbnail','config','modified_date','modified_search');

	// Variable Search
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OmmuThemes the static model class
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
		return $matches[1].'.ommu_core_themes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_page, folder, layout, name', 'required'),
			array('default_theme', 'numerical', 'integerOnly'=>true),
			array('group_page, creation_id, modified_id', 'length', 'max'=>11),
			array('folder, layout, thumbnail', 'length', 'max'=>32),
			array('name', 'length', 'max'=>64),
			array('thumbnail, config', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('theme_id, group_page, default_theme, folder, layout, name, thumbnail, config, creation_date, creation_id, modified_date, modified_id,
				creation_search, modified_search', 'safe', 'on'=>'search'),
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
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'theme_id' => Yii::t('attribute', 'Theme'),
			'group_page' => Yii::t('attribute', 'Group Page'),
			'default_theme' => Yii::t('attribute', 'Default Theme'),
			'folder' => Yii::t('attribute', 'Folder'),
			'layout' => Yii::t('attribute', 'Layout'),
			'name' => Yii::t('attribute', 'Theme'),
			'thumbnail' => Yii::t('attribute', 'Thumbnail'),
			'config' => Yii::t('attribute', 'Configuration'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
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
			'creation' => array(
				'alias'=>'creation',
				'select'=>'displayname',
			),
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname',
			),
		);

		$criteria->compare('t.theme_id', $this->theme_id);
		$criteria->compare('t.group_page', $this->group_page, true);
		$criteria->compare('t.default_theme', $this->default_theme);
		$criteria->compare('t.folder', strtolower($this->folder), true);
		$criteria->compare('t.layout', strtolower($this->layout), true);
		$criteria->compare('t.name', strtolower($this->name), true);
		$criteria->compare('t.thumbnail', $this->thumbnail, true);
		$criteria->compare('t.config', $this->config, true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '1970-01-01 00:00:00')))
			$criteria->compare('date(t.creation_date)', date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_id', Yii::app()->getRequest()->getParam('creation') ? Yii::app()->getRequest()->getParam('creation') : $this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '1970-01-01 00:00:00')))
			$criteria->compare('date(t.modified_date)', date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id', Yii::app()->getRequest()->getParam('modified') ? Yii::app()->getRequest()->getParam('modified') : $this->modified_id);

		$criteria->compare('creation.displayname', strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname', strtolower($this->modified_search), true);

		if(!Yii::app()->getRequest()->getParam('OmmuThemes_sort'))
			$criteria->order = 't.theme_id DESC';

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
			$this->templateColumns['group_page'] = array(
				'name' => 'group_page',
				'value' => '$data->group_page',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					'public' => Yii::t('phrase', 'Public'),
					'admin' => Yii::t('phrase', 'Administrator'),
					'maintenance' => Yii::t('phrase', 'Offline (Coming Soon & Maintenance)'),
				),
				'type' => 'raw',
			);
			$this->templateColumns['name'] = array(
				'name' => 'name',
				'value' => '$data->name',
			);
			$this->templateColumns['folder'] = array(
				'name' => 'folder',
				'value' => '$data->folder',
			);
			$this->templateColumns['layout'] = array(
				'name' => 'layout',
				'value' => '$data->layout',
			);
			$this->templateColumns['thumbnail'] = array(
				'name' => 'thumbnail',
				'value' => '$data->thumbnail',
			);
			$this->templateColumns['config'] = array(
				'name' => 'config',
				'value' => '$data->config',
			);
			if(!Yii::app()->getRequest()->getParam('creation')) {
				$this->templateColumns['creation_search'] = array(
					'name' => 'creation_search',
					'value' => '$data->creation->displayname ? $data->creation->displayname : \'-\'',
				);
			}
			$this->templateColumns['creation_date'] = array(
				'name' => 'creation_date',
				'value' => '!in_array($data->creation_date, array(\'0000-00-00 00:00:00\', \'1970-01-01 00:00:00\')) ? Utility::dateFormat($data->creation_date) : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.libraries.core.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'creation_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'creation_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			$this->templateColumns['modified_date'] = array(
				'name' => 'modified_date',
				'value' => '!in_array($data->modified_date, array(\'0000-00-00 00:00:00\', \'1970-01-01 00:00:00\')) ? Utility::dateFormat($data->modified_date) : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.libraries.core.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'modified_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'modified_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			if(!Yii::app()->getRequest()->getParam('modified')) {
				$this->templateColumns['modified_search'] = array(
					'name' => 'modified_search',
					'value' => '$data->modified->displayname ? $data->modified->displayname : \'-\'',
				);
			}
			$this->templateColumns['default_theme'] = array(
				'name' => 'default_theme',
				'value' => '$data->default_theme == 1 ? CHtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Utility::getPublish(Yii::app()->controller->createUrl(\'default\',array(\'id\'=>$data->theme_id)), $data->default_theme, \'Default,Default\')',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Yii::t('phrase', 'Yes'),
					0=>Yii::t('phrase', 'No'),
				),
				'type' => 'raw',
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

	/**
	 * getThemes
	 * 0 = unpublish
	 * 1 = publish
	 */
	public static function getThemes() 
	{
		$criteria=new CDbCriteria;
		$model = self::model()->findAll($criteria);

		if($type == null) {
			$items = array();
			if($model != null) {
				foreach($model as $key => $val) {
					$items[$val->theme_id] = $val->name;
				}
				return $items;
			} else
				return false;
		} else
			return $model;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() 
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->creation_id = !Yii::app()->user->isGuest ? Yii::app()->user->id : 0;
			else
				$this->modified_id = !Yii::app()->user->isGuest ? Yii::app()->user->id : 0;
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() 
	{
		if(parent::beforeSave()) {
			if(!$this->isNewRecord) {
				// set to default modules
				if($this->default_theme == 1) {
					self::model()->updateAll(array(
						'default_theme' => 0,
					), array(
						'condition'=> 'theme_id <> :theme AND group_page = :group',
						'params'=>array(
							':theme'=>$this->theme_id,
							':group'=>$this->group_page,
						),
					));
				}
			}
			
			if(!$this->isNewRecord)
				$this->config = serialize($this->config);
		}
		return true;
	}

}