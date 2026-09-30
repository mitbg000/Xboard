<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    public function test_database_can_run_a_simple_query(): void
    {
        $result = DB::selectOne('SELECT 1 AS ok');

        $this->assertNotNull($result);
        $this->assertEquals(1, (int) $result->ok);
    }
}
