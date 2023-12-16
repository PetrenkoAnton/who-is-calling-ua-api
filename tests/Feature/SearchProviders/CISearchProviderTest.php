<?php

declare(strict_types=1);

namespace Tests\Feature\SearchProviders;

use App\Core\CommentHandlers\CICommentHandler;
use App\Core\DocumentFactory;
use App\Core\Formatters\UrlFormatters\CIUrlFormatter;
use App\Core\SearchProviders\CISearchProvider;
use DiDom\Document;
use Tests\TestCase;

class CISearchProviderTest extends TestCase
{
    /**
     * @group ok
     * @dataProvider dataProvider
     */
    public function testSuccessfulSearchComments(string $phone, array $expectedComments)
    {
        $urlFormatter = $this->app->make(CIUrlFormatter::class);
        $commentFormatter = $this->app->make(CICommentHandler::class);

        $url = $urlFormatter->format($phone);

        $path = __DIR__ . "/../data/ci-$phone.html";
        $document = new Document($path, true);

        $documentFactory = $this->createMock(DocumentFactory::class);
        $documentFactory
            ->method('create')
            ->with($this->equalTo($url))
            ->willReturn($document);

        $searchProvider = new CISearchProvider(
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
                '962162161',
                [
                    'Аферисты, заказ не сдали. Трубку не берут',
                    'Аферисты и жулики мебельные',
                    'Нибра столешницы и подоконники, столы. Аферисты и жулики',
                    'Этот номер 0962162161 Пренадлежит мебельным мошенникам НИБРА! Которые берут заказы и пропадают! На них уже возбужденно уголовное дело! ОНи берут предоплаты и пропадают. Находятся якобы на канальной 1. Но там ничего нет! Там стройка и все! Будьте осторожны! Их сайт nibra.com.ua',
                    'Аферисты по деревянной мебели нибра. Будьте внимательны',
                ]
            ],
            [
                '959387927',
                [
                    'дуже брудно, не працюють крісла, падають на голову тримачі від фіранок, на зауваження ні водії ні диспетчера цієї контори не реагують, якщо є бажання зіпсувати собі поїздку, кращого перевізника не знайти',
                    'На території України перевізник без попередження зупинився на 3 години (!), щоб зробити пересадку пасажирів з інших рейсів, вночі. При цьому, на сайті про такий маршрут не зазначалось.',
                    'По их вине опоздал на автобус обратно с Харькова(билет купил у них же),в итоге игнор,деньги не хотят возвращать,водитель 2 раза чуть не вылетел с трассы из-за того что он втыкал в мобильник,курил в салоне,и я просил высадить меня в положенном месте,он же провез меня через весь город и высадил в ебенях.Короче поездка ужасная,не кому не советую эту компашку',
                    '20.09.2023 замовляв квиток до Києва на 05.10.2023. За дві доби до відправлення автобуса, тобто 03.10.2023 прийшло смс-повідомлення, що рейс відмінили, повернення коштів оформлено, однак до цих пір кошти не повернуто. Шахраї одним словом.',
                    'Могу сказать что это самая худшая компания по перевозкам, непонятные пересадки(которые никак не обговаривались и в билете не было), опоздали на 5 часов к месту прибытия, надеюсь кто-то займётся этой компанией и ее закроют что бы они больше не обманывали люди, потому что за такие деньги это чистой воды обман. И ещё, практически на 100 процентов уверен что хорошие отзывы просто накручены, так как никакой здравый в уме человек не поставит этим аферистам больше 2-ух звёзд. ЛЮДИ, НЕ БЕРИТЕ НИ В КОЕМ СЛУЧАЕ БИЛЕТЫ У ЭТИХ ЛЮДЕЙ, ДАЖЕ ЕСЛИ НЕТ ДРУГОГО ВЫХОДА!!!',
                ]
            ],
        ];
    }

}
