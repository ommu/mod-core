<?php
/**
 * TagController
 * @var $this app\components\View
 *
 * Reference start
 * TOC :
 *  Index
 *  SlugToCamelize
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2021 OMMU (www.ommu.id)
 * @created date 1 July 2021, 15:06 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\controllers\sync;

use Yii;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use ommu\core\models\CoreTags;
use yii\helpers\Inflector;

class TagController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function allowAction(): array {
		return [];
	}

	/**
	 * Index Action
	 */
	public function actionIndex()
	{
		$this->view->title = Yii::t('app', 'Indices');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('index');
	}

	/**
	 * SlugToCamelize Action
	 */
	public function actionSlugToCamelize()
	{
		$model = CoreTags::find()
            ->alias('t')
            ->select(['tag_id', 'body'])
            ->all();
        
        if ($model != null) {
            foreach ($model as $val) {
                $val->body = Inflector::camelize($val->body);
                $val->update();
            }
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'Tag slug to camelize success sync.', array('module-id' => ucfirst($model->module_id))));
        return $this->redirect(['index']);
	}

}
