<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 31.08.16
 * Time: 12:42
 */

namespace HitobitoConnector;


use Httpful\Request;
use Httpful\Http;
use Httpful\Bootstrap;

class HttpfulRequestConnector extends Request implements RequestInterface
{
    public static $_template;


    /**
     * We made the constructor private to force the factory style.  This was
     * done to keep the syntax cleaner and better the support the idea of
     * "default templates".  Very basic and flexible as it is only intended
     * for internal use.
     * @param array $attrs hash of initial attribute values
     */
    private function __construct($attrs = null)
    {
        if (!is_array($attrs)) return;
        foreach ($attrs as $attr => $value) {
            $this->$attr = $value;
        }
    }


    /**
     * This is the default template to use if no
     * template has been provided.  The template
     * tells the class which default values to use.
     * While there is a slight overhead for object
     * creation once per execution (not once per
     * Request instantiation), it promotes readability
     * and flexibility within the class.
     */
    private static function _initializeDefaults()
    {
        // This is the only place you will
        // see this constructor syntax.  It
        // is only done here to prevent infinite
        // recusion.  Do not use this syntax elsewhere.
        // It goes against the whole readability
        // and transparency idea.
        static::$_template = new static(array('method' => Http::GET));

        // This is more like it...
        static::$_template
            ->withoutStrictSSL();
    }




    /**
     * Factory style constructor works nicer for chaining.  This
     * should also really only be used internally.  The Request::get,
     * Request::post syntax is preferred as it is more readable.
     * @param string $method Http Method
     * @param string $mime Mime Type to Use
     * @return Request
     */
    public static function init($method = null, $mime = null)
    {
        // Setup our handlers, can call it here as it's idempotent
        Bootstrap::init();

        // Setup the default template if need be
        if (!isset(static::$_template))
            static::_initializeDefaults();

        $request = new static();
        return $request
            ->_setDefaults()
            ->method($method)
            ->sendsType($mime)
            ->expectsType($mime);
    }

    /**
     * Set the defaults on a newly instantiated object
     * Doesn't copy variables prefixed with _
     * @return Request
     */
    public function _setDefaults()
    {
        if (!isset(self::$_template))
            self::_initializeDefaults();
        foreach (self::$_template as $k=>$v) {
            if ($k[0] != '_')
                $this->$k = $v;
        }
        return $this;
    }

    /**
     * HTTP Method Get
     * @param string $uri optional uri to use
     * @param string $mime expected
     * @return Request
     */
    public static function get($uri, $mime = null)
    {
        return static::init(Http::GET)->uri($uri)->mime($mime);
    }


    /**
     * Like Request:::get, except that it sends off the request as well
     * returning a response
     * @param string $uri optional uri to use
     * @param string $mime expected
     * @return Response
     */
    public static function getQuick($uri, $mime = null)
    {
        return static::get($uri, $mime)->send();
    }

    /**
     * HTTP Method Post
     * @param string $uri optional uri to use
     * @param string $payload data to send in body of request
     * @param string $mime MIME to use for Content-Type
     * @return Request
     */
    public static function post($uri, $payload = null, $mime = null)
    {
        return static::init(Http::POST)->uri($uri)->body($payload, $mime);
    }

    /**
     * HTTP Method Put
     * @param string $uri optional uri to use
     * @param string $payload data to send in body of request
     * @param string $mime MIME to use for Content-Type
     * @return Request
     */
    public static function put($uri, $payload = null, $mime = null)
    {
        return static::init(Http::PUT)->uri($uri)->body($payload, $mime);
    }

    /**
     * HTTP Method Patch
     * @param string $uri optional uri to use
     * @param string $payload data to send in body of request
     * @param string $mime MIME to use for Content-Type
     * @return Request
     */
    public static function patch($uri, $payload = null, $mime = null)
    {
        return static::init(Http::PATCH)->uri($uri)->body($payload, $mime);
    }

    /**
     * HTTP Method Delete
     * @param string $uri optional uri to use
     * @return Request
     */
    public static function delete($uri, $mime = null)
    {
        return static::init(Http::DELETE)->uri($uri)->mime($mime);
    }

    /**
     * HTTP Method Head
     * @param string $uri optional uri to use
     * @return Request
     */
    public static function head($uri)
    {
        return static::init(Http::HEAD)->uri($uri);
    }

    /**
     * HTTP Method Options
     * @param string $uri optional uri to use
     * @return Request
     */
    public static function options($uri)
    {
        return static::init(Http::OPTIONS)->uri($uri);
    }
}