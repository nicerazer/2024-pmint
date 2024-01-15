<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

final class FileUploadControllerTest extends TestCase
{
   protected function setUp(): void
    {
        parent::setUp();

        // Use a fake storage driver so we don't store files on the real disk.
        Storage::fake();

        // Freeze time and define how `Str::random` should work. This allows us
        // to explicitly check that the file is stored in the correct location
        // and is being named correctly.
        $this->freezeTime();
        Str::createRandomStringsUsing(static fn (): string => 'random-string');
    }

    /** @test */
    public function file_can_be_temporarily_uploaded_for_a_single_file_field(): void
    {
        $file = UploadedFile::fake()->image('avatar.png');

        $expectedFilePath = 'tmp/'.now()->timestamp.'-random-string';

        $this->post(route('uploads.process'), [
            'avatar' => $file,
        ])
            ->assertOk()
            ->assertSee($expectedFilePath);

        Storage::assertExists($expectedFilePath);
    }

    /** @test */
    public function file_can_be_temporarily_uploaded_for_a_multiple_file_field(): void
    {
        $file = UploadedFile::fake()->image('avatar.png');

        $expectedFilePath = 'tmp/'.now()->timestamp.'-random-string';

        $this->post(route('uploads.process'), [
            'avatar' => [
                $file
            ],
        ])
            ->assertOk()
            ->assertSee($expectedFilePath);

        Storage::assertExists($expectedFilePath);
    }

    /** @test */
    public function error_is_returned_if_no_file_is_passed_in_the_request(): void
    {
        $this->post(route('uploads.process'))
            ->assertStatus(422);
    }

    /** @test */
    public function error_is_returned_if_more_than_one_file_is_passed_in_the_request(): void
    {
        $file = UploadedFile::fake()->image('avatar.png');

        $this->post(route('uploads.process'), [
            'avatar' => $file,
            'invalid' => $file,
        ])
            ->assertStatus(422);
    }
}
