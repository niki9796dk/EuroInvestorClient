<?php


use PHPUnit\Framework\TestCase;
use nez\EuroinvestorClient\EuroinvestorClient;
use nez\EuroinvestorClient\instrumentQuery\InstrumentQueryLine;

class InstrumentQueryTest extends TestCase
{
    /** @test */
    public function it_can_query_for_instruments_by_name(): void
    {
        // Arrange
        $client = new EuroinvestorClient();
        $isin = 'DK0010274414';

        // Act
        $instruments = $client
            ->queryInstrumentsBy("Danske Bank")
            ->whereEquals('isin', $isin);

        // Assert
        $this->assertNotCount(0, $instruments);

        foreach ($instruments as $instrument) {
            $this->assertInstanceOf(InstrumentQueryLine::class, $instrument);
            $this->assertEquals($isin, $instrument->isin);
        }
    }

    /** @test */
    public function it_can_query_for_instruments_by_isin(): void
    {
        // Arrange
        $client = new EuroinvestorClient();
        $isin = 'DK0010274414';
        $name = 'Danske Bank';

        // Act
        $instruments = $client
            ->queryInstrumentsBy($isin)
            ->whereEquals('isin', $isin);

        // Assert
        $this->assertNotCount(0, $instruments);

        foreach ($instruments as $instrument) {
            $this->assertInstanceOf(InstrumentQueryLine::class, $instrument);
            $this->assertEquals($isin, $instrument->isin);
        }
    }

    /** @test */
    public function it_can_get_an_instrument_from_a_query_line(): void
    {
        // Arrange
        $client = new EuroinvestorClient();
        $isin = 'DK0010274414';
        $name = 'Danske Bank';

        // Act
        $instrumentFromQueryLine = $client
            ->queryInstrumentsBy($name)
            ->whereEquals('isin', $isin)
            ->first()
            ->toInstrument();

        $instrumentFromClient = $client->getInstrument($instrumentFromQueryLine->id);

        // Assert
        $this->assertEquals($instrumentFromClient->id, $instrumentFromQueryLine->id);
        $this->assertEquals($instrumentFromClient->name, $instrumentFromQueryLine->name);
        $this->assertEquals($instrumentFromClient->isin, $instrumentFromQueryLine->isin);
    }
}