<?php
namespace App;
interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?array;
    public function save(array $userData): bool;
}

// La implementación real usa Eloquent/PDO, pero los tests no la tocarán