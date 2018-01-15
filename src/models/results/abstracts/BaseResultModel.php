<?php

namespace App\Models\Results\Abstracts;

use App\Exceptions\NotFoundException;
use App\Exceptions\RequiredValueException;
use App\Models\EventModel;
use App\Models\Results\Result10from15Model;
use App\Models\ShooterModel;
use App\Validators\JsonValidator;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseResultModel
 * @package App\Models\Abstracts
 * @property-read $id
 * @property $created_at
 * @property $updated_at
 * @property $event_id
 * @property $shooter_id
 * @property $competition
 * @property $point_sum
 * @property $time_sum
 * @property $results
 */
class BaseResultModel extends Model
{

    protected $table = 'result';

    static $arrAvailableCompetitions = [
        1 => Result10from15Model::class
    ];

    /**
     * @param EventModel $objEvent
     */
    public function setEvent(EventModel $objEvent)
    {
        $this->event_id = $objEvent->id;
    }

    /**
     * @param ShooterModel $objShooter
     */
    public function setShooter(ShooterModel $objShooter)
    {
        $this->shooter_id = $objShooter->id;
    }

    /**
     * @param int $intCompetition
     */
    public function setCompetition(int $intCompetition)
    {
        $this->competition = $intCompetition;
    }

    /**
     * @param float $floatPointSum
     */
    public function setPointSum(float $floatPointSum)
    {
        $this->point_sum = $floatPointSum;
    }

    /**
     * @param float $floatTimeSum
     */
    public function setTimeSum(float $floatTimeSum)
    {
        $this->time_sum = $floatTimeSum;
    }

    /**
     * @param int $intId
     * @return BaseResultModel|null
     */
    public static function getById(int $intId)
    {
        return self::find($intId);
    }

    /**
     * @param int $intId
     * @return bool|null
     * @throws NotFoundException
     */
    public static function deleteById(int $intId)
    {
        $objResult = self::find($intId);
        if (empty($objResult)) {
            throw new NotFoundException('Result not found');
        }
        return $objResult->delete();
    }

    /**
     * @param string $jsonResults
     */
    public function setResults(string $jsonResults)
    {
        if(!JsonValidator::isValid($jsonResults)){
            throw new \InvalidArgumentException('Invalid Json structure.');
        }
        if (!$this->validateResult($jsonResults)) {
            throw new \InvalidArgumentException('Invalid result structure.');
        }
        $this->results = $jsonResults;
    }

    /**
     * @param int $intId
     * @return bool
     */
    public static function isValidCompetition(int $intId)
    {
        return isset(static::$arrAvailableCompetitions[$intId]);
    }

    /**
     * @param array $arrData
     * @return BaseResultModel
     * @throws RequiredValueException
     * @throws NotFoundException
     */
    public static function addResult(array $arrData): BaseResultModel
    {

        if (empty($arrData['competition'])) {
            throw new RequiredValueException('Competition param is empty');
        }
        if(!static::isValidCompetition($arrData['competition'])){
            throw new NotFoundException('Competition not found');
        }
        return (static::$arrAvailableCompetitions[$arrData['competition']])::prepareResult($arrData);
    }

    /**
     * @param int $intId
     * @param array $arrData
     * @return BaseResultModel
     * @throws NotFoundException
     */
    public static function updateResult(int $intId, array $arrData): BaseResultModel
    {
        $objResult = BaseResultModel::find($intId);
        if(empty($objResult)) {
            throw new NotFoundException('Result not found');
        }
        if (!empty($arrData['competition'])) {
            if (!static::isValidCompetition($arrData['competition'])) {
                throw new NotFoundException('Competition not found');
            }
            $intCompetition = $arrData['competition'];
        } else {
            $intCompetition = $objResult->competition;
        }
        $objResult = static::$arrAvailableCompetitions[$intCompetition]::find($intId);
        return (static::$arrAvailableCompetitions[$intCompetition])::prepareUpdateResult($objResult, $arrData);
    }

    public function toArray()
    {
        $arrData = parent::toArray();
        $arrData['results'] = (array) json_decode($arrData['results']);
        return $arrData;
    }

}