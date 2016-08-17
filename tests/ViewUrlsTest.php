<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewUrlsTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Laravel 5');
    }

    /**
     * Test the View Urls page
     *
     * @return void
     */
    public function testViewUrlsPage()
    {
        // Load some sample data
        $url = factory(App\Url::class)->create([
            'shortened_url' => 'http://tSQ1r84',
            'original_url' => 'http://www.google.com',
        ]);

        $this->visit('/view-urls')
            ->assertResponseOk()
            ->seePageIs('/view-urls')
            ->see('Manage URLs')
            ->see("This form let's you shorten a new url, or update an existing one.")
            ->see('http://tSQ1r84')
            ->see('http://www.google.com');

        $this->visit('/view-urls')
            ->click('View URLs')
            ->seePageIs('/view-urls');

        $this->visit('/view-urls')
            ->click('Add URL')
            ->seePageIs('/manage-url');
    }
}
