<?php
namespace DTO;
class dtoApiary
{
    private $apiary_id;
    private $apiary_name;
    private $location;
    private $hive_sum;
    private $user_id;

    /**
     * @return mixed
     */
    public function getApiaryId()
    {
        return $this->apiary_id;
    }

    /**
     * @return mixed
     */
    public function getApiaryName()
    {
        return $this->apiary_name;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return mixed
     */
    public function getHiveSum()
    {
        return $this->hive_sum;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }


}