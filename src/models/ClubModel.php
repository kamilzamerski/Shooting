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
 * @property $created_at
 * @property $updated_at
 */
class ClubModel extends Model
{
    protected $table = 'club';

    /**
     * @param string $strName
     * @return ClubModel
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
     * @param string $strLicenseNo
     * @return ClubModel
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
     * @return ClubModel|null
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
            throw new NotFoundException('Club not found');
        }
        return $objShooter->delete();
    }

    /**
     * Add Club Record
     * @param array $args
     * @return ClubModel|bool
     * @throws RequiredValueException
     */
    public static function addClub(array $args)
    {
        if (empty($args['name'])) {
            throw new RequiredValueException('Name param is empty');
        }
        if (empty($args['license'])) {
            throw new RequiredValueException('License param is empty');
        }


        $objClub = (new self)->setName($args['name'])->setLicense($args['license']);
        if ($objClub->save()) {
            return $objClub;
        }
        return false;
    }


    /**
     * Update Club Record
     * @param int $id
     * @param array $args
     * @return ClubModel|bool
     * @throws NotFoundException
     */
    public static function updateClub(int $id, array $args)
    {
        $objClub = self::find($id);
        if (empty($objClub)) {
            throw new NotFoundException('Club not found');
        }

        if (!empty($args['name'])) {
            $objClub->setName($args['name']);
        }

        if (!empty($args['license'])) {
            $objClub->setLicense($args['license']);
        }


        if ($objClub->save()) {
            return $objClub;
        }
        return false;
    }
}