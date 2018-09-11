<?php 
	function setActiveRoute($name)
	{
		return request()->RouteIs($name) ? 'active' : '';
	}
?>

<!-- Min 3:46 vid 059 -->