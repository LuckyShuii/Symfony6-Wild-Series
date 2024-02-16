<?php

namespace App\Form\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UserCredentialsDTO
{
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(max: 180)]
    #[Assert\Length(min: 3)]
    public ?string $email = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 6)]
    public ?string $password = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    public ?string $username = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public ?string $firstname = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public ?string $lastname = null;
}
