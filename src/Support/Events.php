<?php

namespace Teardrops\Teardrops\Support;

class Events
{
    protected static array $listeners = [];

    /**
     * Register an event listener for a specific event.
     *
     * @param string $event
     * @param callable $callback
     */
    public static function register(string $event, callable $callback): void
    {
        if (! isset(self::$listeners[$event])) {
            self::$listeners[$event] = [];
        }

        self::$listeners[$event][] = $callback;
    }

    /**
     * Dispatch an event to all registered listeners.
     *
     * @param string $event
     * @param array $payload
     */
    public static function dispatch(string $event, array $payload = []): void
    {
        if (! isset(self::$listeners[$event])) {
            return;
        }

        foreach (self::$listeners[$event] as $callback) {
            call_user_func($callback, $payload);
        }
    }
}
