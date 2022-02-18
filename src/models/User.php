<?php


class User
{
    private $email;
    private $password;
    private $name;
    private $surname;
    private $country;
    private $age;
    private $languages;
    private $instagram;
    private $facebook;
    private $snapchat;
    private $google;
    private $isAdmin;


    public function __construct(string $email, string $password, string $name, string $surname, string $instagram, string $facebook, string $snapchat, string $google, string $languages, string $country, string $age,int $isAdmin)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->country = $country;
        $this->age = $age;
        $this->languages = $languages;
        $this->instagram = $instagram;
        $this->facebook = $facebook;
        $this->snapchat = $snapchat;
        $this->google = $google;
        $this->isAdmin = $isAdmin;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name)
    {
        $this->name = $name;
    }


    public function getSurname(): string
    {
        return $this->surname;
    }


    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry($country): void
    {
        $this->country = $country;
    }

    public function getAge(): string
    {
        return $this->age;
    }

    public function setAge($age): void
    {
        $this->age = $age;
    }

    public function getLanguages(): string
    {
        return $this->languages;
    }

    public function setLanguages($languages): void
    {
        $this->languages = $languages;
    }

    public function getInstagram(): string
    {
        return $this->instagram;
    }

    public function setInstagram($instagram): void
    {
        $this->instagram = $instagram;
    }

    public function getFacebook(): string
    {
        return $this->facebook;
    }

    public function setFacebook($facebook): void
    {
        $this->facebook = $facebook;
    }

    public function getSnapchat(): string
    {
        return $this->snapchat;
    }

    public function setSnapchat($snapchat): void
    {
        $this->snapchat = $snapchat;
    }

    public function getGoogle(): string
    {
        return $this->google;
    }

    public function setGoogle($google): void
    {
        $this->google = $google;
    }

    public function getIsAdmin(): int
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(int $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }



}