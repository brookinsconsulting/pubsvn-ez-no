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
// $Id: Filter.php,v 1.3 2004/01/01 10:31:48 sebastian Exp $
//

/**
 * Utility class for code filtering.
 *
 * @package phpunit.framework
 * @author  Sebastian Bergmann <sb@sebastian-bergmann.de>
 */
class PHPUnit_Util_Filter {
    // {{{ Members

    /**
    * Source files that are to be filtered.
    *
    * @var    array
    * @access protected
    */
    protected static $filteredFiles = array(
      'PHPUnit/Extensions/ExceptionTestCase.php',
      'PHPUnit/Extensions/PerformanceTestCase.php',
      'PHPUnit/Extensions/RepeatedTest.php',
      'PHPUnit/Extensions/TestDecorator.php',
      'PHPUnit/Extensions/TestSetup.php',
      'PHPUnit/Extensions/Logger/Log.php',
      'PHPUnit/Extensions/Logger/XML.php',
      'PHPUnit/Framework/Assert.php',
      'PHPUnit/Framework/AssertionFailedError.php',
      'PHPUnit/Framework/ComparisonFailure.php',
      'PHPUnit/Framework/Test.php',
      'PHPUnit/Framework/TestCase.php',
      'PHPUnit/Framework/TestFailure.php',
      'PHPUnit/Framework/TestListener.php',
      'PHPUnit/Framework/TestResult.php',
      'PHPUnit/Framework/TestSuite.php',
      'PHPUnit/Framework/Version.php',
      'PHPUnit/Framework/Warning.php',
      'PHPUnit/Runner/BaseTestRunner.php',
      'PHPUnit/Runner/IncludePathTestCollector.php',
      'PHPUnit/Runner/SimpleTestCollector.php',
      'PHPUnit/Runner/StandardTestSuiteLoader.php',
      'PHPUnit/Runner/TestCollector.php',
      'PHPUnit/Runner/TestRunListener.php',
      'PHPUnit/Runner/TestSuiteLoader.php',
      'PHPUnit/TextUI/ResultPrinter.php',
      'PHPUnit/TextUI/TestRunner.php',
      'PHPUnit/Util/Filter.php'
    );

    // }}}
    // {{{ public static function getFilteredCodeCoverage($codeCoverageInformation)

    /**
    * Filters source lines from PHPUnit classes.
    *
    * @param  array
    * @return array
    * @access public
    * @static
    */
    public static function getFilteredCodeCoverage($codeCoverageInformation) {
        $files = array_keys($codeCoverageInformation);

        foreach ($files as $file) {
            if (in_array(self::getCanonicalFilename($file), self::$filteredFiles)) {
                unset($codeCoverageInformation[$file]);
            }
        }

        return $codeCoverageInformation;
    }

    // }}}
    // {{{ public static function getFilteredStacktrace(Exception $e)

    /**
    * Filters stack frames from PHPUnit classes.
    *
    * @param  Exception $e
    * @return string
    * @access public
    * @static
    */
    public static function getFilteredStacktrace(Exception $e) {
        $filteredStacktrace = '';
        $stacktrace         = $e->getTrace();

        foreach ($stacktrace as $frame) {
            $filtered = false;

            if (isset($frame['file']) &&
                !in_array(self::getCanonicalFilename($frame['file']), self::$filteredFiles)) {
                $filteredStacktrace .= sprintf(
                  "%s:%s\n",

                  $frame['file'],
                  isset($frame['line']) ? $frame['line'] : '?'
                );
            }
        }

        return $filteredStacktrace;
    }

    // }}}
    // {{{ protected static function getCanonicalFilename($filename)

    /**
    * Canonicalizes a source file name.
    *
    * @param  string
    * @return string
    * @access public
    * @static
    */
    protected static function getCanonicalFilename($filename) {
        return str_replace(
          '\\',
          '/',
          substr($filename, strpos($filename, 'PHPUnit'))
        );
    }

    // }}}
}

/*
 * vim600:  et sw=2 ts=2 fdm=marker
 * vim<600: et sw=2 ts=2
 */
?>
