<?php

namespace Tests\Feature\Providers;

use App\Providers\AppServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AppServiceProviderTest extends TestCase
{
    /** @test */
    public function ログインレートリミッターが動作すること()
    {
        $provider = new AppServiceProvider(app());
        $provider->boot();

        $request = Request::create('/login', 'POST', [
            'email' => 'test@example.com',
        ]);
        $request->server->set('REMOTE_ADDR', '127.0.0.1');

        $limit = RateLimiter::limiter('login')($request);

        $this->assertInstanceOf(Limit::class, $limit);
        $this->assertEquals(5, $limit->maxAttempts);
    }
}
