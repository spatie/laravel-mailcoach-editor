<?php

namespace Spatie\MailcoachEditor\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Upload extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $table = 'mailcoach_uploads';

    public $guarded = [];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('image')
            ->keepOriginalImageFormat()
            ->fit(
                Manipulations::FIT_MAX,
                config('mailcoach.editor.max_width', 1500),
                config('mailcoach.editor.max_height', 1500)
            )
            ->nonQueued();
    }
}
