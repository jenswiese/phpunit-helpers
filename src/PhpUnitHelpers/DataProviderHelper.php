<?php

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
        $this->currentCaseTitle = $title;

        return $this;
    }

    /**
     * Add data to current case
     *
     * @param mixed $mixedData
     * @return $this
     * @throws InvalidArgumentException
     */
    public function addData($mixedData)
    {
        if (is_null($this->currentCaseTitle)) {
            throw new InvalidArgumentException(
                sprintf('You cannot add data - you have to add a case first by using %s->addCase().', __CLASS__)
            );
        }

        $this->cases[$this->currentCaseTitle][] = $mixedData;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->cases;
    }
}