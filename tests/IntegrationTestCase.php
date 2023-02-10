<?php

namespace Tests;

use App\BoundedContext\Backoffice\Dashboard\Model\Entities\DashboardStats;
use App\BoundedContext\Backoffice\Settings\Model\Entities\SettingsSetting;
use Illuminate\Support\Facades\DB;
use Tests\fixtures\DefaultFixture;

abstract class IntegrationTestCase extends TestCase
{

    /**
     * @var DefaultFixture
     */
    private $defaultFixture;

    public function setUp(): void
    {
        parent::setUp();
        // load default fixture
        $this->defaultFixture = new DefaultFixture();
        $this->defaultFixture->execute();
    }

    public function tearDown(): void
    {
        // restore default fixture
        $this->defaultFixture->execute();
        parent::tearDown();
    }
}
