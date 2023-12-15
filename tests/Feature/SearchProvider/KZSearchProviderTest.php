<?php

declare(strict_types=1);

namespace Tests\Feature\SearchProvider;

use App\Helpers\CommentFormatters\KZCommentFormatter;
use App\Helpers\UrlFormatter\KZUrlFormatter;
use App\Models\DocumentFactory;
use App\Models\SearchProviders\KZSearchProvider;
use DiDom\Document;
use Tests\TestCase;

class KZSearchProviderTest extends TestCase
{
    /**
     * @group ok
     * @dataProvider dataProvider
     */
    public function testSuccessfulSearchComments(string $phone, array $expectedComments)
    {
        $urlFormatter = $this->app->make(KZUrlFormatter::class);
        $commentFormatter = $this->app->make(KZCommentFormatter::class);

        $url = $urlFormatter->format($phone);

        $path = __DIR__ . "/../data/kz-$phone.html";
        $document = new Document($path, true);

        $documentFactory = $this->createMock(DocumentFactory::class);
        $documentFactory
            ->method('create')
            ->with($this->equalTo($url))
            ->willReturn($document);

        $searchProvider = new KZSearchProvider(
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
                '730909161',
                [
                    'Мовчать...',
                    'Позвонили я ничего не говорила , и сразу же сбросили',
                    'на лінії тишина',
                    'Звонят и молчат',
                    'позвонили, услышали голос и сразу сбросили.',
                ]
            ],
            [
                '661230947',
                [
                    'Шахраї !  Не беріть з цього номеру. Краще в спам одразу ж відправляти !',
                ]
            ],
        ];
    }

}
