<?php

namespace PhpUnitHelpers;

/**
 * Class DataProviderHelper
 *
 * Offers an API to create arrays for dataProviders used in PHPUnit
 *
 * @author Jens Wiese <jens@howtrueisfalse.de>
 */
class DataProviderHelper
{
    /**
     * @var array
     */
    protected $cases = array();

    /**
     * @var string
     */
    protected $currentCaseTitle;

    /**
     * Add new case
     *
     * @param string $title
     * @return $this
     */
    public function addCase($title)
    {
        $this->cases[$title] = array();
        $this->currentCaseTitle = $title;

        return $this;
    }

    /**
     * Add data to current case
     *
     * @param string $title
     * @param mixed $mixedData
     * @throws \UnexpectedValueException
     * @return $this
     */
    public function addData($title, $mixedData)
    {
        if (false === isset($this->cases[$this->currentCaseTitle])) {
            throw new \UnexpectedValueException(
                sprintf('You cannot add data - you have to add a case first by using %s->addCase().', __CLASS__)
            );
        }

        $this->cases[$this->currentCaseTitle][$title] = $mixedData;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $this->validateCases();

        return $this->cases;
    }

    /**
     * @throws \UnexpectedValueException
     */
    protected function validateCases()
    {
        $lastDataCount = null;

        foreach ($this->cases as $name => $caseData) {
            if (0 == count($caseData)) {
                throw new \UnexpectedValueException(
                    sprintf('No data for case "%s".', $name)
                );
            }

            $isNotFirstIteration = (false === is_null($lastDataCount));
            $hasDifferentCount = $lastDataCount != count($caseData);

            if ($isNotFirstIteration && $hasDifferentCount) {
                throw new \UnexpectedValueException(
                    sprintf('Count of data differs from prior cases in case "%s".', $name)
                );
            }

            $lastDataCount = count($caseData);
        }
    }
}