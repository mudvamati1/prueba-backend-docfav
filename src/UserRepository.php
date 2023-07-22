<?php

namespace App;

class UserRepository
{
    private $users = [];

    public function save(User $user)
    {
        $this->users[$user->getEmail()] = $user;
    }

    public function update(User $user)
    {
        if (isset($this->users[$user->getEmail()])) {
            $this->users[$user->getEmail()] = $user;
        } else {
            throw new \Exception('User not found in repository');
        }
    }

    public function delete(User $user)
    {
        if (isset($this->users[$user->getEmail()])) {
            unset($this->users[$user->getEmail()]);
        } else {
            throw new \Exception('User not found in repository');
        }
    }

    public function getByEmail($email)
    {
        return $this->users[$email] ?? null;
    }

    public function getAllUsers()
    {
        return $this->users;
    }

    public function getByIdOrFail($id)
    {
        // Aquí simulamos la búsqueda por ID en el arreglo en memoria
        foreach ($this->users as $user) {
            if ($user->getId() == $id) {
                return $user;
            }
        }

        // Si no se encuentra el usuario con el ID especificado, lanzamos una excepción
        throw new UserDoesNotExistException('User not found with the specified ID');
    }
}
