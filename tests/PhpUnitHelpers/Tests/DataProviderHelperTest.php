<?php

namespace PhpUnitHelpers\Tests;

use PhpUnitHelpers\DataProviderHelper;

class DataProviderHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testOutputOfArray()
    {
        $helper = new DataProviderHelper();
        $helper
            ->addCase('Case 1')
                ->addData('Data 1', 'foo 1')
                ->addData('Data 2', 'foo 2')
                ->addData('Data 3', 'foo 3')
            ->addCase('Case 2')
                ->addData('Data 1', 'bar 1')
                ->addData('Data 2', 'bar 2')
                ->addData('Data 3', 'bar 3');

        $expectedArray = array(
            'Case 1' => array(
                'Data 1' => 'foo 1',
                'Data 2' => 'foo 2',
                'Data 3' => 'foo 3',
            ),
            'Case 2' => array(
                'Data 1' => 'bar 1',
                'Data 2' => 'bar 2',
                'Data 3' => 'bar 3',
            ),
        );

        $this->assertEquals($expectedArray, $helper->toArray());
    }

    /**
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage You cannot add data - you have to add a case first by using PhpUnitHelpers\DataProviderHelper->addCase().
     */
    public function testAddingDataWithoutCase()
    {
        $helper = new DataProviderHelper();
        $helper->addData('Data 1', 'foo 1');
    }

    /**
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage No data for case "Case 1".
     */
    public function testAddingCasesWithoutData()
    {
        $helper = new DataProviderHelper();
        $helper->addCase('Case 1')->addCase('Case 2');
        $helper->toArray();
    }

    /**
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Count of data differs from prior cases in case "Case 2".
     */
    public function testDataCountMustBeEqualForAllCases()
    {
        $helper = new DataProviderHelper();
        $helper
            ->addCase('Case 1')
            ->addData('Data 1', 'foo 1')
            ->addCase('Case 2')
            ->addData('Data 1', 'bar 1')
            ->addData('Data 2', 'bar 2');
        $helper->toArray();
    }

}
 