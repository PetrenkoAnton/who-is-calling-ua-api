<?php

declare(strict_types=1);

namespace Tests\Feature\SearchProviders;

use App\Core\CommentHandlers\TDCommentHandler;
use App\Core\DocumentFactory;
use App\Core\Formatters\UrlFormatters\TDUrlFormatter;
use App\Core\SearchProviders\TDSearchProvider;
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
        $urlFormatter = $this->app->make(TDUrlFormatter::class);
        $commentFormatter = $this->app->make(TDCommentHandler::class);

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
            $commentFormatter,
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
