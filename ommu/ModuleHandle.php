<?php
/**
 * ModuleHandle class file
 * Contains many function that most used
 *
 * Reference start
 * TOC :
 *	getIgnoreModule
 *	getModulesFromDb
 *	getModulesFromDir
 *	cacheModuleConfig
 *	getModuleConfig
 *	getModuleClassName
 *	deleteModuleDatabase
 *	deleteModuleDb
 *	deleteModuleFolder
 *	deleteModule
 *	setModules
 *	updateModuleAddon
 *	generateModuleDirectory
 *	generateModules
 
 *	updateModuleAddonFromDir
 *	getIdMax
 *	installModule
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @create date November 27, 2013 15:02 WIB
 * @copyright Copyright (c) 2013 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 *----------------------------------------------------------------------------------------------------------
 */

class ModuleHandle extends CApplicationComponent
{
	public $modulePath			= 'protected/modules';
	public $moduleVendorPath	= 'protected/vendor/ommu';
	public $configPath			= 'protected/config/module_addon.php';
	private $_moduleTableName	= 'ommu_core_plugins';
	
	/**
	 * return ignore module from scanner.
	 */
	public function getIgnoreModule()
	{
		return array();
	}
	
	/*
	 Dapatkan total modul yang ada pada tabel modul.
	 @return integer rows.
	*/
	public function getModulesFromDb($actived=null)
	{
		$criteria = new CDbCriteria;
		if($actived == null) {
			$criteria->condition = 'folder <> :folder';
			$criteria->params = array(
				':folder'=>'-',
			);		
		} else if($actived == 'enabled') {
			$criteria->condition = 'actived <> :actived AND folder <> :folder';
			$criteria->params = array(
				':actived'=>0,
				':folder'=>'-',
			);
		} else {
			$criteria->condition = 'actived = :actived AND folder <> :folder';
			$criteria->params = array(
				':actived'=>$actived,
				':folder'=>'-',
			);
		}
		$criteria->compare('parent_id', 0);
		$criteria->order = 'folder ASC';
		$modules = OmmuPlugins::model()->findAll($criteria);
		
		return $modules;
	}

	/**
	 * Mendapatkan daftar modul dari folder protected/modules.
	 *
	 * @return array daftar modul yang ada atau false jika tidak terdapat modul.
	 */
	public function getModulesFromDir()
	{
		$moduleList = array();
		$moduleVendorPath = Yii::getPathOfAlias('application.vendor.ommu');
		if (file_exists($moduleVendorPath)) {
			$modules = scandir($moduleVendorPath);
			foreach($modules as $module) {
				$moduleFile = $moduleVendorPath.'/'.$module.'/'.ucfirst($module).'Module.php';
				if (file_exists($moduleFile)) {
					$moduleName = strtolower(trim($module));
					if(!in_array($moduleName, $this->getIgnoreModule())) {
						$moduleList[] = $moduleName;
					}
				}
			}
		}
		
		$modulePath = Yii::getPathOfAlias('application.modules');
		if (file_exists($modulePath)) {
			$modules = scandir($modulePath);
			foreach($modules as $module) {
				$moduleFile = $modulePath.'/'.$module.'/'.ucfirst($module).'Module.php';
				if (file_exists($moduleFile)) {
					$moduleName = strtolower(trim($module));
					if(!in_array($moduleName, $moduleList)) {
						if(!in_array($moduleName, $this->getIgnoreModule())) {
							$moduleList[] = $moduleName;
						}
					}
				}
			}
		}

		if(count($moduleList) > 0)
			return $moduleList;
		else
			return false;
	}
	
	/**
	 * Cache modul dari database ke bentuk file.
	 * Untuk mengurangi query pada saat install ke database.
	 */
	public function cacheModuleConfig($return=false)
	{
		$modules = $this->getModulesFromDb();
		$arrayModule = array();

		foreach($modules as $module) {
			if(!in_array($module->folder, $arrayModule))
				$arrayModule[] = $module->folder;
		}
		if($return == false) {
			$filePath   = Yii::getPathOfAlias('application.config');
			$fileHandle = fopen($filePath.'/cache_module.php', 'w');
			fwrite($fileHandle, implode("\n", $arrayModule));
			fclose($fileHandle);

		} else 
			return $arrayModule;
	}

	/**
	 * Get module config from yaml file
	 *
	 * @param string $module
	 * @return array
	 */
	public function getModuleConfig($module)
	{
		Yii::import('mustangostang.spyc.Spyc');
		define('DS', DIRECTORY_SEPARATOR);
		
		$configPath = Yii::getPathOfAlias('application.vendor.ommu.'.$module).DS.$module.'.yaml';

		if(file_exists($configPath))
			return Spyc::YAMLLoad($configPath);
		else
			return null;
	}

