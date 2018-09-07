<?php 
	function setActiveAttribute($name)
	{
		return request()->RouteIs($name) ? 'active' : '';
	}
?>