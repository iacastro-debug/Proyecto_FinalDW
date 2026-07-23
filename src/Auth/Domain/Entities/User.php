<?php

namespace Src\Auth\Domain\Entities;

use DateTimeImmutable;
use Src\Auth\Domain\Enums\Role;

class User
{
    private ?string $id;
    private string $name;
    private string $email;
    private string $password;
    private Role $role;
    private bool $activo;
    private ?DateTimeImmutable $emailVerifiedAt;
    private ?DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $updatedAt;

    public function __construct(
        string $name,
        string $email,
        string $password,
        Role $role = Role::Paciente,
        bool $activo = true,
        ?string $id = null,
        ?DateTimeImmutable $emailVerifiedAt = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->activo = $activo;
        $this->emailVerifiedAt = $emailVerifiedAt;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function isActivo(): bool
    {
        return $this->activo;
    }

    public function getEmailVerifiedAt(): ?DateTimeImmutable
    {
        return $this->emailVerifiedAt;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function updateName(string $name): void
    {
        $this->name = $name;
    }

    public function updateEmail(string $email): void
    {
        $this->email = $email;
    }

    public function updatePassword(string $password): void
    {
        $this->password = $password;
    }

    public function updateRole(Role $role): void
    {
        $this->role = $role;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role->value,
            'role_label' => $this->role->label(),
            'activo' => $this->activo,
            'created_at' => $this->createdAt?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt?->format('Y-m-d H:i:s'),
        ];
    }
}
