<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Support\ApiHelper;
use Illuminate\Support\Facades\Storage;

class ApiHelperTest extends TestCase
{
    public function test_resolve_media_url_returns_null_for_null_path()
    {
        $this->assertNull(ApiHelper::resolveMediaUrl(null));
        $this->assertNull(ApiHelper::resolveMediaUrl(''));
    }

    public function test_resolve_media_url_returns_http_urls_unchanged()
    {
        $httpUrl = 'http://example.com/images/hero.jpg';
        $httpsUrl = 'https://images.unsplash.com/photo-1600607686527';

        $this->assertEquals($httpUrl, ApiHelper::resolveMediaUrl($httpUrl));
        $this->assertEquals($httpsUrl, ApiHelper::resolveMediaUrl($httpsUrl));
    }

    public function test_resolve_media_url_returns_local_storage_url_when_disk_is_local()
    {
        config(['filesystems.default' => 'local']);

        $result = ApiHelper::resolveMediaUrl('projects/hero/monument.jpg');
        $this->assertNotNull($result);
        $this->assertStringContainsString('storage/projects/hero/monument.jpg', $result);
    }

    public function test_resolve_media_url_returns_s3_url_when_disk_is_s3()
    {
        config(['filesystems.default' => 's3']);
        config(['filesystems.disks.s3.url' => 'https://pub-r2.test.dev']);

        Storage::fake('s3');

        $result = ApiHelper::resolveMediaUrl('projects/hero/monument.jpg');
        $this->assertNotNull($result);
        $this->assertStringContainsString('projects/hero/monument.jpg', $result);
    }
}
