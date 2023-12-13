<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Helpers\TDCommentFormatter;
use App\Helpers\TDUrlFormatter;
use App\Models\DocumentFactory;
use App\Models\TDSearchProvider;
use DiDom\Document;
use Tests\TestCase;

class TDSearchProviderTest extends TestCase
{
    /**
     * @group ok
     * @dataProvider dataProvider
     */
    public function testSuccessfulSearchComments(string $phone, array $expectedComments)
    {
        $urlFormatter = new TDUrlFormatter();

        $url = $urlFormatter->format($phone);

        $path = __DIR__ . "/../data/td-$phone.html";
        $document = new Document($path, true);

        $documentFactory = $this->createMock(DocumentFactory::class);
        $documentFactory
            ->method('create')
            ->with($this->equalTo($url))
            ->willReturn($document);

        $searchProvider = new TDSearchProvider(
            $documentFactory,
            new TDCommentFormatter(),
            $urlFormatter
        );

        $comments = $searchProvider->getComments($phone);

        $this->assertIsArray($comments);
        $this->assertCount(count($expectedComments), $comments);

        foreach ($expectedComments as $key => $value)
            $this->assertEquals($value, $comments[$key]);
    }

    public static function dataProvider(): array
    {
        return [
            [
                '0443630074',
                [
                    '"В ведений пароль не вірний" и так по кругу',
                    'Взяв слухавку, відразу дзвінок прирвався.',
                    'Воля кабель',
                    'дзвонять і скидають',
                ]
            ],
            [
                '380730310246',
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
