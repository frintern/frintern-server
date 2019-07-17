<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 12/21/15
 * Time: 5:13 PM
 */

namespace App\Libraries;


use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class TokenHandler
{

    /**
     * Creates JWT token from an array of claims
     * @param array $user
     * @return array $unEncodedArray
     */
    public static function create($user)
    {
        // Set the token claims
        $tokenId = base64_encode(str_random(32));
        $dateTime = new \DateTime('now');
        $issuedAt = $dateTime->getTimestamp();
        $notBefore = $issuedAt + 10; // Adding 10 seconds
        $expire = $notBefore + config('meetrabbi.jwtValidity'); // Validity is 2 weeks = 14 days
        $serverName =   $_SERVER['SERVER_NAME'];

        // Create token as an array
        $data = [
            'iat' => $issuedAt,
            'jti' => $tokenId,
            'iss' => $serverName,
            'nbf' => $notBefore,
            'exp' => $expire,
            'data' => $user
        ];

        // Gets the secret key from the jwt config
        $secretKey = config('meetrabbi.jwtSecret');

        // Encodes the token array in JWT
        $jwt = JWT::encode(
            $data,
            $secretKey,
            'HS512'
        );

        // returns the unencoded array
        return $jwt;
    }

    /**
     * @param $jwt
     * @return bool
     */
    public static function verify($jwt){
        try{
            /*
             * decode the jwt using the key from the config
             * */

            $secretKey = config('meetrabbi.jwtSecret');

            $token = JWT::decode($jwt, $secretKey, array('HS512'));

            // returns true if the token is verified
            return true;

        }catch(\Exception $ex){
            /*
             * The token was not able to be decoded
             * this is likely because the signature was not able to be verified (tampered token) ro the token is expired
             * */
            // returns false
            return false;

        }
    }

    /**
     * Refresh Token
     * @param $jwt
     * @return null|string
     */
    public static function refreshToken($jwt)
    {
        try {
            $userData =  TokenHandler::decode($jwt);

            $newToken = TokenHandler::create($userData);

        } catch (ExpiredException $ex) {
            $newToken = null;
        }

        return $newToken;
    }

    public static function decode($token)
    {

        try
        {
            $secretKey = config('meetrabbi.jwtSecret');

            $decodedToken = JWT::decode($token, $secretKey, array('HS512'));

            return (array)$decodedToken->data;

        }
        catch (\Exception $ex)
        {
            return [];
        }

    }
}