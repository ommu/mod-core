<?php
/**
 * m210701_154601_core_module_insert_role
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2021 OMMU (www.ommu.id)
 * @created date 1 July 2021, 15:46 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use Yii;

class m210701_154601_core_module_insert_role extends \yii\db\Migration
{
	public function up()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_core_auth_item';
		if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert('ommu_core_auth_item', ['name', 'type', 'data', 'created_at'], [
				['/admin/sync/tag/index', '2', '', time()],
				['/admin/sync/tag/slug-to-camelize', '2', '', time()],
			]);
		}

		$tableName = Yii::$app->db->tablePrefix . 'ommu_core_auth_item_child';
		if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert('ommu_core_auth_item_child', ['parent', 'child'], [
				['userModerator', '/admin/sync/tag/index'],
				['userModerator', '/admin/sync/tag/slug-to-camelize'],
			]);
		}
	}
}
