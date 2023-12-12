<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Helpers\CommentFormatter;
use App\Models\DocumentFactory;
use App\Models\KZSearchProvider;
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
        $url = 'https://ktozvonil.net/nomer/' . $phone;

        $path = __DIR__ . "/../data/kz-$phone.html";
        $document = new Document($path, true);

        $documentFactory = $this->createMock(DocumentFactory::class);
        $documentFactory
            ->method('create')
            ->with($this->equalTo($url))
            ->willReturn($document);

        $searchProvider = new KZSearchProvider($documentFactory, new CommentFormatter());

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
                '0730909161',
                [
                    'Мовчать...',
                    'Позвонили я ничего не говорила , и сразу же сбросили',
                    'на лінії тишина',
                    'Звонят и молчат',
                    'позвонили, услышали голос и сразу сбросили.',
                ]
            ],
            [
                '380661230947',
                [
                    'Шахраї !  Не беріть з цього номеру. Краще в спам одразу ж відправляти !',
                ]
            ],
        ];
    }

}
