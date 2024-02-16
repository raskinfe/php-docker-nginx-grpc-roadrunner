<?php

namespace App\Core;

class Request {

    const CONTENT_TYPES = [
        'json' => 'application/json'
    ];

    private string $activeMethod;

    private $requestData = [];

    public function __construct(private array $server) {}

    private function validateMethod(string $method) {
        if (!HttpMethodEnum::exist($method)) { 
            throw new \InvalidArgumentException('Unknown argument');
        }
    }

    public function getMethod(): string {
        return $this->activeMethod;
    }

    public function get(string $key): string|null {
        if (isset($this->requestData[$key])) {
            return $this->requestData[$key];
        }

        return null;
    }

    public function getAll(): array {
        return $this->requestData;
    }

    private function setDataByMethod(): void { 
        switch( $this->activeMethod ) { 
            case HttpMethodEnum::GET->label(): 
                foreach ($_GET as $key => $value) {
                    $this->requestData[$key] = htmlspecialchars($value);
                }
            case HttpMethodEnum::PATCH->label(): 
            case HttpMethodEnum::POST->label(): 
            case HttpMethodEnum::DELETE->label(): 
                foreach ($_POST as $key => $value) {
                    $this->requestData[$key] = htmlspecialchars($value);
                }
        }
    }

    private function setJsonRequest() {
        $data =json_decode(file_get_contents('php://input'), true);
        foreach ($data as $key => $value) {
            $this->requestData[$key] = htmlspecialchars($value);
         }
    }


    public function seRequestData() { 
        if (count($this->server)) {
            $this->validateMethod($this->server['REQUEST_METHOD']);
        }

        $this->activeMethod = $this->server['REQUEST_METHOD'];
        
        if(isset($this->server['CONTENT_TYPE']) 
            && strtolower($this->server['CONTENT_TYPE']) === self::CONTENT_TYPES['json']
        ) {
            $this->setJsonRequest();
            return ;
        }
        $this->setDataByMethod();
    }

}