	/**
	 * get module classname
	 */
	public function getModuleClassName($module) 
	{
		return ucfirst($module).'Module';
	}
	
	/**
	 * Delete Module Database 
	 */
	public function deleteModuleDatabase($module)
	{
		$config = $this->getModuleConfig($module);
		$tableName = $config['db_table_name'];

		if($config && $tableName) {
			foreach($tableName as $val){
				Yii::app()->db->createCommand("DROP TABLE {$val}")->execute();
			}

		} else
			return false;
	}
	
	/**
	 * Delete Module from Plugin Database
	 */
	public function deleteModuleDb($module)
	{
		if($module != null) {
			$model = OmmuPlugins::model()->findByAttributes(array('folder'=>$module));
			
			if($model != null)
				$model->delete();

			else 
				return true;

		} else 
			return true;
	}

	/**
	 * Delete Module Directory
	 */
	public function deleteModuleFolder($modulePath)
	{
		// Sanity check
		if (file_exists($modulePath)) {
			Utility::deleteFolder($modulePath);
			//Utility::recursiveDelete($modulePath);
			//echo $modulePath;
			//exit();

		} else 
			return false;
	}

	/**
	 * Delete modules
	 */
	public function deleteModule($module=null, $db=false)
	{
		if($module != null) {
			$module = trim($module);

			//Delete theme database
			if($db == true)
				$this->deleteModuleDb($module);

			$this->deleteModuleDatabase($module);
			
			//Delete vendor source
			$vendorPath = Yii::getPathOfAlias('application.vendor.ommu.'.$module);
			$this->deleteModuleFolder($vendorPath);
			//Delete module source
			$modulePath = Yii::getPathOfAlias('application.modules.'.$module);
			$this->deleteModuleFolder($modulePath);
			//Delete public source
			$publicPath = Yii::getPathOfAlias('webroot.public.'.$module);
			$this->deleteModuleFolder($publicPath);
		
		} else
			return false;
	}
	
	/**
	 * Install modul ke database
	 */
	public function setModules()
	{
		$moduleVendorPath	= Yii::getPathOfAlias('application.vendor.ommu');
		$installedModule	= $this->getModulesFromDir();
		$cacheModule		= file(Yii::getPathOfAlias('application.config').'/cache_module.php');
		$toBeInstalled		= array();
		
		$caches = array();
		foreach($cacheModule as $val) {
			$caches[] = trim($val);
		}

		if(!$installedModule)
			$installedModule = array();
		
		foreach($caches as $cache) {
			if(!in_array($cache, array_map("trim", $installedModule)))
				$this->deleteModuleDb($cache);
		}

		$moduleDb = $this->cacheModuleConfig(true);
		foreach($installedModule as $module) {
			$module = trim($module);
			if(!in_array($module, array_map("trim", $moduleDb))) {
				$config = $this->getModuleConfig($module);
				$moduleFile = join('/', array($moduleVendorPath, $module, ucfirst($module).'Module.php'));

				if($config && file_exists($moduleFile) && $module == $config['folder_name']) {
					$model=new OmmuPlugins;
					$model->folder = $module;
					$model->name = $config['name'];
					$model->desc = $config['description'];
					if($config['model'])
						$model->model = $config['model'];
					$model->save();
				}
			}
		}
		
		$this->generateModules();
	}

	/**
	 * Update module from db to file
	 */
	public function updateModuleAddon()
	{
		$modules = $this->getModulesFromDb('enabled');
		$countModules = count($modules);

		$config  = "<?php \n";
		if($countModules > 0) {
			$config .= "return array(\n\t'modules' => array(\n";
			$i = 1;
			foreach($modules as $val) {
				$module =  $val['folder'];
				/*
				$moduleClass =  $this->getModuleClassName($module);
				$config .= "\t\t'$module'=>array(\n";
				$config .= "\t\t\t'class'=>'\ommu\\$module\\$moduleClass',\n";
				if($i !== $countModules)
					$config .= "\t\t),\n";
				else
					$config .= "\t\t)\n";
				*/
				if($i !== $countModules)
					$config .= "\t\t'$module',\n";
				else
					$config .= "\t\t'$module'\n";
				$i++;
			}

		} else {
			$config .= "return array(\n\t'modules' => array(\n";
		}
		$config .= "\t),\n);";

		$fileHandle = @fopen(Yii::getPathOfAlias('application.config').'/module_addon.php', 'w');
		@fwrite($fileHandle, $config, strlen($config));
		@fclose($fileHandle);
	}

