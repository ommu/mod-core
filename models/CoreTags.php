<?php
/**
 * CoreTags
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 00:14 WIB
 * @modified date 22 April 2018, 18:36 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_tags".
 *
 * The followings are the available columns in table "ommu_core_tags":
 * @property integer $tag_id
 * @property integer $publish
 * @property string $body
 * @property string $creation_date
 * @property integer $creation_id
 * @property string $modified_date
 * @property integer $modified_id
 * @property string $updated_date
 *
 * The followings are the available model relations:
 * @property Users $creation
 * @property Users $modified
 *
 */

namespace ommu\core\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use ommu\users\models\Users;
use ommu\core\models\query\CoreTagsQuery;

class CoreTags extends \app\components\ActiveRecord
{
    use \ommu\traits\UtilityTrait;

    public $gridForbiddenColumn = ['modified_date','modified_search','updated_date'];

    // Search Variable
    public $creation_search;
    public $modified_search;
    // Biar tidak terkena beforeValidate
    public $is_api;

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'ommu_core_tags';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['body'], 'required'],
            [['publish', 'creation_id', 'modified_id', 'is_api'], 'integer'],
            [['creation_date', 'modified_date', 'updated_date', 'creation_id', 'is_api'], 'safe'],
            [['body'], 'string', 'max' => 64],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => Yii::t('app', 'Tag'),
            'publish' => Yii::t('app', 'Publish'),
            'body' => Yii::t('app', 'Body'),
            'creation_date' => Yii::t('app', 'Creation Date'),
            'creation_id' => Yii::t('app', 'Creation'),
            'modified_date' => Yii::t('app', 'Modified Date'),
            'modified_id' => Yii::t('app', 'Modified'),
            'updated_date' => Yii::t('app', 'Updated Date'),
            'creation_search' => Yii::t('app', 'Creation'),
            'modified_search' => Yii::t('app', 'Modified'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreation()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'creation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModified()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'modified_id']);
    }

    /**
     * @inheritdoc
     * @return CoreTagsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CoreTagsQuery(get_called_class());
    }

    /**
     * Set default columns to display
     */
    public function init() 
    {
        parent::init();

        $this->templateColumns['_no'] = [
            'header' => Yii::t('app', 'No'),
            'class'  => 'yii\grid\SerialColumn',
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['body'] = [
            'attribute' => 'body',
            'value' => function($model, $key, $index, $column) {
                return $model->body;
            },
        ];
        $this->templateColumns['creation_date'] = [
            'attribute' => 'creation_date',
            'filter' => Html::input('date', 'creation_date', Yii::$app->request->get('creation_date'), ['class'=>'form-control']),
            'value' => function($model, $key, $index, $column) {
                return !in_array($model->creation_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->creation_date, 'datetime') : '-';
            },
            'format' => 'html',
        ];
        if(!Yii::$app->request->get('creation')) {
            $this->templateColumns['creation_search'] = [
                'attribute' => 'creation_search',
                'value' => function($model, $key, $index, $column) {
                    return isset($model->creation) ? $model->creation->displayname : '-';
                },
            ];
        }
        $this->templateColumns['modified_date'] = [
            'attribute' => 'modified_date',
            'filter' => Html::input('date', 'modified_date', Yii::$app->request->get('modified_date'), ['class'=>'form-control']),
            'value' => function($model, $key, $index, $column) {
                return !in_array($model->modified_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->modified_date, 'datetime') : '-';
            },
            'format' => 'html',
        ];
        if(!Yii::$app->request->get('modified')) {
            $this->templateColumns['modified_search'] = [
                'attribute' => 'modified_search',
                'value' => function($model, $key, $index, $column) {
                    return isset($model->modified) ? $model->modified->displayname : '-';
                },
            ];
        }
        $this->templateColumns['updated_date'] = [
            'attribute' => 'updated_date',
            'filter' => Html::input('date', 'updated_date', Yii::$app->request->get('updated_date'), ['class'=>'form-control']),
            'value' => function($model, $key, $index, $column) {
                return !in_array($model->updated_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->updated_date, 'datetime') : '-';
            },
            'format' => 'html',
        ];
        if(!Yii::$app->request->get('trash')) {
            $this->templateColumns['publish'] = [
                'attribute' => 'publish',
                'filter' => $this->filterYesNo(),
                'value' => function($model, $key, $index, $column) {
                    $url = Url::to(['publish', 'id'=>$model->primaryKey]);
                    return $this->quickAction($url, $model->publish);
                },
                'contentOptions' => ['class'=>'center'],
                'format' => 'raw',
            ];
        }
    }

    /**
     * User get information
     */
    public static function getInfo($id, $column=null)
    {
        if($column != null) {
            $model = self::find()
                ->select([$column])
                ->where(['tag_id' => $id])
                ->one();
            return $model->$column;
            
        } else {
            $model = self::findOne($id);
            return $model;
        }
    }

    /**
     * function getTags
     */
    public static function getTag($publish=null, $array=true) 
    {
        $model = self::find()->alias('t');
        if($publish != null)
            $model = $model->andWhere(['t.publish' => $publish]);

        $model = $model->orderBy('t.body ASC')->all();

        if($array == true) {
            $items = [];
            if($model !== null) {
                foreach($model as $val) {
                    $items[$val->tag_id] = $val->body;
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
    public function beforeValidate() 
    {
        if(parent::beforeValidate()) {
           /* if($this->is_api == 0 || $this->is_api == null) {
                if($this->isNewRecord)
                    $this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
                else
                    $this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
            }*/
            if($this->isNewRecord) {
				if($this->creation_id == null)
					$this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			} else
				$this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
        }
        return true;
    }

    /**
     * before save attributes
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            if($insert)
                $this->body =  $this->urlTitle($this->body);
        }
        return true;
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['is_api']);   
    }
}
