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
// $Id: ResultPrinter.php,v 1.19 2004/01/18 08:36:38 sebastian Exp $
//

require_once 'PHPUnit/Framework/TestFailure.php';
require_once 'PHPUnit/Framework/TestListener.php';
require_once 'PHPUnit/Framework/TestResult.php';
require_once 'PHPUnit/Util/Filter.php';

/**
 * @package phpunit.textui
 * @author  Sebastian Bergmann <sb@sebastian-bergmann.de>
 */
class PHPUnit_TextUI_ResultPrinter implements PHPUnit_Framework_TestListener {
    // {{{ Members

    /**
    * @var    integer
    * @access private
    */
    private $column = 0;

    /**
    * @var    resource
    * @access private
    */
    private $out;

    // }}}
    // {{{ public function __construct($out = null)

    /**
    * Constructor.
    *
    * @param  resource  $out
    * @access public
    */
    public function __construct($out = null) {
        if ($out === null) {
            $out = fopen('php://stdout', 'r');
        }

        $this->out = $out;
    }

    // }}}
    // {{{ public function __destruct()

    /**
    * Destructor.
    *
    * @access public
    */
    public function __destruct() {
        fclose($this->out);
    }

    // }}}
    // {{{ public function printResult(PHPUnit_Framework_TestResult $result, $timeElapsed)

    /**
    * @param  PHPUnit_Framework_TestResult  $result
    * @param  float                         $runTime
    * @access public
    */
    public function printResult(PHPUnit_Framework_TestResult $result, $timeElapsed) {
        $this->printHeader($timeElapsed);
        $this->printErrors($result);
        $this->printFailures($result);
        $this->printFooter($result);
    }

    // }}}
    // {{{ protected function printDefects($defects, $count, $type)

    /**
    * @param  array   $defects
    * @param  integer $count
    * @param  string  $type
    * @access protected
    */
    protected function printDefects($defects, $count, $type) {
        if ($count == 0) {
            return;
        }

        $this->write(
          sprintf(
            "There %s %d %s%s:\n",

            ($count == 1) ? 'was' : 'were',
            $count,
            $type,
            ($count == 1) ? '' : 's'
          )
        );

        $i = 1;

        foreach ($defects as $defect) {
            $this->printDefect($defect, $i++);
        }
    }

    // }}}
    // {{{ protected function printDefect(PHPUnit_Framework_TestFailure $defect, $count)

    /**
    * @param  PHPUnit_Framework_TestFailure $defect
    * @param  integer                       $count
    * @access protected
    */
    protected function printDefect(PHPUnit_Framework_TestFailure $defect, $count) {
        $this->printDefectHeader($defect, $count);
        $this->printDefectTrace($defect);
    }

    // }}}
    // {{{ protected function printDefectHeader(PHPUnit_Framework_TestFailure $defect, $count)

    /**
    * @param  PHPUnit_Framework_TestFailure $defect
    * @param  integer                       $count
    * @access protected
    */
    protected function printDefectHeader(PHPUnit_Framework_TestFailure $defect, $count) {
        $name = $defect->failedTest()->getName();

        if ($name == null) {
            $class = new Reflection_Class($defect->failedTest());
            $name  = $class->name;
        }

        $this->write(
          sprintf(
            "%d) %s\n",

            $count,
            $name
          )
        );
    }

    // }}}
    // {{{ protected function printDefectTrace(PHPUnit_Framework_TestFailure $defect)

    /**
    * @param  PHPUnit_Framework_TestFailure $defect
    * @access protected
    */
    protected function printDefectTrace(PHPUnit_Framework_TestFailure $defect) {
        $this->write(
          $defect->thrownException()->toString() . "\n"
        );

        $this->write(
          PHPUnit_Util_Filter::getFilteredStacktrace(
            $defect->thrownException()
          )
        );
    }

    // }}}
    // {{{ protected function printErrors(PHPUnit_Framework_TestResult $result)

    /**
    * @param  PHPUnit_Framework_TestResult  $result
    * @access protected
    */
    protected function printErrors(PHPUnit_Framework_TestResult $result) {
        $this->printDefects($result->errors(), $result->errorCount(), 'error');
    }

    // }}}
    // {{{ protected function printFailures(PHPUnit_Framework_TestResult $result)

    /**
    * @param  PHPUnit_Framework_TestResult  $result
    * @access protected
    */
    protected function printFailures(PHPUnit_Framework_TestResult $result) {
        $this->printDefects($result->failures(), $result->failureCount(), 'failure');
    }

    // }}}
    // {{{ protected function printHeader($timeElapsed)

    /**
    * @param  float   $timeElapsed
    * @access protected
    */
    protected function printHeader($timeElapsed) {
        if ($timeElapsed) {
            $this->write(
              sprintf(
                "\n\nTime: %s\n",

                $timeElapsed
              )
            );
        }
    }

    // }}}
    // {{{ protected function printFooter(PHPUnit_Framework_TestResult $result)

    /**
    * @param  PHPUnit_Framework_TestResult  $result
    * @access protected
    */
    protected function printFooter(PHPUnit_Framework_TestResult $result) {
        if ($result->wasSuccessful()) {
            $this->write(
              sprintf(
                "\nOK (%d test%s)\n",

                $result->runCount(),
                ($result->runCount() == 1) ? '' : 's'
              )
            );
        } else {
            $this->write(
              sprintf(
                "\nFAILURES!!!\nTests run: %d, Failures: %d, Errors: %d.\n",

                $result->runCount(),
                $result->failureCount(),
                $result->errorCount()
              )
            );
        }
    }

    // }}}
    // {{{ public function printWaitPrompt()

    /**
    * @access public
    */
    public function printWaitPrompt() {
        $this->write("\n<RETURN> to continue\n");
    }

    // }}}
    // {{{ public function addError(PHPUnit_Framework_Test $test, Exception $e)

    /**
    * An error occurred.
    *
    * @param  PHPUnit_Framework_Test  $test
    * @param  Exception               $e
    * @access public
    */
    public function addError(PHPUnit_Framework_Test $test, Exception $e) {
        $this->write('E');
    }

    // }}}
    // {{{ public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e)

    /**
    * A failure occurred.
    *
    * @param  PHPUnit_Framework_Test                 $test
    * @param  PHPUnit_Framework_AssertionFailedError $e
    * @access public
    */
    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e) {
        $this->write('F');
    }

    // }}}
    // {{{ public function endTest(PHPUnit_Framework_Test $test)

    /**
    * A test ended.
    *
    * @param  PHPUnit_Framework_Test $test
    * @access public
    */
    public function endTest(PHPUnit_Framework_Test $test) {
    }

    // }}}
    // {{{ public function startTest(PHPUnit_Framework_Test $test)

    /**
    * A test started.
    *
    * @param  PHPUnit_Framework_Test $test
    * @access public
    */
    public function startTest(PHPUnit_Framework_Test $test) {
        $this->write('.');

        if ($this->column++ >= 40) {
            $this->column = 0;
            $this->write("\n");
        }
    }

    // }}}
    // {{{ public function write($buffer)

    /**
    * @param  string $buffer
    * @access public
    */
    public function write($buffer) {
        fputs($this->out, $buffer);
    }

    // }}}
}

/*
 * vim600:  et sw=2 ts=2 fdm=marker
 * vim<600: et sw=2 ts=2
 */
?>
