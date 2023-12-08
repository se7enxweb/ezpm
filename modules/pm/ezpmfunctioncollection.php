<?php

class eZPmFunctionCollection
{
    /*!
     Constructor
    */
    function eZPmFunctionCollection()
    {
    }


	function messagesStats()
	{
		$pm = new eZPm();
		
		return $pm->messagesStats();
	}

}
?>