<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 02.09.16
 * Time: 15:06
 */

namespace HitobitoConnector\Mocks;


use HitobitoConnector\RequestInterface;
use Httpful\Request;
use Httpful\Response;

class RequestMock implements RequestInterface
{
    use MockTrait;

    const SIGNIN_HEADER = "HTTP/1.x 200 OK\r\nDate: Sun, 11 Sep 2016 20:26:44 GMT\r\nServer: Apache/2.2.15 (CentOS)\r\nX-Powered-By: Phusion Passenger (mod_rails/mod_rack) 3.0.15\r\nX-Frame-Options: SAMEORIGIN\r\nX-Xss-Protection: 1; mode=block\r\nX-Content-Type-Options: nosniff\r\nCache-Control: no-cache, no-store, max-age=0, must-revalidate\r\nPragma: no-cache\r\nExpires: Fri, 01 Jan 1990 00:00:00 GMT\r\nVary: Accept-Encoding\r\nX-Request-Id: 1940fc01-4bbc-4554-aa95-2b367b9546ef\r\nX-Runtime: 0.122147\r\nStrict-Transport-Security: max-age=31536000\r\nStatus: 200\r\nContent-Length: 714\r\nContent-Type: application/json; charset=utf-8\r\n";

    const SIGNIN_ANSWER = "{\"people\":[{\"id\":\"1111\",\"type\":\"people\",\"href\":\"{\$url}de/groups/1111/people/1111.json\",\"first_name\":\"Prename\",\"last_name\":\"Lastname\",\"nickname\":\"Scoutname\",\"company_name\":\"\",\"company\":false,\"gender\":\"m\",\"email\":\"{\$email}\",\"authentication_token\":\"fLxsn6eMV7GLcwckDyuy\",\"last_sign_in_at\":\"2016-08-23T14:40:23.000+02:00\",\"current_sign_in_at\":\"2016-09-02T15:46:18.045+02:00\",\"links\":{\"primary_group\":\"1111\"}}],\"linked\":{\"groups\":[{\"id\":\"1111\",\"name\":\"Pfadi\",\"group_type\":\"Pfadi\"}]},\"links\":{\"token.regenerate\":{\"method\":\"POST\",\"href\":\"https://db.scout.ch/de/users/token.json\",\"type\":\"tokens\"},\"token.delete\":{\"method\":\"DELETE\",\"href\":\"https://db.scout.ch/de/users/token.json\",\"type\":\"tokens\"}}}";

    private static function post($uri, $payload = null, $mime = null)
    {
        return static::$instance;
    }

    private function send(){
        return new Response(static::SIGNIN_ANSWER,static::SIGNIN_HEADER,Request::get(null));
    }


}