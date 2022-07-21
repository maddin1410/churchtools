<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\Repository\DubletteRepository;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    protected DubletteRepository $userRepository;

    public function __construct(LoggerInterface $logger, DubletteRepository $userRepository)
    {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
    }
}
