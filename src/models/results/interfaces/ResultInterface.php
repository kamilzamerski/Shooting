<?php

namespace App\Models\Results\Interfaces;

use App\Models\Results\Abstracts\BaseResultModel;

interface ResultInterface
{

    /**
     * @param array $arrData
     * @return mixed
     */
    public static function addResult(array $arrData);

    /**
     * @param string $jsonResults
     * @return mixed
     */
    public function setResults(string $jsonResults);

    /**
     * @param array $arrData
     * @return BaseResultModel
     */
    public static function prepareResult(array $arrData): BaseResultModel;


    /**
     * @param BaseResultModel $objResult
     * @param array $arrData
     * @return BaseResultModel
     */
    public static function prepareUpdateResult(BaseResultModel $objResult, array $arrData): BaseResultModel;


    /**
     * @param string $jsonResults
     * @return bool
     */
    public function validateResult(string $jsonResults): bool;
}