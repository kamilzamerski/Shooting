<?php

namespace App\Models\Results;

use App\Exceptions\NotFoundException;
use App\Exceptions\RequiredValueException;
use App\Models\EventModel;
use App\Models\Results\Abstracts\BaseResultModel;
use App\Models\Results\Interfaces\ResultInterface;
use App\Models\ShooterModel;
use App\Validators\Results10from15Validator;

class Result10from15Model extends BaseResultModel implements ResultInterface
{

    public static function prepareResult(array $arrData): BaseResultModel
    {
        if (empty($arrData['shooter'])) {
            throw new RequiredValueException('Shooter param is empty');
        }
        if (empty($arrData['event'])) {
            throw new RequiredValueException('Event param is empty');
        }

        $objShooter = ShooterModel::find($arrData['shooter']);
        if (empty($objShooter)) {
            throw new NotFoundException('Shooter not found');
        }
        $objEvent = EventModel::find($arrData['event']);
        if (empty($objEvent)) {
            throw new NotFoundException('Event not found');
        }

        $objResult = new self;
        $objResult->setShooter($objShooter);
        $objResult->setEvent($objEvent);
        $objResult->setCompetition($arrData['competition']);
        $objResult->setResults($arrData['results']);
        $jsonPoints = json_decode($arrData['results'])->points;
        $objResult->setPointSum($objResult->getSumPoints((array)$jsonPoints));
        $objResult->save();
        return $objResult;
    }

    public static function prepareUpdateResult(BaseResultModel $objResult, array $arrData): BaseResultModel
    {
        if (!empty($arrData['shooter'])) {

            $objShooter = ShooterModel::find($arrData['shooter']);
            if (empty($objShooter)) {
                throw new NotFoundException('Shooter not found');
            }
            $objResult->setShooter($objShooter);
        }
        if (!empty($arrData['event'])) {
            $objEvent = EventModel::find($arrData['event']);
            if (empty($objEvent)) {
                throw new NotFoundException('Event not found');
            }
            $objResult->setEvent($objEvent);
        }
        if(!empty($arrData['competition'])) {
            $objResult->setCompetition($arrData['competition']);
        }
        if(!empty($arrData['results'])) {
            $objResult->setResults($arrData['results']);
            $jsonPoints = json_decode($arrData['results'])->points;
            $objResult->setPointSum($objResult->getSumPoints((array)$jsonPoints));
        }

        $objResult->save();
        return $objResult;
    }

    private function getSumPoints(array $arrPoints): int
    {
        arsort($arrPoints);
        $sumPoints = 0;
        foreach($arrPoints as $intKey => $intPoints) {
            if($intKey < 10) {
                $sumPoints += $intPoints;
            }
        }
        return $sumPoints;
    }

    /**
     * @param string $jsonResults
     * @return bool
     */
    public function validateResult(string $jsonResults): bool
    {
        return Results10from15Validator::isValid($jsonResults);
    }
}