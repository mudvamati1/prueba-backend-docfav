<?php

use App\User;
use App\UserRepository;
use App\UserDoesNotExistException;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $user = new User(123,'Juanito Perez', 'juanito@gmail.com', 'password123');

        $this->assertEquals(123, $user->getId());
        $this->assertEquals('Juanito Perez', $user->getName());
        $this->assertEquals('juanito@gmail.com', $user->getEmail());
        $this->assertEquals('password123', $user->getPassword());

        $user->setId(345);
        $user->setName('Marcelo Carrasco');
        $user->setEmail('marcelo@gmail.com');
        $user->setPassword('newpassword');

        $this->assertEquals(345, $user->getId());
        $this->assertEquals('Marcelo Carrasco', $user->getName());
        $this->assertEquals('marcelo@gmail.com', $user->getEmail());
        $this->assertEquals('newpassword', $user->getPassword());
    }

    public function testSaveUser()
    {
        $user = new User(123,'Juanito Perez', 'juanito@gmail.com', 'password123');
        $userRepository = new UserRepository();

        $userRepository->save($user);

        $this->assertSame($user, $userRepository->getByEmail('juanito@gmail.com'));
    }

    public function testUpdateUser()
    {
        $user = new User(123,'Juanito Perez', 'juanito@gmail.com', 'password123');
        $userRepository = new UserRepository();

        $userRepository->save($user);

        $user->setName('Marcelo Carrasco');
        $userRepository->update($user);

        $this->assertSame('Marcelo Carrasco', $userRepository->getByEmail('juanito@gmail.com')->getName());
    }

    public function testDeleteUser()
    {
        $user = new User(123,'Juanito Perez', 'juanito@gmail.com', 'password123');
        $userRepository = new UserRepository();

        $userRepository->save($user);

        $userRepository->delete($user);

        $this->assertNull($userRepository->getByEmail('juanito@gmail.com'));
    }

    public function testGetAllUsers()
    {
        $userRepository = new UserRepository();

        $this->assertEmpty($userRepository->getAllUsers());

        $user1 = new User(123,'Juanito Perez', 'juanito@gmail.com', 'password123');
        $userRepository->save($user1);

        $this->assertCount(1, $userRepository->getAllUsers());

        $user2 = new User(345,'Juan Jurado', 'jane@gmail.com', 'testpass');
        $userRepository->save($user2);

        $this->assertCount(2, $userRepository->getAllUsers());
    }
    public function testGetUserByIdThrowsExceptionWhenNotFound()
    {
        $userRepository = new UserRepository();

        // Creamos un usuario con un ID específico para probar el método 'getByIdOrFail'
        $user = new User(1, 'Juanito Perez', 'juanito@gmail.com', 'password123');

        // Guardamos el usuario en el repositorio
        $userRepository->save($user);

        // Asumimos que '999' es el ID de un usuario que no existe en el repositorio.
        $nonExistentId = 999;

        $this->expectException(UserDoesNotExistException::class);
        $userRepository->getByIdOrFail($nonExistentId);
    }

    
}
