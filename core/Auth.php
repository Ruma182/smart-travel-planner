<?php
/**
 * Session-based authentication for the logged-in provider.
 */
class Auth
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function id(): ?int
    {
        self::start();

        return isset($_SESSION['provider_id']) ? (int) $_SESSION['provider_id'] : null;
    }

    public static function check(): bool
    {
        return self::id() !== null;
    }

    public static function requireLogin(): int
    {
        self::start();

        if (!isset($_SESSION['provider_id'])) {
            header('Location: login.php');
            exit;
        }

        return (int) $_SESSION['provider_id'];
    }

    public static function login(int $providerId, string $name): void
    {
        self::start();

        $_SESSION['provider_id'] = $providerId;
        $_SESSION['provider_name'] = $name;
    }

    public static function setName(string $name): void
    {
        self::start();

        $_SESSION['provider_name'] = $name;
    }

    public static function logout(): void
    {
        self::start();

        session_unset();
        session_destroy();
    }
}
