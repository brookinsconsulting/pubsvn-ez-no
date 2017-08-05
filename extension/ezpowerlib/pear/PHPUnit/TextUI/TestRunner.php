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
// $Id: TestRunner.php,v 1.10 2004/01/18 08:36:38 sebastian Exp $
//

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'PHPUnit_TextUI_TestRunner::main');
}

require_once 'Console/Getopt.php';
require_once 'PHPUnit/Extensions/Logger/XML.php';
require_once 'PHPUnit/Framework/Test.php';
require_once 'PHPUnit/Framework/TestResult.php';
require_once 'PHPUnit/Runner/BaseTestRunner.php';
require_once 'PHPUnit/Runner/Version.php';
require_once 'PHPUnit/TextUI/ResultPrinter.php';
@include_once 'Benchmark/Timer.php';

/**
 * A TestRunner for the Command Line Interface (CLI)
 * PHP SAPI Module.
 *
 * @package phpunit.textui
 * @author  Sebastian Bergmann <sb@sebastian-bergmann.de>
 */
class PHPUnit_TextUI_TestRunner extends PHPUnit_Runner_BaseTestRunner {
    // {{{ Constants

    const SUCCESS_EXIT   = 0;
    const FAILURE_EXIT   = 1;
    const EXCEPTION_EXIT = 2;

    // }}}
    // {{{ Members

    /**
    * @var    PHPUnit_TextUI_ResultPrinter
    * @access private
    */
    private $printer;

    // }}}
    // {{{ public function __construct($resultPrinter = null)

    public function __construct($resultPrinter = null) {
        if ($resultPrinter === null) {
            $resultPrinter = new PHPUnit_TextUI_ResultPrinter;
        }

        $this->printer = $resultPrinter;
    }

    // }}}
    // {{{ public static function main()

    public static function main() {
        $aTestRunner = new PHPUnit_TextUI_TestRunner;

        try {
            $result = $aTestRunner->start($_SERVER['argv']);

            if (!$result->wasSuccessful()) {
                exit(self::FAILURE_EXIT);
            }

            exit(self::SUCCESS_EXIT);
        }

        catch (Exception $e) {
            print $e->getMessage();
            exit(self::EXCEPTION_EXIT);
        }
    }

    // }}}
    // {{{ protected function start($arguments)

    protected function start($arguments) {
        $txtLogfile = false;
        $xmlLogfile = false;
        $wait       = false;

        $options = Console_Getopt::getopt(
          $_SERVER['argv'],
          '',
          array(
            'help',
            'log=',
            'version',
            'wait',
            'xml='
          )
        );

        $test = isset($options[1][0]) ? $options[1][0] : false;

        foreach ($options[0] as $option) {
            switch ($option[0]) {
                case '--help': {
                    print "NOT YET IMPLEMENTED\n";
                    exit(SUCCESS_EXIT);
                }
                break;

                case '--log': {
                    $txtLogfile = $option[1];
                }
                break;

                case '--version': {
                    $this->printer->write(
                      PHPUnit_Runner_Version::getVersionString()
                    );

                    exit(SUCCESS_EXIT);
                }
                break;

                case '--wait': {
                    $wait = true;
                }
                break;

                case '--xml': {
                    $xmlLogfile = $option[1];
                }
                break;
            }
        }

        $this->printer->write(
          PHPUnit_Runner_Version::getVersionString() . "\n\n"
        );

        try {
			      return $this->doRun(
			        $this->getTest($test),
			        $txtLogfile,
			        $xmlLogfile,
			        $wait
			      );
        }

        catch (Exception $e) {
            throw new Exception(
              'Could not create and run test suite: ' . $e->getMessage()
            );
        }
    }

    // }}}
    // {{{ public static function run($test)

  	public static function run($test) {
        if ($test instanceof Reflection_Class) {
  		      self::run(new PHPUnit_Framework_TestSuite($testClass));
  		  }

        else if ($test instanceof PHPUnit_Framework_Test) {
            $aTestRunner = new PHPUnit_TextUI_TestRunner;

            return $aTestRunner->doRun($test);
        }
  	}

