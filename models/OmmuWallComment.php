<?php
/**
 * OmmuWallComment
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2015 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 *
 * --------------------------------------------------------------------------------------
 *
 * This is the model class for table "ommu_core_wall_comment".
 *
 * The followings are the available columns in table 'ommu_core_wall_comment':
 * @property string $comment_id
 * @property integer $publish
 * @property integer $parent_id
 * @property string $wall_id
 * @property string $user_id
 * @property string $comment
 * @property string $creation_date
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property Walls $wall
 * @property WallCommentLike[] WallCommentLikes
 */
class OmmuWallComment extends CActiveRecord
{
	use GridViewTrait;

	public $defaultColumns = array();
	
	// Variable Search
	public $wall_search;
	public $user_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OmmuWallComment the static model class
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
		return $matches[1].'.ommu_core_wall_comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wall_id, user_id, comment', 'required'),
			array('publish, parent_id', 'numerical', 'integerOnly'=>true),
			array('wall_id, user_id', 'length', 'max'=>11),
			array('modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('comment_id, publish, parent_id, wall_id, user_id, comment, creation_date, modified_date,
				wall_search, user_search', 'safe', 'on'=>'search'),
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
			'wall' => array(self::BELONGS_TO, 'OmmuWalls', 'wall_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'OmmuWallLikes' => array(self::HAS_MANY, 'OmmuWallLikes', 'comment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'comment_id' => Yii::t('attribute', 'Comment'),
			'publish' => Yii::t('attribute', 'Publish'),
			'parent_id' => Yii::t('attribute', 'Parent'),
			'wall_id' => Yii::t('attribute', 'Wall'),
			'user_id' => Yii::t('attribute', 'User'),
			'comment' => Yii::t('attribute', 'Comment'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'wall_search' => Yii::t('attribute', 'Wall'),
			'user_search' => Yii::t('attribute', 'User'),
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
			'wall' => array(
				'alias' => 'wall',
				'select' => 'wall_status'
			),
			'user' => array(
				'alias' => 'user',
				'select' => 'displayname'
			),
		);

		$criteria->compare('t.comment_id', $this->comment_id);
		if(Yii::app()->getRequest()->getParam('type') == 'publish')
			$criteria->compare('t.publish', 1);
		elseif(Yii::app()->getRequest()->getParam('type') == 'unpublish')
			$criteria->compare('t.publish', 0);
		elseif(Yii::app()->getRequest()->getParam('type') == 'trash')
			$criteria->compare('t.publish', 2);
		else {
			$criteria->addInCondition('t.publish', array(0,1));
			$criteria->compare('t.publish', $this->publish);
		}
		$criteria->compare('t.parent_id', $this->parent_id);
		if(Yii::app()->getRequest()->getParam('wall'))
			$criteria->compare('t.wall_id', Yii::app()->getRequest()->getParam('wall'));
		else
			$criteria->compare('t.wall_id', $this->wall_id);
		if(Yii::app()->getRequest()->getParam('user'))
			$criteria->compare('t.user_id',Yii::app()->getRequest()->getParam('user'));
		else
			$criteria->compare('t.user_id', $this->user_id);
		$criteria->compare('t.comment', $this->comment);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.creation_date)', date('Y-m-d', strtotime($this->creation_date)));
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.modified_date)', date('Y-m-d', strtotime($this->modified_date)));
		
		$criteria->compare('wall.wall_status', strtolower($this->wall_search), true);
		$criteria->compare('user.displayname', strtolower($this->user_search), true);

		if(!Yii::app()->getRequest()->getParam('OmmuWallComment_sort'))
			$criteria->order = 't.comment_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>30,
			),
		));
	}


	/**
	 * Get column for CGrid View
	 */
	public function getGridColumn($columns=null) {
		if($columns !== null) {
			foreach($columns as $val) {
				/*
				if(trim($val) == 'enabled') {
					$this->defaultColumns[] = array(
						'name'  => 'enabled',
						'value' => '$data->enabled == 1? "Ya": "Tidak"',
					);
				}
				*/
				$this->defaultColumns[] = $val;
			}
		} else {
			//$this->defaultColumns[] = 'comment_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'parent_id';
			$this->defaultColumns[] = 'wall_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'comment';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'modified_date';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			/*
			$this->defaultColumns[] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			*/
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = 'parent_id';
			if(!Yii::app()->getRequest()->getParam('wall')) {
				$this->defaultColumns[] = array(
					'name' => 'wall_search',
					'value' => '$data->wall->wall_status',
				);
			}
			if(!Yii::app()->getRequest()->getParam('user')) {
				$this->defaultColumns[] = array(
					'name' => 'user_search',
					'value' => '$data->user->displayname',
				);
			}
			$this->defaultColumns[] = 'comment';
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Yii::app()->dateFormatter->formatDateTime($data->creation_date, \'medium\', false)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterDatepicker($this, 'creation_date'),
			);
			if(!Yii::app()->getRequest()->getParam('type')) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'publish\', array(\'id\'=>$data->comment_id)), $data->publish, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter' => $this->filterYesNo(),
					'type' => 'raw',
				);
			}
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
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {		
			if($this->isNewRecord) {
				$this->user_id = Yii::app()->user->id;
			}
		}
		return true;
	}

}