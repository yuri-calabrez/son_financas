<?php

namespace SONFin\Models;

interface UserInterface
{
    public function getId(): int;

    public function getFullName(): string;

    public function geEmail(): string;

    public function getPassword(): string;
}
