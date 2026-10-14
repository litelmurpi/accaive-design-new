<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Project;
use App\Filament\Resources\ProjectResource;
use Filament\Forms\Form;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectDropdownOptionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_year_dropdown_keys_are_actual_years_not_indices()
    {
        Project::create([
            'title' => 'Project 2024',
            'slug' => 'project-2024',
            'category' => 'Residential',
            'year' => '2024',
        ]);

        $project = new Project();
        $form = ProjectResource::form(new Form(new \Filament\Pages\Dashboard()));
        $components = $form->getFlatFields();

        $this->assertArrayHasKey('year', $components);
        $yearField = $components['year'];
        $options = $yearField->getOptions();

        // Ensure options keys are 4-digit years (e.g. 2024 => 2024), NOT 0-based indices
        $this->assertArrayHasKey('2024', $options, 'Option key 2024 should exist as key');
        $this->assertEquals('2024', $options['2024']);
        $this->assertArrayNotHasKey(0, $options, 'Numeric index 0 should NOT be a key');
        $this->assertArrayNotHasKey(4, $options, 'Numeric index 4 should NOT be a key');
    }

    public function test_category_dropdown_keys_are_preserved()
    {
        Project::create([
            'title' => 'Project Custom',
            'slug' => 'project-custom',
            'category' => 'Pavilion 123',
        ]);

        $form = ProjectResource::form(new Form(new \Filament\Pages\Dashboard()));
        $components = $form->getFlatFields();

        $categoryField = $components['category'];
        $options = $categoryField->getOptions();

        $this->assertArrayHasKey('Residential', $options);
        $this->assertArrayHasKey('Pavilion 123', $options);
    }
}
