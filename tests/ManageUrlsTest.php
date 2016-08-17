<?php

class ManageUrlsTest extends TestCase
{
    /**
     * Test the Manage Url page
     *
     * @return void
     */
    public function testCanViewManageUrlPage()
    {
        $this->visit('/manage-url')
            ->assertResponseOk()
            ->seePageIs('/manage-url')
            ->see('Manage URLs')
            ->see("This form let's you shorten a new url, or update an existing one.")
            ->seeElement('input', [
                'id'    => 'url',
                'type'  => 'text',
                'class' => 'form-control',
            ])
            ->seeElement('input', [
                'type'  => 'submit',
                'class' => 'btn btn-primary',
                'value' => 'Save'
            ])
            ->see('URL to shorten');
    }

    public function testCanSaveUrl()
    {
        $this->visit('/manage-url')
            ->submitForm('Save', [
                'url' => 'http://www.abc.net.au'
            ])
            ->seePageIs('/manage-url')
            ->assertResponseOk();
    }

    /**
     * @dataProvider invalidUrlDataProvider
     */
    public function testUrlMustHaveCorrectFormat($url)
    {
        $this->visit('/manage-url')
            ->submitForm('Save', [
                'url' => $url
            ])
            ->seePageIs('/manage-url')
            ->assertResponseOk()
            ->see('The url format is invalid');
    }

    public function invalidUrlDataProvider()
    {
        return [
            [
                '1.2.3'
            ],
            [
                'www.example.com'
            ],
        ];
    }
}
