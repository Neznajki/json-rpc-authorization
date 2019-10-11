<?php


namespace JsonRpcAuthorizationBundle\Contract;

interface CredentialsInterface
{
    public function __construct(string $userName, string $password, int $generationTime);

    public function getUserName(): string;

    public function getPassword(): string;

    public function getGenerationTime(): int;
}
