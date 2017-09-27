<?php
namespace shop\services\manage;

use backend\forms\manage\User\UserCreateForm;
use shop\entities\User\User;
use shop\repositories\UserRepository;

class UserManageService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(UserCreateForm $form)
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
        );

        $this->repository->save($user);

        return $user;
    }

    public function edit($id, $form): void
    {
        $user = $this->repository->get($id);

        $user->edit(
            $form->username,
            $form->email
        );

        $this->repository->save($user);
    }
}