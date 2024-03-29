<?php
declare(strict_types=1);

namespace BasicApp\Http;

class StatusCode
{
  public const HTTP_CONTINUE = 100;
  public const HTTP_SWITCHING_PROTOCOLS = 101;
  public const HTTP_PROCESSING = 102;

  public const HTTP_OK = 200;
  public const HTTP_CREATED = 201;
  public const HTTP_ACCEPTED = 202;
  public const HTTP_NONAUTHORITATIVE_INFORMATION = 203;
  public const HTTP_NO_CONTENT = 204;
  public const HTTP_RESET_CONTENT = 205;
  public const HTTP_PARTIAL_CONTENT = 206;
  public const HTTP_MULTI_STATUS = 207;
  public const HTTP_ALREADY_REPORTED = 208;
  public const HTTP_IM_USED = 226;

  public const HTTP_MULTIPLE_CHOICES = 300;
  public const HTTP_MOVED_PERMANENTLY = 301;
  public const HTTP_FOUND = 302;
  public const HTTP_SEE_OTHER = 303;
  public const HTTP_NOT_MODIFIED = 304;
  public const HTTP_USE_PROXY = 305;
  public const HTTP_UNUSED = 306;
  public const HTTP_TEMPORARY_REDIRECT = 307;
  public const HTTP_PERMANENT_REDIRECT = 308;

  public const HTTP_BAD_REQUEST = 400;
  public const HTTP_UNAUTHORIZED = 401;
  public const HTTP_PAYMENT_REQUIRED = 402;
  public const HTTP_FORBIDDEN = 403;
  public const HTTP_NOT_FOUND = 404;
  public const HTTP_METHOD_NOT_ALLOWED = 405;
  public const HTTP_NOT_ACCEPTABLE = 406;
  public const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
  public const HTTP_REQUEST_TIMEOUT = 408;
  public const HTTP_CONFLICT = 409;
  public const HTTP_GONE = 410;
  public const HTTP_LENGTH_REQUIRED = 411;
  public const HTTP_PRECONDITION_FAILED = 412;
  public const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
  public const HTTP_REQUEST_URI_TOO_LONG = 414;
  public const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
  public const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
  public const HTTP_EXPECTATION_FAILED = 417;
  public const HTTP_IM_A_TEAPOT = 418;
  public const HTTP_MISDIRECTED_REQUEST = 421;
  public const HTTP_UNPROCESSABLE_ENTITY = 422;
  public const HTTP_LOCKED = 423;
  public const HTTP_FAILED_DEPENDENCY = 424;
  public const HTTP_UPGRADE_REQUIRED = 426;
  public const HTTP_PRECONDITION_REQUIRED = 428;
  public const HTTP_TOO_MANY_REQUESTS = 429;
  public const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
  public const HTTP_CONNECTION_CLOSED_WITHOUT_RESPONSE = 444;
  public const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
  public const HTTP_CLIENT_CLOSED_REQUEST = 499;

  public const HTTP_INTERNAL_SERVER_ERROR = 500;
  public const HTTP_NOT_IMPLEMENTED = 501;
  public const HTTP_BAD_GATEWAY = 502;
  public const HTTP_SERVICE_UNAVAILABLE = 503;
  public const HTTP_GATEWAY_TIMEOUT = 504;
  public const HTTP_VERSION_NOT_SUPPORTED = 505;
  public const HTTP_VARIANT_ALSO_NEGOTIATES = 506;
  public const HTTP_INSUFFICIENT_STORAGE = 507;
  public const HTTP_LOOP_DETECTED = 508;
  public const HTTP_NOT_EXTENDED = 510;
  public const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;
  public const HTTP_NETWORK_CONNECTION_TIMEOUT_ERROR = 599;

