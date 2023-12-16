<?php

declare(strict_types=1);

namespace Tests\Feature\Providers;

use App\Core\Parsers\TDParser;
use App\Core\DocumentFactory;
use App\Core\Formatters\UrlFormatters\TDUrlFormatter;
use App\Core\Providers\TDProvider;
use DiDom\Document;
use Tests\TestCase;

class TDProviderTest extends TestCase
{
    /**
     * @group ok
     * @dataProvider dp
     */
    public function testSuccessfulParseComments(string $phone, array $expectedComments)
    {
        $urlFormatter = $this->app->make(TDUrlFormatter::class);
        $commentFormatter = $this->app->make(TDParser::class);

        $url = $urlFormatter->format($phone);

        $path = __DIR__ . "/../data/td-$phone.html";
        $document = new Document($path, true);

        $documentFactory = $this->createMock(DocumentFactory::class);
        $documentFactory
            ->method('create')
            ->with($this->equalTo($url))
            ->willReturn($document);

        $searchProvider = new TDProvider(
            $documentFactory,
            $commentFormatter,
            $urlFormatter
        );

        $comments = $searchProvider->getComments($phone);

        $this->assertIsArray($comments);
        $this->assertCount(count($expectedComments), $comments);

        foreach ($expectedComments as $key => $value)
            $this->assertEquals($value, $comments[$key]);
    }

    public static function dp(): array
    {
        return [
            [
                '443630074',
                [
                    '"В ведений пароль не вірний" и так по кругу',
                    'Взяв слухавку, відразу дзвінок прирвався.',
                    'Воля кабель',
                    'дзвонять і скидають',
                ]
            ],
            [
                '730310246',
                [
                    'Englishdom',
                    'школа англійської Englishdom',
                    'Дзвонять з якоїсь школи англійської',
                    'Телефонували один раз, слухавку з невідомих номерів не беру',
                ]
            ],
        ];
    }

}
