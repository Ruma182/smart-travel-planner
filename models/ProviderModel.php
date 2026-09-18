<?php
/**
 * Model: service_providers table access.
 */
class ProviderModel extends Model
{
    public function findByEmail(string $email)
    {
        $stmt = $this->conn->prepare(
            "SELECT provider_id, full_name, password, status
             FROM service_providers
             WHERE email=?
             LIMIT 1"
        );

        $stmt->bind_param('s', $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->conn->prepare("SELECT provider_id FROM service_providers WHERE email=? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();

        return (bool) $stmt->get_result()->fetch_assoc();
    }

    public function create(string $fullName, string $email, string $hashed, string $phone, string $companyName, string $address)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO service_providers
             (full_name, email, password, phone, company_name, address, status)
             VALUES (?, ?, ?, ?, ?, ?, 'active')"
        );

        $stmt->bind_param(
            'ssssss',
            $fullName,
            $email,
            $hashed,
            $phone,
            $companyName,
            $address
        );

        if (!$stmt->execute()) {
            return false;
        }

        return $this->conn->insert_id;
    }

    public function getById(int $providerId)
    {
        $s = $this->conn->prepare(
            "SELECT *
             FROM service_providers
             WHERE provider_id=?"
        );

        $s->bind_param('i', $providerId);
        $s->execute();

        return $s->get_result()->fetch_assoc();
    }

    public function updateProfile(int $providerId, string $name, string $phone, string $company, string $address)
    {
        $u = $this->conn->prepare(
            "UPDATE service_providers
             SET full_name=?,
                 phone=?,
                 company_name=?,
                 address=?
             WHERE provider_id=?"
        );

        $u->bind_param(
            'ssssi',
            $name,
            $phone,
            $company,
            $address,
            $providerId
        );

        return $u->execute();
    }

    public function getPasswordHash(int $providerId)
    {
        $stmt = $this->conn->prepare(
            "SELECT password
             FROM service_providers
             WHERE provider_id = ?
             LIMIT 1"
        );

        $stmt->bind_param('i', $providerId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function updatePassword(int $providerId, string $hashedPassword)
    {
        $update = $this->conn->prepare(
            "UPDATE service_providers
             SET password = ?
             WHERE provider_id = ?"
        );

        $update->bind_param(
            'si',
            $hashedPassword,
            $providerId
        );

        return $update->execute();
    }

    public function delete(int $providerId)
    {
        $s = $this->conn->prepare("DELETE FROM service_providers WHERE provider_id=?");
        $s->bind_param('i', $providerId);

        return $s->execute();
    }
}
