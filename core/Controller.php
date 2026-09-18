<?php
/**
 * Base Controller: handles auth gating, view rendering and redirects
 * so individual controllers only contain request-handling logic.
 */
abstract class Controller
{
    protected int $providerId;

    public function __construct(bool $requireAuth = true)
    {
        if ($requireAuth) {
            $this->providerId = Auth::requireLogin();
        } else {
            Auth::start();
        }
    }

    protected function render(string $view, array $data = []): void
    {
        extract($data);
        require __DIR__ . '/../views/' . $view . '.php';
    }

    protected function redirect(string $location): void
    {
        header('Location: ' . $location);
        exit;
    }

    /**
     * True when the current request was made via fetch()/XHR and expects JSON
     * (i.e. the request carries the X-Requested-With header or asks for
     * application/json). Regular browser form submissions/navigations are
     * unaffected and keep working exactly as before.
     */
    protected function isAjax(): bool
    {
        $requestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';

        return strtolower($requestedWith) === 'xmlhttprequest'
            || strpos($accept, 'application/json') !== false;
    }

    /**
     * Send a JSON response and stop execution.
     */
    protected function jsonResponse(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
