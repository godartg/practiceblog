<?php 
	function setActiveRoute($name)
	{
		return request()->RouteIs($name) ? 'active' : '';
	}
?>