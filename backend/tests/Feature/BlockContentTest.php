<?php

namespace Tests\Feature;

use App\Support\BlockContent;
use App\Support\BlockSchema;
use Tests\TestCase;

class BlockContentTest extends TestCase
{
    public function test_resolves_locale_map_to_current_language(): void
    {
        $blocks = [
            ['type' => 'hero', 'data' => [
                'title' => ['sr' => 'Otkrijte Teslić', 'en' => 'Discover Teslić'],
                'variant' => 'split',
            ]],
        ];

        $sr = BlockContent::resolve($blocks, 'sr');
        $en = BlockContent::resolve($blocks, 'en');

        $this->assertSame('Otkrijte Teslić', $sr[0]['data']['title']);
        $this->assertSame('Discover Teslić', $en[0]['data']['title']);
        $this->assertSame('split', $sr[0]['data']['variant']);
    }

    public function test_falls_back_to_sr_when_language_missing(): void
    {
        $blocks = [
            ['type' => 'hero', 'data' => ['title' => ['sr' => 'Naslov']]],
        ];

        $de = BlockContent::resolve($blocks, 'de');

        $this->assertSame('Naslov', $de[0]['data']['title']);
    }

    public function test_does_not_treat_data_object_as_locale_map(): void
    {
        $blocks = [
            ['type' => 'hero', 'data' => [
                'title' => ['sr' => 'Naslov'],
                'kicker' => ['sr' => 'Dobrodošli'],
                'variant' => 'split',
            ]],
        ];

        $resolved = BlockContent::resolve($blocks, 'sr');

        $this->assertIsArray($resolved[0]['data']);
        $this->assertSame('Naslov', $resolved[0]['data']['title']);
        $this->assertSame('Dobrodošli', $resolved[0]['data']['kicker']);
    }

    public function test_resolves_nested_repeater_items(): void
    {
        $blocks = [
            ['type' => 'faq', 'data' => [
                'items' => [
                    ['q' => ['sr' => 'Pitanje?', 'en' => 'Question?'], 'a' => ['sr' => 'Odgovor']],
                ],
            ]],
        ];

        $en = BlockContent::resolve($blocks, 'en');

        $this->assertSame('Question?', $en[0]['data']['items'][0]['q']);
        $this->assertSame('Odgovor', $en[0]['data']['items'][0]['a']);
    }

    public function test_wrap_block_converts_translatable_fields_to_locale_maps(): void
    {
        $block = ['type' => 'hero', 'data' => [
            'title' => 'Otkrijte Teslić',
            'variant' => 'split',
        ]];

        $wrapped = BlockSchema::wrapBlock($block);

        $this->assertSame(['sr' => 'Otkrijte Teslić'], $wrapped['data']['title']);
        $this->assertSame('split', $wrapped['data']['variant']);
    }

    public function test_wrap_block_handles_repeater_translatable_subfields(): void
    {
        $block = ['type' => 'faq', 'data' => [
            'items' => [
                ['q' => 'Pitanje?', 'a' => 'Odgovor'],
            ],
        ]];

        $wrapped = BlockSchema::wrapBlock($block);

        $this->assertSame(['sr' => 'Pitanje?'], $wrapped['data']['items'][0]['q']);
        $this->assertSame(['sr' => 'Odgovor'], $wrapped['data']['items'][0]['a']);
    }
}
