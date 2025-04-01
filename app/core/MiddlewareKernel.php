<?php
namespace Core;

class MiddlewareKernel {
    /**
     * Pre-registered middleware (static definition)
     * @var array
     */
    protected static $middlewares = [
        'throttle' => [\App\Middleware\ThrottleMiddleware::class, 'handle']
    ];

    /**
     * Add dynamic middleware (optional)
     */
    public static function register(string $name, callable $handler): void {
        self::$middlewares[$name] = $handler;
    }

    /**
     * Execute middleware stack
     */
    public static function handle(array $middlewares): void {
        foreach ($middlewares as $middleware) {
            $handler = self::resolve($middleware);
            if ($handler === null) continue;
            call_user_func($handler);
        }
    }

    /**
     * Resolve middleware with parameters
     */
    protected static function resolve($middleware): ?callable {
        if (is_callable($middleware)) {
            return $middleware;
        }
        $parts = explode(':', $middleware);
        $name = $parts[0];
        $params = isset($parts[1]) ? explode(',', $parts[1]) : [];

        if (!isset(self::$middlewares[$name])) {
            return null;
        }

        $handler = self::$middlewares[$name];

        return empty($params)
            ? $handler
            : fn() => call_user_func_array($handler, $params);
    }

    /**
     * Get all registered middleware (for debugging)
     */
    public static function getMiddleware(): array {
        return self::$middlewares;
    }
}