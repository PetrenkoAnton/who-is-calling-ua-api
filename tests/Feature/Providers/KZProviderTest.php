<?php

declare(strict_types=1);

namespace Tests\Feature\Providers;

use App\Core\Parsers\KZParser;
use App\Core\DocumentFactory;
use App\Core\Formatters\UrlFormatters\KZUrlFormatter;
use App\Core\Providers\KZProvider;
use DiDom\Document;
use Tests\TestCase;

class KZProviderTest extends TestCase
{
    /**
     * @group ok
     * @dataProvider dp
     */
    public function testSuccessfulParseComments(string $phone, array $expectedComments)
    {
        $urlFormatter = $this->app->make(KZUrlFormatter::class);
        $commentFormatter = $this->app->make(KZParser::class);

        $url = $urlFormatter->format($phone);

        $path = __DIR__ . "/../data/kz-$phone.html";
        $document = new Document($path, true);

        $documentFactory = $this->createMock(DocumentFactory::class);
        $documentFactory
            ->method('create')
            ->with($this->equalTo($url))
            ->willReturn($document);

        $searchProvider = new KZProvider(
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