  /**
   * Status codes and reason phrases
   *
   * @var array
   */
  public static $messages = [
    // Informational 1xx
    self::HTTP_CONTINUE            => 'Continue',
    self::HTTP_SWITCHING_PROTOCOLS => 'Switching Protocols',
    self::HTTP_PROCESSING          => 'Processing',

    // Successful 2xx
    self::HTTP_OK                           => 'OK',
    self::HTTP_CREATED                      => 'Created',
    self::HTTP_ACCEPTED                     => 'Accepted',
    self::HTTP_NONAUTHORITATIVE_INFORMATION => 'Non-Authoritative Information',
    self::HTTP_NO_CONTENT                   => 'No Content',
    self::HTTP_RESET_CONTENT                => 'Reset Content',
    self::HTTP_PARTIAL_CONTENT              => 'Partial Content',
    self::HTTP_MULTI_STATUS                 => 'Multi-Status',
    self::HTTP_ALREADY_REPORTED             => 'Already Reported',
    self::HTTP_IM_USED                      => 'IM Used',

    // Redirection 3xx
    self::HTTP_MULTIPLE_CHOICES   => 'Multiple Choices',
    self::HTTP_MOVED_PERMANENTLY  => 'Moved Permanently',
    self::HTTP_FOUND              => 'Found',
    self::HTTP_SEE_OTHER          => 'See Other',
    self::HTTP_NOT_MODIFIED       => 'Not Modified',
    self::HTTP_USE_PROXY          => 'Use Proxy',
    self::HTTP_UNUSED             => '(Unused)',
    self::HTTP_TEMPORARY_REDIRECT => 'Temporary Redirect',
    self::HTTP_PERMANENT_REDIRECT => 'Permanent Redirect',

    // Client Error 4xx
    self::HTTP_BAD_REQUEST                        => 'Bad Request',
    self::HTTP_UNAUTHORIZED                       => 'Unauthorized',
    self::HTTP_PAYMENT_REQUIRED                   => 'Payment Required',
    self::HTTP_FORBIDDEN                          => 'Forbidden',
    self::HTTP_NOT_FOUND                          => 'Not Found',
    self::HTTP_METHOD_NOT_ALLOWED                 => 'Method Not Allowed',
    self::HTTP_NOT_ACCEPTABLE                     => 'Not Acceptable',
    self::HTTP_PROXY_AUTHENTICATION_REQUIRED      => 'Proxy Authentication Required',
    self::HTTP_REQUEST_TIMEOUT                    => 'Request Timeout',
    self::HTTP_CONFLICT                           => 'Conflict',
    self::HTTP_GONE                               => 'Gone',
    self::HTTP_LENGTH_REQUIRED                    => 'Length Required',
    self::HTTP_PRECONDITION_FAILED                => 'Precondition Failed',
    self::HTTP_REQUEST_ENTITY_TOO_LARGE           => 'Request Entity Too Large',
    self::HTTP_REQUEST_URI_TOO_LONG               => 'Request-URI Too Long',
    self::HTTP_UNSUPPORTED_MEDIA_TYPE             => 'Unsupported Media Type',
    self::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE    => 'Requested Range Not Satisfiable',
    self::HTTP_EXPECTATION_FAILED                 => 'Expectation Failed',
    self::HTTP_IM_A_TEAPOT                        => 'I\'m a teapot',
    self::HTTP_MISDIRECTED_REQUEST                => 'Misdirected Request',
    self::HTTP_UNPROCESSABLE_ENTITY               => 'Unprocessable Entity',
    self::HTTP_LOCKED                             => 'Locked',
    self::HTTP_FAILED_DEPENDENCY                  => 'Failed Dependency',
    self::HTTP_UPGRADE_REQUIRED                   => 'Upgrade Required',
    self::HTTP_PRECONDITION_REQUIRED              => 'Precondition Required',
    self::HTTP_TOO_MANY_REQUESTS                  => 'Too Many Requests',
    self::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE    => 'Request Header Fields Too Large',
    self::HTTP_CONNECTION_CLOSED_WITHOUT_RESPONSE => 'Connection Closed Without Response',
    self::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS      => 'Unavailable For Legal Reasons',
    self::HTTP_CLIENT_CLOSED_REQUEST              => 'Client Closed Request',

    // Server Error 5xx
    self::HTTP_INTERNAL_SERVER_ERROR            => 'Internal Server Error',
    self::HTTP_NOT_IMPLEMENTED                  => 'Not Implemented',
    self::HTTP_BAD_GATEWAY                      => 'Bad Gateway',
    self::HTTP_SERVICE_UNAVAILABLE              => 'Service Unavailable',
    self::HTTP_GATEWAY_TIMEOUT                  => 'Gateway Timeout',
    self::HTTP_VERSION_NOT_SUPPORTED            => 'HTTP Version Not Supported',
    self::HTTP_VARIANT_ALSO_NEGOTIATES          => 'Variant Also Negotiates',
    self::HTTP_INSUFFICIENT_STORAGE             => 'Insufficient Storage',
    self::HTTP_LOOP_DETECTED                    => 'Loop Detected',
    self::HTTP_NOT_EXTENDED                     => 'Not Extended',
    self::HTTP_NETWORK_AUTHENTICATION_REQUIRED  => 'Network Authentication Required',
    self::HTTP_NETWORK_CONNECTION_TIMEOUT_ERROR => 'Network Connect Timeout Error',
  ];
}
