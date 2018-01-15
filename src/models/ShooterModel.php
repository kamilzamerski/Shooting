<?php

namespace App\Models;

use App\Exceptions\NotFoundException;
use App\Exceptions\RequiredValueException;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ClubModel
 * @package App\Models
 * @property-read $id
 * @property $name
 * @property $license_no
 * @property $club_id
 * @property $created_at
 * @property $updated_at
 */
class ShooterModel extends Model
{
    protected $table = 'shooter';

    /**
     * Foreign Key Club
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function club()
    {
        return $this->hasOne(ClubModel::class, 'id', 'club_id');
    }

    /**
     * @param string $strName
     * @return ShooterModel
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
     * @param ClubModel $objClub
     * @return ShooterModel
     */
    public function setClub(ClubModel $objClub): self
    {
        $this->club_id = $objClub->id;
        return $this;
    }

    /**
     * @param string $strLicenseNo
     * @return ShooterModel
     */
    public function setLicense(string $strLicenseNo): self
    {
        $this->license_no = $strLicenseNo;
        return $this;
    }

    /**
     * @return string
     */
    public function getLicense(): string
    {
        return $this->license_no;
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
        $objShooter = self::find($intId);
        if (empty($objShooter)) {
            throw new NotFoundException('Shooter not found');
        }
        return $objShooter->delete();
    }

    /**
     * @param array $args
     * @return ShooterModel|bool
     * @throws RequiredValueException
     * @throws NotFoundException
     */
    public static function addShooter(array $args)
    {
        if (empty($args['name'])) {
            throw new RequiredValueException('Name param is empty');
        }
        if (empty($args['club'])) {
            throw new RequiredValueException('Club param is empty');
        }
        if (empty($args['license'])) {
            throw new RequiredValueException('License param is empty');
        }

        $objClub = ClubModel::find($args['club']);
        if (empty($objClub)) {
            throw new NotFoundException('Club not found');
        }

        $objShooter = (new self)->setName($args['name'])->setLicense($args['license'])->setClub($objClub);
        if ($objShooter->save()) {
            return $objShooter;
        }
        return false;
    }


    /**
     * @param int $id
     * @param array $args
     * @return ShooterModel|bool
     * @throws NotFoundException
     */
    public static function updateShooter(int $id, array $args)
    {
        $objShooter = self::find($id);
        if (empty($objShooter)) {
            throw new NotFoundException('Shooter not found');
        }

        if (!empty($args['club'])) {
            $objClub = ClubModel::find($args['club']);
            if (empty($objClub)) {
                throw new NotFoundException('Club not found');
            }
            $objShooter->setClub($objClub);
        }

        if (!empty($args['license'])) {
            $objShooter->setLicense($args['license']);
        }

        if (!empty($args['name'])) {
            $objShooter->setName($args['name']);
        }


        if ($objShooter->save()) {
            return $objShooter;
        }
        return false;
    }

}