    // }}}
    // {{{ public static function runAndWait(PHPUnit_Framework_Test $suite)

  	public static function runAndWait(PHPUnit_Framework_Test $suite) {
  		  $aTestRunner = new PHPUnit_TextUI_TestRunner;
  		  $aTestRunner->doRun($suite, true);
  	}

    // }}}
    // {{{ public function getLoader()

  	public function getLoader() {
  		  return new PHPUnit_Runner_StandardTestSuiteLoader;
  	}

    // }}}
    // {{{ protected TestResult createTestResult()

  	protected function createTestResult() {
  		  return new PHPUnit_Framework_TestResult;
  	}
	
    // }}}
    // {{{ public function doRun(PHPUnit_Framework_Test $suite, $txtLogfile = false, $xmlLogfile = false, $wait = false)

  	public function doRun(PHPUnit_Framework_Test $suite, $txtLogfile = false, $xmlLogfile = false, $wait = false) {
    		$result = $this->createTestResult();

        if (class_exists('Benchmark_Timer')) {
            $timer = new Benchmark_Timer;
        }

    		$result->addListener($this->printer);

        if ($txtLogfile) {
            // XXX: NOT YET IMPLEMENTED
        }

        if (class_exists('XML_Tree') &&
            $xmlLogfile &&
            $xmlLogfileFP = fopen($xmlLogfile, 'w')) {
            $result->addListener(new PHPUnit_Extensions_Logger_XML($xmlLogfileFP));
        }

        if (isset($timer)) {
            $timer->start();
        }

        $suite->run($result);

        if (isset($timer)) {
            $timer->stop();
            $timeElapsed = $timer->timeElapsed();
        } else {
            $timeElapsed = false;
        }

        $this->pause($wait);
        $this->printer->printResult($result, $timeElapsed);

    		return $result;
  	}

    // }}}
    // {{{ protected function pause($wait)

    /**
    * @param  boolean $wait
    * @access protected
    */
    protected function pause($wait) {
        if (!$wait) {
            return;
        }

        $this->printer->printWaitPrompt();

        fgets(STDIN);
    }

    // }}}
    // {{{ public function testEnded($testName)

    /**
    * A test ended.
    *
    * @param  string  $testName
    * @access public
    * @abstract
    */
    public function testEnded($testName) {
    }

    // }}}
    // {{{ public function testFailed($status, PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e)

    /**
    * A test failed.
    *
    * @param  integer                                 $status
    * @param  PHPUnit_Framework_Test                  $test
    * @param  PHPUnit_Framework_AssertionFailedError  $e
    * @access public
    * @abstract
    */
    public function testFailed($status, PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e) {
    }

    // }}}
    // {{{ public function testStarted($testName)

    /**
    * A test started.
    *
    * @param  string  $testName
    * @access public
    * @abstract
    */
    public function testStarted($testName) {
    }

    // }}}
    // {{{ protected function runFailed($message)

    /**
    * Override to define how to handle a failed loading of
    * a test suite.
    *
    * @param  string  $message
    * @access protected
    * @abstract
    */
    protected function runFailed($message) {
        print $message;
        exit(self::FAILURE_EXIT);
    }

    // }}}
    // {{{ public function setPrinter(PHPUnit_TextUI_ResultPrinter $resultPrinter)

    public function setPrinter(PHPUnit_TextUI_ResultPrinter $resultPrinter) {
        $this->printer = $resultPrinter;
    }

    // }}}
}

if (PHPUnit_MAIN_METHOD == 'PHPUnit_TextUI_TestRunner::main') {
    PHPUnit_TextUI_TestRunner::main();
}

/*
 * vim600:  et sw=2 ts=2 fdm=marker
 * vim<600: et sw=2 ts=2
 */
?>
