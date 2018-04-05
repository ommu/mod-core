<?php
/**
 * OmmuPlugins
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @modified date 20 January 2018, 06:30 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_plugins".
 *
 * The followings are the available columns in table 'ommu_core_plugins':
 * @property integer $plugin_id
 * @property integer $default
 * @property integer $install
 * @property integer $actived
 * @property integer $search
 * @property integer $orders
 * @property integer $parent_id
 * @property string $folder
 * @property string $name
 * @property string $desc
 * @property string $model
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuPluginPhrase[] $phrases
 * @property Users $creation
 * @property Users $modified
 */

class OmmuPlugins extends OActiveRecord
{
	public $gridForbiddenColumn = array('desc','model','creation_date','creation_search','modified_date','modified_search');

	// Variable Search
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OmmuPlugins the static model class
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
		return $matches[1].'.ommu_core_plugins';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('folder', 'required'),
			array('name, desc', 'required', 'on'=>'adminadd'),
			array('default, install, actived, search, orders, parent_id', 'numerical', 'integerOnly'=>true),
			array('folder', 'length', 'max'=>32),
			array('name, model', 'length', 'max'=>128),
			array('desc', 'length', 'max'=>255),
			array('creation_id, modified_id', 'length', 'max'=>11),
			array('name, desc, model', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('plugin_id, default, install, actived, search, orders, parent_id, folder, name, desc, model, creation_date, creation_id, modified_date, modified_id,
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
			'parent' => array(self::BELONGS_TO, 'OmmuPlugins', 'parent_id'),
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
			'plugin_id' => Yii::t('attribute', 'Plugin'),
			'default' => Yii::t('attribute', 'Default'),
			'install' => Yii::t('attribute', 'Install'),
			'actived' => Yii::t('attribute', 'Actived'),
			'search' => Yii::t('attribute', 'Search'),
			'orders' => Yii::t('attribute', 'Order'),
			'parent_id' => Yii::t('attribute', 'Parent'),
			'folder' => Yii::t('attribute', 'Folder'),
			'name' => Yii::t('attribute', 'Module'),
			'desc' => Yii::t('attribute', 'Description'),
			'model' => Yii::t('attribute', 'Model'),
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

		$criteria->compare('t.plugin_id', $this->plugin_id);
		$criteria->compare('t.default', $this->default);
		$criteria->compare('t.install', Yii::app()->getRequest()->getParam('type') && Yii::app()->getRequest()->getParam('type') == 'all' ? $this->install : 1);
		$criteria->compare('t.actived', $this->actived);
		$criteria->compare('t.search', $this->search);
		$criteria->compare('t.orders', $this->orders);
		$criteria->compare('t.parent_id', $this->parent_id);
		$criteria->compare('t.folder', strtolower($this->folder), true);
		$criteria->compare('t.name', strtolower($this->name), true);
		$criteria->compare('t.desc', strtolower($this->desc), true);
		$criteria->compare('t.model', strtolower($this->model), true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '1970-01-01 00:00:00')))
			$criteria->compare('date(t.creation_date)', date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_id', Yii::app()->getRequest()->getParam('creation') ? Yii::app()->getRequest()->getParam('creation') : $this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '1970-01-01 00:00:00')))
			$criteria->compare('date(t.modified_date)', date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id', Yii::app()->getRequest()->getParam('modified') ? Yii::app()->getRequest()->getParam('modified') : $this->modified_id);

		$criteria->compare('creation.displayname', strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname', strtolower($this->modified_search), true);

		if(!Yii::app()->getRequest()->getParam('OmmuPlugins_sort'))
			$criteria->order = 't.plugin_id DESC';

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
			$this->templateColumns['name'] = array(
				'name' => 'name',
				'value' => '$data->name ? $data->name : \'-\'',
			);
			$this->templateColumns['desc'] = array(
				'name' => 'desc',
				'value' => '$data->desc ? $data->desc : \'-\'',
			);
			$this->templateColumns['folder'] = array(
				'name' => 'folder',
				'value' => '$data->folder',
			);
			$this->templateColumns['parent_id'] = array(
				'name' => 'parent_id',
				'value' => '$data->parent_id ? $data->parent->folder : \'-\'',
			);
			$this->templateColumns['orders'] = array(
				'name' => 'orders',
				'value' => '$data->orders',
				'htmlOptions' => array(
					'class' => 'center',
				),
			);
			$this->templateColumns['model'] = array(
				'name' => 'model',
				'value' => '$data->model',
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
				'filter' => 'native-datepicker',
				/*
				'filter' => Yii::app()->controller->widget('application.libraries.core.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'creation_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'creation_date_filter',
						'on_datepicker' => 'on',
						'placeholder' => Yii::t('phrase', 'filter'),
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
				*/
			);
			$this->templateColumns['modified_date'] = array(
				'name' => 'modified_date',
				'value' => '!in_array($data->modified_date, array(\'0000-00-00 00:00:00\', \'1970-01-01 00:00:00\')) ? Utility::dateFormat($data->modified_date) : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => 'native-datepicker',
				/*
				'filter' => Yii::app()->controller->widget('application.libraries.core.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'modified_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'modified_date_filter',
						'on_datepicker' => 'on',
						'placeholder' => Yii::t('phrase', 'filter'),
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
				*/
			);
			if(!Yii::app()->getRequest()->getParam('modified')) {
				$this->templateColumns['modified_search'] = array(
					'name' => 'modified_search',
					'value' => '$data->modified->displayname ? $data->modified->displayname : \'-\'',
				);
			}
			$this->templateColumns['install'] = array(
				'name' => 'install',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'install\',array(\'id\'=>$data->plugin_id)), $data->install, \'Install,Uninstall\')',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Yii::t('phrase', 'Yes'),
					0=>Yii::t('phrase', 'No'),
				),
				'type' => 'raw',
			);
			$this->templateColumns['actived'] = array(
				'name' => 'actived',
				'value' => '$data->install == 1 ? ($data->actived == 2 ? CHtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Utility::getPublish(Yii::app()->controller->createUrl(\'active\',array("id"=>$data->plugin_id)), $data->actived, \'Actived,Deactived\')) : "-"',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Yii::t('phrase', 'Yes'),
					0=>Yii::t('phrase', 'No'),
				),
				'type' => 'raw',
			);
			$this->templateColumns['search'] = array(
				'name' => 'search',
				'value' => '$data->search == 1 ? CHtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : CHtml::image(Yii::app()->theme->baseUrl.\'/images/icons/unpublish.png\')',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Yii::t('phrase', 'Yes'),
					0=>Yii::t('phrase', 'No'),
				),
				'type' => 'raw',
			);
			$this->templateColumns['default'] = array(
				'name' => 'default',
				'value' => '$data->install == 1 ? ($data->default == 1 ? CHtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Utility::getPublish(Yii::app()->controller->createUrl(\'default\',array("id"=>$data->plugin_id)), $data->default)) : "-"',
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
	 * getPlugin
	 * 0 = unpublish
	 * 1 = publish
	 */
	public static function getPlugin($actived=null, $keypath=null, $type=null)
	{
		$criteria=new CDbCriteria;
		if($actived != null)
			$criteria->compare('actived', $actived);
		$criteria->addNotInCondition('orders', array(0));
		if($actived == null || $actived == 0)
			$criteria->order = 'folder ASC';
		else
			$criteria->order = 'orders ASC';
		
		$model = self::model()->findAll($criteria);

		if($type == null) {
			$items = array();
			if($model != null) {
				foreach($model as $key => $val) {
					if($keypath == null || $keypath == 'folder')
						$items[$val->folder] = $val->name;
					else
						$items[$val->plugin_id] = $val->name;
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
			if($this->isNewRecord) {
				if($this->actived == 1)
					$this->orders = count(self::getPlugin(1, null, 'data')) + 1;
				else
					$this->orders = 0;
				
				$this->creation_id = !Yii::app()->user->isGuest ? Yii::app()->user->id : null;
			} else
				$this->modified_id = !Yii::app()->user->isGuest ? Yii::app()->user->id : null;
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
				if($this->actived == 0) {
					$conn = Yii::app()->db;
					$sql = "UPDATE ommu_core_plugins SET orders = (orders - 1) WHERE orders > {$this->orders}";
					$conn->createCommand($sql)->execute();
					$this->orders = 0;
				} else if($this->actived == 1)
					$this->orders = count(self::getPlugin(1, null, 'data')) + 1;

				// set to default modules
				if($this->default == 1) {
					self::model()->updateAll(array(
						'default' => 0,	
					));
					$this->default = 1;
				}
			}
		}
		return true;
	}

}