<?php
declare(strict_types=1);

namespace Genkgo\Mail\Unit\Mime;

use Genkgo\Mail\AbstractTestCase;
use Genkgo\Mail\Header\ContentType;
use Genkgo\Mail\Mime\PlainTextPart;
use Genkgo\Mail\Stream\BitEncodedStream;
use Genkgo\Mail\Stream\OptimalTransferEncodedTextStream;

final class PlainTextPartTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function it_is_immutable()
    {
        $part = new PlainTextPart('<html></html>');

        $this->assertNotSame($part, $part->withHeader(new ContentType('text/html')));
        $this->assertNotSame($part, $part->withoutHeader('content/type'));
    }

    /**
     * @test
     */
    public function it_cannot_modify_body()
    {
        $this->expectException(\RuntimeException::class);

        $part = new PlainTextPart('<html></html>');
        $part->withBody(new BitEncodedStream('body'));
    }

    /**
     * @test
     */
    public function it_has_header_content_type()
    {
        $part = new PlainTextPart('<html></html>');

        $this->assertTrue($part->hasHeader('content-type'));
        $this->assertEquals(
            'text/plain; charset="UTF-8"',
            (string)$part->getHeader('content-type')->getValue()
        );
        $this->assertArrayHasKey('content-type', $part->getHeaders());
    }

    /**
     * @test
     */
    public function it_picks_optimal_encoding()
    {
        $part = new PlainTextPart('<html></html>');

        $this->assertInstanceOf(OptimalTransferEncodedTextStream::class, $part->getBody());
    }
}