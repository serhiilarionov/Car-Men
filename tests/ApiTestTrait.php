<?php namespace Tests;

trait ApiTestTrait
{
    public function assertApiResponse(Array $actualData)
    {
        $this->assertApiSuccess();
        $response = json_decode($this->response->getContent(), true);
        $responseData = $response['data'];
        $this->assertNotEmpty($responseData['id']);
        $this->assertModelData($actualData, $responseData);
    }

    public function assertApiSuccess()
    {
        $this->assertResponseOk();
        $this->seeJson(['success' => true]);
    }

    public function assertModelData(Array $actualData, Array $expectedData)
    {
        foreach ($actualData as $key => $value) {
            $this->assertEquals($actualData[$key], $expectedData[$key]);
        }
    }
    
    public function assertApiCheckLenght(Array $actualData)
    {
        $this->assertApiSuccess();
        $response = json_decode($this->response->getContent(), true);
        $responseData = $response['data'];
        $this->assertEquals(count($actualData), count($responseData));
    }
    
    public function assertApiCheckLenghtWithPaginate(Array $actualData)
    {
        $this->assertApiSuccess();
        $response = json_decode($this->response->getContent(), true);
        $responseData = $response['meta']['pagination']['total'];
        $this->assertEquals(count($actualData), $responseData);
    }
    
    public function assertApiPopularCompaniesByCity(Array $actualData)
    {
        $this->assertApiSuccess();
        $response = json_decode($this->response->getContent(), true);     
        $this->assertModelData($actualData[0], $response['data'][0]);
    }
}