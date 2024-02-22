<?php

declare(strict_types=1);

namespace App\Core\Services;

use App\Core\Collections\CommentsCollection;
use App\Core\Dto\Response\CommentsDetailedDto;
use App\Core\Dto\Response\CommentsDetailedDto\ProviderDtoCollectionFactory;
use App\Core\Dto\Response\CommentsDetailedDto\ProviderDtoFactory;
use App\Core\Dto\Response\CommentsDetailedDtoFactory;
use App\Core\Dto\Response\CommentsDto;
use App\Core\Dto\Response\CommentsDtoFactory;
use App\Core\Formatters\OutputPNFormatter;
use App\Core\Providers\ProviderCollection;
use App\Core\Providers\ProviderInterface;
use Illuminate\Support\Facades\Cache;
use Throwable;

class CommentService
{
    public function __construct(
        private readonly ProviderCollection $searchProviders,
        private readonly OutputPNFormatter $formatter,
        private CommentsCollection $commentsService,
        private readonly CommentsDtoFactory $commentsDtoFactory,
        private readonly CommentsDetailedDtoFactory $commentsDetailedDtoFactory,
        private readonly ProviderDtoCollectionFactory $providerDtoCollectionFactory,
        private readonly ProviderDtoFactory $providerDtoFactory,
    )
    {
    }

    public function search(string $pn, bool $useCache = true): CommentsDto
    {
        if (!$useCache) {
            Cache::delete($pn);
        }

        if ($cache = Cache::has($pn)) {
            $comments = Cache::get($pn);
        } else {
            foreach ($this->searchProviders->getEnabled()->getItems() as $provider) {
                /** @var ProviderInterface $provider */
                try {
                    $this->commentsService->addComments($provider->getComments($pn));
                } catch (Throwable) {
                }
            }

            $comments = $this->getUniqueCommentsArray();

            Cache::set($pn, $comments);
        }

        $data = [
            'pn' => $this->formatter->format($pn),
            'cache' => $cache,
        ] + $comments;

        return $this->commentsDtoFactory->create($data);
    }

    public function detailedSearch(string $pn): CommentsDetailedDto
    {
        Cache::forget($pn);

        $providers = $this->providerDtoCollectionFactory->create();

        foreach ($this->searchProviders->getEnabled()->getItems() as $provider) {
            /** @var ProviderInterface $provider */

            $comments = [];
            $error = null;

            try {
                $this->commentsService->addComments(($comments = $provider->getComments($pn)));
            } catch (Throwable $e) {
                $error = [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ];
            }

            $providers->add($this->providerDtoFactory->create(
                [
                    'name' => $provider->getEnum()->value,
                    'url' => $provider->getUrl($pn),
                    'code' => $provider->getEnum()->name,
                    'comments' => $comments,
                    'error' => $error,
                ]
            ));
        }

        Cache::set($pn, $comments = $this->getUniqueCommentsArray());

        return $this->commentsDetailedDtoFactory->create(
            ['pn' => $this->formatter->format($pn)]
            + $comments
            + ['providers' => $providers],
        );
    }

    private function getUniqueCommentsArray(): array
    {
        return ['comments' => $this->commentsService->getUniqueComments()];
    }
}