	/**
	 * Update module from db to file
	 */
	public function generateModuleDirectory($path)
	{
		// Add directory
		if(!file_exists($path)) {
			@mkdir($path, 0755, true);

			// Add file in directory (index.php)
			$newFile = $path.'/index.php';
			$FileHandle = fopen($newFile, 'w');
		} else
			@chmod($path, 0755, true);
	}

	/**
	 * Update module from db to file
	 */
	public function generateModules()
	{
		$modules = $this->getModulesFromDir();
		$modulePath = Yii::getPathOfAlias('application.modules');
		$moduleComponent = array('assets','components','controllers','models','views');

		if(count($modules) > 0) {
			foreach($modules as $module) {
				$moduleClass = ucfirst($module).'Module';
				$module_path = $modulePath.'/'.$module;
				$module_class = $module_path.'/'.$moduleClass.'.php';

				if(!file_exists($module_class)) {
					$this->generateModuleDirectory($module_path);
	
					foreach($moduleComponent as $component) {
						$module_component_path = $module_path.'/'.$component;
						$this->generateModuleDirectory($module_component_path);
					}

					$config = "<?php\n";
					$config .= "/**\n";
					$config .= " * $moduleClass\n";
					$config .= " *\n";
					$config .= " * @author Putra Sudaryanto <putra@sudaryanto.id>\n";
					$config .= " * @contact (+62)856-299-4114\n";
					$config .= " * @copyright Copyright (c) ".date('Y')." Ommu Platform (www.ommu.co)\n";
					$config .= " * @created date ".date('j F Y, H:i')." WIB\n";
					$config .= " *\n";
					$config .= " *----------------------------------------------------------------------------------------------------------\n */\n\n";
					$config .= "Yii::import('application.vendor.ommu.$module.$moduleClass');";

					if(!file_exists($module_class)) {
						$fileHandle = @fopen($module_class, 'w');
						@fwrite($fileHandle, $config, strlen($config));
						@fclose($fileHandle);
					}
				}
			}
		}
	}

	/**
	 * Create additional table inside module(if any)
	 *
	 * @param string $moduleName
	 * @return void.
	 */
	public function installModule($plugin_id)
	{
		$moduleVendorPath = Yii::getPathOfAlias('application.vendor.ommu');
		$module = OmmuPlugins::model()->findByPk($plugin_id);

		if($module != null) {
			$moduleName = $module->folder;
			if($model->parent_id != 0)
				$moduleName = $module->parent->folder;
			
			if($model->install == 1) {
				$config = $this->getModuleConfig($moduleName);
				if($config) {
					$tableName = $config['db_table_name'];
					$fileName  = trim($config['db_sql_filename']);
					$sqlFile = $moduleVendorPath.'/'.$moduleName.'/data/'.$fileName;
	
					if($tableName && !empty($tableName) && $fileName != '' && file_exists($sqlFile)) {
						$tables  = Yii::app()->db->createCommand('SHOW FULL TABLES WHERE table_type = "BASE TABLE"')->queryColumn();
	
						if(!in_array($tableName[0], $tables)) {
							$sql = file_get_contents($sqlFile);
							Yii::app()->db->createCommand($sql)->execute();
						}
					}
				}

			} else
				$this->deleteModuleDatabase($moduleName);

		} else
			return false;
	}








	
	
	/**
	 * Install modul ke file protected/config/modules.php
	 */
	public function updateModuleAddonFromDir($module = array())
	{
		$config = '';
		$moduleCaches = $this->getModulesFromDir();
		if(count($module) > 0 && is_array($module)) {
			$moduleCaches = $module;
		}

		if(count($moduleCaches) > 0) {
			$config .= "<?php \n";
			$config .= "return array(\n\t'modules' => array(\n";
			for($i = 0; $i < count($moduleCaches); $i++) {
				if($i !== (count($moduleCaches) - 1))
					$config .= "\t\t'" . $moduleCaches[$i] . "',\n";
				else
					$config .= "\t\t'" . $moduleCaches[$i] . "'\n";
			}
			$config .= "\t),\n);";
			$config .= "\n?>";
		}

		$fileHandle = fopen($this->configPath, 'w');
		fwrite($fileHandle, $config, strlen($config));
		fclose($fileHandle);
	}

	/**/
	public function getIdMax($fieldName, $tableName)
	{
		$conn = Yii::app()->db;
		$sql  = 'SELECT IFNULL(MAX(' . $fieldName . ')+1, 1) as id FROM ' . $tableName;
		return $conn->createCommand($sql)->queryScalar();
	}
	
}
