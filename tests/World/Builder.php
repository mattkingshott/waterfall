<?php declare(strict_types = 1);

namespace Waterfall\Tests\World;

use Illuminate\Support\Facades\DB;

class Builder
{
    /**
     * Construct the world.
     *
     */
    public static function create() : void
    {
        static::configuration();

        @unlink(__DIR__ . '/database.sqlite');
        touch(__DIR__ . '/database.sqlite');
    }

    /**
     * Apply the configuration settings.
     *
     */
    protected static function configuration() : void
    {
        $database = [
            'driver'   => 'sqlite',
            'database' => __DIR__ . '/database.sqlite',
        ];

        $queue = [
            'driver'       => 'database',
            'table'        => 'jobs',
            'queue'        => 'default',
            'retry_after'  => 90,
            'after_commit' => false,
        ];

        app('config')->set('database.default', 'sqlite');
        app('config')->set('database.migrations', 'migrations');
        app('config')->set('database.connections.sqlite', $database);

        app('config')->set('queue.default', 'sync');
        app('config')->set('queue.connections.database', $queue);
        app('config')->set('queue.connections.sync', ['driver' => 'sync']);
    }

    /**
     * Destroy the world.
     *
     */
    public static function destroy() : void
    {
        @unlink(__DIR__ . '/database.sqlite');
    }

    /**
     * Seed the database.
     *
     */
    public static function seed() : void
    {
        DB::table('users')->truncate();
        DB::table('posts')->truncate();

        DB::table('users')->insert(['id' => 1, 'name' => 'John Doe']);
        DB::table('users')->insert(['id' => 2, 'name' => 'Jane Doe']);

        DB::table('posts')->insert(['id' => 1, 'user_id' => 1, 'title' => 'Lorem ipsum']);
        DB::table('posts')->insert(['id' => 2, 'user_id' => 1, 'title' => 'Dolor sit']);
        DB::table('posts')->insert(['id' => 3, 'user_id' => 1, 'title' => 'Amet consectetur']);
        DB::table('posts')->insert(['id' => 4, 'user_id' => 1, 'title' => 'Adipiscing elit']);
        DB::table('posts')->insert(['id' => 5, 'user_id' => 2, 'title' => 'Sed do']);
        DB::table('posts')->insert(['id' => 6, 'user_id' => 2, 'title' => 'Eiusmod tempor']);
        DB::table('posts')->insert(['id' => 7, 'user_id' => 2, 'title' => 'Incididunt ut']);
        DB::table('posts')->insert(['id' => 8, 'user_id' => 2, 'title' => 'Labore et']);
    }
}
