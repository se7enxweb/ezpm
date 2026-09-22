<?php


if ( !class_exists( 'eZPmFunctionCollection', false ) ) {
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
}

?>