<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    /**
	  * Moduls For All Application
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	*/
    'components' => [
		'errorHandler' => [
            'maxSourceLines' => 20,
        ],
    ]
];
