<?php
if(isset($_GET['method'])){
	switch ($_GET['method']){
	case 'pick':
		if(isset($_POST['for'])){
			$player = (int)$_GET['for'];
			if(CheckPlayer($player)){
				$res = GetAvailable();
				PickFor($player, $res);
			}
		} else {
			echo "Select player!";
		}
		break;	
	default:
		break;
	}

} else {
echo "No method specified!";
}
?>