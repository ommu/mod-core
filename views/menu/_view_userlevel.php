<?php
/**
 * Ommu Menus (ommu-menu)
 * @var $this MenuController
 * @var $model OmmuMenus
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 24 March 2016, 10:20 WIB
 * @link https://github.com/ommu/mod-core
 *
 */
?>

<?php 
if(!empty($userlevel_access)) {
	$count = count($userlevel_access);
	$i=0;
	foreach($userlevel_access as $val) {
		$i++;
		if($count != $i) {?>
			<?php echo $val;?>, 
		<?php } else {?>
			<?php echo $val;?>
	<?php }
	}
} else 
	echo '-';?>