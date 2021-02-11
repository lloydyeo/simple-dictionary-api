<?php

namespace Tests\Feature;

use App\Models\Dictionary;
use App\Models\DictionarySnapshot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DictionaryTest extends TestCase
{
    /**
     * Test for single entry creation
     *
     * @return void
     */
    public function testSingleEntryUpsert()
    {
        $operations = [];
        $operations[] = [ 'key' => 'mykey', 'result' => 'created' ];

        $this->postJson('api/dictionary', [ 'mykey' => 'value1' ])
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'operations' => $operations,
            ]);
    }

    /**
     * Test for single entry updated
     *
     * @return void
     */
    public function testSingleEntryUpsertUpdated()
    {
        $operations = [];
        $operations[] = [ 'key' => 'mykey1', 'result' => 'updated' ];

        $this->postJson('api/dictionary', [ 'mykey1' => 'value1' ]);

        $this->postJson('api/dictionary', [ 'mykey1' => 'another_value' ])
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'operations' => $operations,
            ]);
    }

    /**
     * Test for single entry unchanged
     *
     * @return void
     */
    public function testSingleEntryUpsertUnchanged()
    {
        $operations = [];
        $operations[] = [ 'key' => 'mykey1', 'result' => 'unchanged' ];

        $this->postJson('api/dictionary', [ 'mykey1' => 'value1' ]);

        $this->postJson('api/dictionary', [ 'mykey1' => 'value1' ])
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'operations' => $operations,
            ]);
    }


    /**
     * Test for multiple entry creation
     *
     * @return void
     */
    public function testMultipleEntryUpsert()
    {
        $operations = [];
        $operations[] = [ 'key' => 'mykey1', 'result' => 'created' ];
        $operations[] = [ 'key' => 'mykey2', 'result' => 'created' ];

        $this->postJson('api/dictionary', [ 'mykey1' => 'value1', 'mykey2' => 'value1' ])
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'operations' => $operations,
            ]);
    }

    /**
     * Test for multiple entry updated
     *
     * @return void
     */
    public function testMultipleEntryUpsertUpdated()
    {
        $operations = [];
        $operations[] = [ 'key' => 'mykey1', 'result' => 'updated' ];
        $operations[] = [ 'key' => 'mykey2', 'result' => 'updated' ];

        $this->postJson('api/dictionary', [ 'mykey1' => 'value1', 'mykey2' => 'value1' ]);

        $this->postJson('api/dictionary', [ 'mykey1' => 'another_value', 'mykey2' => 'another_value' ])
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'operations' => $operations,
            ]);
    }

    /**
     * Test for multiple entry unchanged
     *
     * @return void
     */
    public function testMultipleEntryUpsertUnchanged()
    {
        $operations = [];
        $operations[] = [ 'key' => 'mykey1', 'result' => 'unchanged' ];
        $operations[] = [ 'key' => 'mykey2', 'result' => 'unchanged' ];

        $this->postJson('api/dictionary', [ 'mykey1' => 'value1', 'mykey2' => 'value1' ]);
        $this->postJson('api/dictionary', [ 'mykey1' => 'value1', 'mykey2' => 'value1' ])
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'operations' => $operations,
            ]);
    }

    /**
     * Test get entry
     *
     * @return void
     */
    public function testGetEntryWithoutTimestamp()
    {
        $operations = [];
        $operations[] = [ 'key' => 'mykey1', 'result' => 'created' ];

        $this->postJson('api/dictionary', [ 'mykey1' => 'value1' ]);

        $this->get('api/dictionary/mykey1')
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'value' => 'value1'
            ]);
    }

    /**
     * Test get entry
     *
     * @return void
     */
    public function testGetEntryUpdatedValueWithoutTimestamp()
    {
        $operations = [];
        $operations[] = [ 'key' => 'mykey1', 'result' => 'created' ];

        $this->postJson('api/dictionary', [ 'mykey1' => 'value1' ]);

        $this->get('api/dictionary/mykey1')
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'value' => 'value1'
            ]);

        $this->postJson('api/dictionary', [ 'mykey1' => 'value2' ]);

        $this->get('api/dictionary/mykey1')
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'value' => 'value2'
            ]);
    }

    /**
     * Test get entry with timestamp
     *
     * @return void
     */
    public function testGetEntryWithTimestamp()
    {
        $this->postJson('api/dictionary', [ 'mykey1' => 'value1' ]);
        $time_inserted = time();
        sleep(1);
        $this->postJson('api/dictionary', [ 'mykey1' => 'value2' ]);
        $this->get('api/dictionary/mykey1?timestamp=' . $time_inserted)
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'value' => 'value1'
            ]);
    }

}
