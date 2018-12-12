<?php

namespace DTO;

class dtoListType
{
    private $list_type_id;
    private $name;
    private $description;
    private $type;
    private $list;
    private $user_id;
    private $date_create;
    private $date_edit;

    /**
     * @return mixed
     */
    public function getListTypeId()
    {
        return $this->list_type_id;
    }

    /**
     * @param mixed $list_type_id
     */
    public function setListTypeId($list_type_id): void
    {
        $this->list_type_id = $list_type_id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @param mixed $list
     */
    public function setList($list): void
    {
        $this->list = $list;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getDateCreate()
    {
        return $this->date_create;
    }

    /**
     * @param mixed $date_create
     */
    public function setDateCreate($date_create): void
    {
        $this->date_create = $date_create;
    }

    /**
     * @return mixed
     */
    public function getDateEdit()
    {
        return $this->date_edit;
    }

    /**
     * @param mixed $date_edit
     */
    public function setDateEdit($date_edit): void
    {
        $this->date_edit = $date_edit;
    }


}