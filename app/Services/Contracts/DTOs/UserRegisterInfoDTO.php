<?php


namespace App\Services\Contracts\DTOs;


/**
 * Class UserRegisterInfoDTO
 */
class UserRegisterInfoDTO
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var null|string
     */
    protected $email;

    /**
     * @var null|string
     */
    protected $password;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


}
