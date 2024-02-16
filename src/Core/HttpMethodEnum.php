<?php

namespace App\Core;

enum HttpMethodEnum: string {
  case GET = 'GET';
  case POST = 'POST';
  case PATCH = 'PATCH';
  case PUT = 'PUT';
  case DELETE = 'DELETE';

  public function label(): string {
    return static::getLabel($this);
  }

  public static function getLabel(self $value): string {
    return match ($value) {
      HttpMethodEnum::GET => 'GET',
      HttpMethodEnum::POST => 'POST',
      HttpMethodEnum::PATCH => 'PATCH',
      HttpMethodEnum::DELETE => 'DELETE',
      HttpMethodEnum::PUT => 'PUT'
    };
}

  public static function exist(string $method): bool {
    return match($method) {
        HttpMethodEnum::GET->label(),
        HttpMethodEnum::POST->label(),
        HttpMethodEnum::PATCH->label(),
        HttpMethodEnum::DELETE->label(),
        HttpMethodEnum::PUT->label() => true,
        default => false
    };
  }

}