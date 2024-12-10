<?php

namespace App\Models;

use DateTimeInterface;
use Filament\Models\Contracts\FilamentUser;
use Filament\Tables\Columns\Layout\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\MediaCollections\HtmlableMedia;
use Spatie\MediaLibrary\ResponsiveImages\RegisteredResponsiveImages;
use Spatie\MediaLibrary\Support\UrlGenerator\UrlGeneratorFactory;

class Media extends \Spatie\MediaLibrary\MediaCollections\Models\Media implements FilamentUser
{
    public function canAccessPanel(Panel|\Filament\Panel $panel): bool
    {
        return true;
    }

    public function getUrl(string $conversionName = ''): string
    {
        return  $this->getTemporaryUrl(now()->addDays(4), $conversionName);
    }

    public function getTemporaryUrl(DateTimeInterface $expiration, string $conversionName = '', array $options = []): string
    {
        return Cache::remember("media_$this->uuid\_$conversionName\_url", $expiration, function () use ($expiration, $conversionName, $options) {
            return UrlGeneratorFactory::createForMedia($this, $conversionName)->getTemporaryUrl($expiration, $options);
        });
    }

    public function getTemporarySrcset(DateTimeInterface $expiration, string $conversionName = ''): string
    {
        return Cache::remember("media_$this->uuid\_$conversionName\_srcset", $expiration, function () use ($expiration, $conversionName) {
            return $this->responsiveImages($conversionName)->getSrcset($expiration);
        });
    }

    public function responsiveImages(string $conversionName = ''): RegisteredResponsiveImages
    {
        return new RegisteredResponsiveImages($this, $conversionName);
    }

    public function img(string $conversionName = '', $extraAttributes = []): HtmlableMedia
    {
        return (new HtmlableMedia($this))
            ->conversion($conversionName)
            ->attributes($extraAttributes);
    }

    public function __invoke(...$arguments): HtmlableMedia
    {
        return $this->img(...$arguments);
    }
}
