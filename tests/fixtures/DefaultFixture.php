<?php

namespace Tests\fixtures;

use Illuminate\Support\Facades\DB;

class DefaultFixture
{

    public function execute() {
         DB::table("shorter_url")->truncate();
    }

}
