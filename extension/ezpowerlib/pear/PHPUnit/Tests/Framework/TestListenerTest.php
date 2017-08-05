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
// $Id: TestListenerTest.php,v 1.4 2004/01/04 10:25:11 sebastian Exp $
//

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'PHPUnit/Framework/TestListener.php';
require_once 'PHPUnit/Framework/TestResult.php';

require_once 'PHPUnit/Tests/Framework/Error.php';
require_once 'PHPUnit/Tests/Framework/Failure.php';
require_once 'PHPUnit/Tests/Framework/Success.php';

class PHPUnit_Tests_Framework_TestListenerTest extends PHPUnit_Framework_TestCase implements PHPUnit_Framework_TestListener {
    private $result;
    private $startCount;
    private $endCount;
    private $failureCount;
    private $errorCount;

    public function addError(PHPUnit_Framework_Test $test, Exception $e) {
        $this->errorCount++;
    }

    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e) {
        $this->failureCount++;
    }

    public function endTest(PHPUnit_Framework_Test $test) {
        $this->endCount++;
    }

    public function startTest(PHPUnit_Framework_Test $test) {
        $this->startCount++;
    }

    protected function setUp() {
        $this->result = new PHPUnit_Framework_TestResult;
        $this->result->addListener($this);

        $this->failureCount = 0;
        $this->endCount     = 0;
        $this->startCount   = 0;
    }

    public function testError() {
        $test = new PHPUnit_Tests_Framework_Error;
        $test->run($this->result);

        $this->assertEquals(1, $this->errorCount);
        $this->assertEquals(1, $this->endCount);
    }

    public function testFailure() {
        $test = new PHPUnit_Tests_Framework_Failure;
        $test->run($this->result);

        $this->assertEquals(1, $this->failureCount);
        $this->assertEquals(1, $this->endCount);
    }

    public function testStartStop() {
        $test = new PHPUnit_Tests_Framework_Success;
        $test->run($this->result);

        $this->assertEquals(1, $this->startCount);
        $this->assertEquals(1, $this->endCount);
    }
}

/*
 * vim600:  et sw=2 ts=2 fdm=marker
 * vim<600: et sw=2 ts=2
 */
?>
