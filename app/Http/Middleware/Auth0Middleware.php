<?php

namespace App\Http\Middleware;

use Closure;
use Auth0\SDK\Exception\InvalidTokenException;
use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;
use Auth0\SDK\Helpers\Tokens\TokenVerifier;

class Auth0Middleware
{
    private function tokenHasScope($token, $scope)
    {
        if (empty($token['scope'])) {
            return false;
        }

        $tokenScopes = explode(' ', $token['scope']);
        return in_array($scope, $tokenScopes);
    }
    
    private function validateAndDecode($token)
    {
        try {
            $jwksUri = env('AUTH0_DOMAIN') . '.well-known/jwks.json';
            $jwkFetcher = new JWKFetcher(null, [ 'base_uri' => $jwksUri ]);
            $signatureVerifier = new AsymmetricVerifier($jwkFetcher);
            $tokenVerifier = new TokenVerifier(env('AUTH0_DOMAIN'), env('AUTH0_AUD'), $signatureVerifier);

            return $tokenVerifier->verify($token);
        }
        catch (InvalidTokenException $exception) {
            return false;
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $scopeRequired = null)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([ 'message' => 'No token provided' ], 401);
        }

        $decoded = $this->validateAndDecode($token);
        if (!$decoded) {
            return response()->json([ 'message' => 'Invalid token' ], 401);
        }
        if($scopeRequired && !$this->tokenHasScope($decoded, $scopeRequired)) {
            return response()->json([ 'message' => 'Insuficient scope' ], 403);
        }

        return $next($request);
    }
}
