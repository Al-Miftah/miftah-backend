<?php

namespace Tests\Unit;

use Tests\TestCase;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class DonationTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function it_converts_a_currency_amount_to_lower_denomination()
    {
        $amount = 500;
        $converted = money_tolower($amount);
        $this->assertEquals(5.00, $converted);
    }
}
