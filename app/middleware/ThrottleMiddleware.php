<?php
namespace App\Middleware;

class ThrottleMiddleware {
    private const LIMIT = 60; // Max requests allowed
    private const TIME_WINDOW = 60; // Time window in seconds

    public static function handle(int $limit = self::LIMIT, int $timeWindow = self::TIME_WINDOW) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $key = "throttle_$ip";

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = ['count' => 0, 'time' => time()];
        }

        // Reset the counter if time window has passed
        if (time() - $_SESSION[$key]['time'] > $timeWindow) {
            $_SESSION[$key] = ['count' => 0, 'time' => time()];
        }

        $_SESSION[$key]['count']++;

        if ($_SESSION[$key]['count'] > $limit) {
            header('HTTP/1.1 429 Too Many Requests');
            header('Content-Type: application/json');
            echo json_encode([
                'error' => 'Too Many Requests',
                'message' => "You have exceeded the limit of $limit requests per $timeWindow seconds.",
                'retry_after' => $timeWindow - (time() - $_SESSION[$key]['time'])
            ]);
            exit;
        }
    }
}
