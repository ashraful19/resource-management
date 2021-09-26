<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ManagementControllerTest extends TestCase
{
    /**
     * index method test
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->getJson(route('resources.index'));
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Resources Loaded.'
        ]);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->whereType('data.resources', 'array')->etc());
    }

    /**
     * store method validation test
     *
     * @return void
     */
    public function test_store_validation()
    {
        $response = $this->postJson(route('resources.store'));
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'The given data was invalid.'
        ]);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->whereType('error', 'array')->etc());
    }

    /**
     * store method test for pdf
     *
     * @return void
     */
    public function test_pdf_store_show_update_delete()
    {
        //Store method
        $title = $this->faker->sentence;
        $fileRaw = UploadedFile::fake()->create('test.pdf', 100);
        // dd($fileRaw);
        $storeResponse = $this->postJson(route('resources.store'), [
            'title' => $title,
            'type' => 'pdf',
            'pdf' => [
                'fileRaw' => $fileRaw
            ]
        ]);
        $storeResponse->assertCreated();
        $storeResponse->assertJson([
            'success' => true,
            'message' => 'Resource Created.'
        ]);
        $storeResponse->assertJson(fn (AssertableJson $json) =>
        $json->has('data.resource')
            ->has('data.resource.pdf')
            ->whereAllType([
                'data' => 'array',
                'data.resource.id' => 'integer',
            ])
            ->where('data.resource.title', $title)
            ->where('data.resource.type', 'pdf')
            ->whereType('data.resource.pdf.file', 'string')
            ->etc());

        //Show method
        $showResponse = $this->getJson(route('resources.show', $storeResponse->getData()->data->resource->id));
        $showResponse->assertOk();
        $showResponse->assertJson([
            'success' => true,
            'message' => 'Resource Loaded.'
        ]);
        $showResponse->assertJson(fn (AssertableJson $json) =>
            $json->has('data.resource')
                ->where('data.resource', $storeResponse->getData(true)['data']['resource'])
                ->etc()
        );

        //Update method
        $editedTitle = $this->faker->sentence;
        $editFileRaw = UploadedFile::fake()->create('test.pdf');
        $updateResponse = $this->putJson(route('resources.update', $storeResponse->getData()->data->resource->id), [
            'title' => $editedTitle,
            'pdf' => [
                'file' => $storeResponse->getData()->data->resource->pdf->file,
                'fileRaw' => $editFileRaw
            ]
        ]);
        $updateResponse->assertSuccessful();
        $updateResponse->assertJson([
            'success' => true,
            'message' => 'Resource Updated.'
        ]);
        $updateResponse->assertJson(fn (AssertableJson $json) =>
            $json->has('data.resource')
                ->has('data.resource.pdf')
                ->where('data.resource.title', $editedTitle)
                ->whereType('data.resource.pdf.file', 'string')
                ->etc()
        );

        //Delete Method
        $deleteResponse = $this->deleteJson(route('resources.destroy', $storeResponse->getData()->data->resource->id));
        $deleteResponse->assertOk();
        $deleteResponse->assertJson([
            'success' => true,
            'message' => 'Resource Deleted.'
        ]);
    }

    /**
     * store method test for link
     *
     * @return void
     */
    public function test_link_store_show_update_delete()
    {
        $title = $this->faker->sentence;
        $url = $this->faker->url;
        $storeResponse = $this->postJson(route('resources.store'), [
            'title' => $title,
            'type' => 'link',
            'link' => [
                'url' => $url,
                'new_tab' => 1
            ]
        ]);
        $storeResponse->assertCreated();
        $storeResponse->assertJson([
            'success' => true,
            'message' => 'Resource Created.'
        ]);
        $storeResponse->assertJson(fn (AssertableJson $json) =>
        $json->has('data.resource')
            ->has('data.resource.link')
            ->whereAllType([
                'data' => 'array',
                'data.resource.id' => 'integer',
            ])
            ->where('data.resource.title', $title)
            ->where('data.resource.type', 'link')
            ->where('data.resource.link.url', $url)
            ->where('data.resource.link.new_tab', 1)
            ->etc());

        //Show method
        $showResponse = $this->getJson(route('resources.show', $storeResponse->getData()->data->resource->id));
        $showResponse->assertOk();
        $showResponse->assertJson([
            'success' => true,
            'message' => 'Resource Loaded.'
        ]);
        $showResponse->assertJson(fn (AssertableJson $json) =>
            $json->has('data.resource')
                ->where('data.resource', $storeResponse->getData(true)['data']['resource'])
                ->etc()
        );

        //Update method
        $editedTitle = $this->faker->sentence;
        $editedUrl = $this->faker->url;
        $updateResponse = $this->putJson(route('resources.update', $storeResponse->getData()->data->resource->id), [
            'title' => $editedTitle,
            'link' => [
                'url' => $editedUrl,
                'new_tab' => 0
            ]
        ]);
        $updateResponse->assertSuccessful();
        $updateResponse->assertJson([
            'success' => true,
            'message' => 'Resource Updated.'
        ]);
        $updateResponse->assertJson(fn (AssertableJson $json) =>
            $json->has('data.resource')
                ->has('data.resource.link')
                ->where('data.resource.title', $editedTitle)
                ->where('data.resource.link.url', $editedUrl)
                ->where('data.resource.link.new_tab', 0)
                ->etc()
        );

        //Delete Method
        $deleteResponse = $this->deleteJson(route('resources.destroy', $storeResponse->getData()->data->resource->id));
        $deleteResponse->assertOk();
        $deleteResponse->assertJson([
            'success' => true,
            'message' => 'Resource Deleted.'
        ]);
    }

    /**
     * store method test for html
     *
     * @return void
     */
    public function test_html_store_show_update_delete()
    {
        $title = $this->faker->sentence;
        $description = $this->faker->paragraph;
        $snippet = trim($this->faker->randomHtml);
        $storeResponse = $this->postJson(route('resources.store'), [
            'title' => $title,
            'type' => 'html',
            'html' => [
                'description' => $description,
                'snippet' => $snippet
            ]
        ]);
        $storeResponse->assertCreated();
        $storeResponse->assertJson([
            'success' => true,
            'message' => 'Resource Created.'
        ]);
        $storeResponse->assertJson(fn (AssertableJson $json) =>
        $json->has('data.resource')
            ->has('data.resource.html')
            ->whereAllType([
                'data' => 'array',
                'data.resource.id' => 'integer',
            ])
            ->where('data.resource.title', $title)
            ->where('data.resource.type', 'html')
            ->where('data.resource.html.description', $description)
            ->where('data.resource.html.snippet', $snippet)
            ->etc());

        //Show method
        $showResponse = $this->getJson(route('resources.show', $storeResponse->getData()->data->resource->id));
        $showResponse->assertOk();
        $showResponse->assertJson([
            'success' => true,
            'message' => 'Resource Loaded.'
        ]);
        $showResponse->assertJson(fn (AssertableJson $json) =>
            $json->has('data.resource')
                ->where('data.resource', $storeResponse->getData(true)['data']['resource'])
                ->etc()
        );

        //Update method
        $editedTitle = $this->faker->sentence;
        $editedDescription = $this->faker->paragraph;
        $editedSnippet = trim($this->faker->randomHtml);
        $updateResponse = $this->putJson(route('resources.update', $storeResponse->getData()->data->resource->id), [
            'title' => $editedTitle,
            'html' => [
                'description' => $editedDescription,
                'snippet' => $editedSnippet
            ]
        ]);
        $updateResponse->assertSuccessful();
        $updateResponse->assertJson([
            'success' => true,
            'message' => 'Resource Updated.'
        ]);
        $updateResponse->assertJson(fn (AssertableJson $json) =>
            $json->has('data.resource')
                ->has('data.resource.html')
                ->where('data.resource.title', $editedTitle)
                ->where('data.resource.html.description', $editedDescription)
                ->where('data.resource.html.snippet', $editedSnippet)
                ->etc()
        );

        //Delete Method
        $deleteResponse = $this->deleteJson(route('resources.destroy', $storeResponse->getData()->data->resource->id));
        $deleteResponse->assertOk();
        $deleteResponse->assertJson([
            'success' => true,
            'message' => 'Resource Deleted.'
        ]);
    }
    
}
