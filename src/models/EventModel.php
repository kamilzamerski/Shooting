<?php

namespace App\Models;

use App\Exceptions\NotFoundException;
use App\Exceptions\RequiredValueException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ClubModel
 * @package App\Models
 * @property-read $id
 * @property $name
 * @property $date
 * @property $club_id
 * @property-read $created_at
 * @property-read $updated_at
 */
class EventModel extends Model
{
    protected $table = 'event';

    /**
     * @param string $strName
     * @return EventModel
     */
    public function setName(string $strName): self
    {
        $this->name = $strName;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Format Y-m-d
     * @param string $strDate
     * @return EventModel
     */
    public function setDate(string $strDate): self
    {
        try {
            $objDate = Carbon::parse($strDate);
        } catch (\Exception $ex) {
            throw new \InvalidArgumentException('Invalid Date');
        }
        $this->date = $objDate->format('Y-m-d');
        return $this;
    }

    /**
     * Format Y-m-d
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param ClubModel $objClub
     * @return EventModel
     */
    public function setClub(ClubModel $objClub): self
    {
        $this->club_id = $objClub->id;
        return $this;
    }

    /**
     * Foreign Key Club
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getClub()
    {
        return $this->hasOne(ClubModel::class, 'id', 'club_id');
    }

    /**
     * @param int $intId
     * @return ShooterModel|null
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
        $objEvent = self::find($intId);
        if (empty($objEvent)) {
            throw new NotFoundException('Club not found');
        }
        return $objEvent->delete();
    }

    /**
     * @param array $args
     * @return EventModel|bool
     * @throws RequiredValueException
     * @throws NotFoundException
     */
    public static function addEvent(array $args)
    {
        if (empty($args['name'])) {
            throw new RequiredValueException('Name param is empty');
        }
        if (empty($args['club'])) {
            throw new RequiredValueException('Club param is empty');
        }
        if (empty($args['date'])) {
            throw new RequiredValueException('Date param is empty');
        }

        $objClub = ClubModel::find($args['club']);
        if (empty($objClub)) {
            throw new NotFoundException('Club not found');
        }

        $objEvent = (new self)->setName($args['name'])->setDate($args['date'])->setClub($objClub);
        if ($objEvent->save()) {
            return $objEvent;
        }
        return false;
    }


    /**
     * @param int $id
     * @param array $args
     * @return EventModel|bool
     * @throws NotFoundException
     */
    public static function updateEvent(int $id, array $args)
    {
        $objEvent = self::find($id);
        if (empty($objEvent)) {
            throw new NotFoundException('Event not found');
        }

        if (!empty($args['club'])) {
            $objClub = ClubModel::find($args['club']);
            if (empty($objClub)) {
                throw new NotFoundException('Club not found');
            }
            $objEvent->setClub($objClub);
        }

        if (!empty($args['date'])) {
            $objEvent->setDate($args['license']);
        }

        if (!empty($args['name'])) {
            $objEvent->setName($args['license']);
        }

        if ($objEvent->save()) {
            return $objEvent;
        }
        return false;
    }
}