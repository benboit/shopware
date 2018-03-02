<?php declare(strict_types=1);

namespace Shopware\Api\Locale\Event\Locale;

use Shopware\Api\Locale\Collection\LocaleDetailCollection;
use Shopware\Api\Locale\Event\LocaleTranslation\LocaleTranslationBasicLoadedEvent;
use Shopware\Api\Shop\Event\Shop\ShopBasicLoadedEvent;
use Shopware\Api\User\Event\User\UserBasicLoadedEvent;
use Shopware\Context\Struct\ShopContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;

class LocaleDetailLoadedEvent extends NestedEvent
{
    public const NAME = 'locale.detail.loaded';

    /**
     * @var ShopContext
     */
    protected $context;

    /**
     * @var LocaleDetailCollection
     */
    protected $locales;

    public function __construct(LocaleDetailCollection $locales, ShopContext $context)
    {
        $this->context = $context;
        $this->locales = $locales;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ShopContext
    {
        return $this->context;
    }

    public function getLocales(): LocaleDetailCollection
    {
        return $this->locales;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->locales->getTranslations()->count() > 0) {
            $events[] = new LocaleTranslationBasicLoadedEvent($this->locales->getTranslations(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}