<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ListUserDoubletsAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $users = $this->userRepository->findDubletts();
        $this->logger->info("List of User Doublets:");

        return $this->respondWithData($users);
    }
}
