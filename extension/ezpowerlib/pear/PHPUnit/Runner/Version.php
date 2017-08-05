<?php
//
// +------------------------------------------------------------------------+
// | PEAR :: PHPUnit                                                        |
// +------------------------------------------------------------------------+
// | Copyright (c) 2002-2004 Sebastian Bergmann <sb@sebastian-bergmann.de>. |
// +------------------------------------------------------------------------+
// | This source file is subject to version 3.00 of the PHP License,        |
// | that is available at http://www.php.net/license/3_0.txt.               |
// | If you did not receive a copy of the PHP license and are unable to     |
// | obtain it through the world-wide-web, please send a note to            |
// | license@php.net so we can mail you a copy immediately.                 |
// +------------------------------------------------------------------------+
//
// $Id: Version.php,v 1.4 2004/01/18 09:26:42 sebastian Exp $
//

/**
 * This class defines the current version of PHPUnit.
 *
 * @package phpunit.runner
 * @author  Sebastian Bergmann <sb@sebastian-bergmann.de>
 */
class PHPUnit_Runner_Version {
    // {{{ public static function id()

    /**
    * Returns the current version of PHPUnit.
    *
    * @return string
    * @access public
    * @static
    */
  	public static function id() {
    		return 'PHPUnit-1.0.0alpha3';
  	}

    // }}}
    // {{{ public function getVersionString()

    public static function getVersionString() {
        return "PHPUnit 1.0.0alpha3 by Sebastian Bergmann.";
    }

    // }}}
}

/*
 * vim600:  et sw=2 ts=2 fdm=marker
 * vim<600: et sw=2 ts=2
 */
?>
