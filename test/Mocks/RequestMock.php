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

    const SIGNIN_ANSWER = "{\"people\":[{\"id\":\"1111\",\"type\":\"people\",\"href\":\"{\$url}de/groups/1111/people/1111.json\",\"first_name\":\"Prename\",\"last_name\":\"Lastname\",\"nickname\":\"Scoutname\",\"company_name\":\"\",\"company\":false,\"gender\":\"m\",\"email\":\"{\$email}\",\"authentication_token\":\"fLxsn6eMV7GLcwckDyuy\",\"last_sign_in_at\":\"2016-08-23T14:40:23.000+02:00\",\"current_sign_in_at\":\"2016-09-02T15:46:18.045+02:00\",\"links\":{\"primary_group\":\"1111\"}}],\"linked\":{\"groups\":[{\"id\":\"1111\",\"name\":\"Pfadi\",\"group_type\":\"Pfadi\"}]},\"links\":{\"token.regenerate\":{\"method\":\"POST\",\"href\":\"https://db.scout.ch/de/users/token.json\",\"type\":\"tokens\"},\"token.delete\":{\"method\":\"DELETE\",\"href\":\"https://db.scout.ch/de/users/token.json\",\"type\":\"tokens\"}}}";

    private static function post($uri, $payload = null, $mime = null)
    {
        return static::$instance;
    }

    private function send(){
        return new Response(static::SIGNIN_ANSWER,null,Request::get(null));
    }


}