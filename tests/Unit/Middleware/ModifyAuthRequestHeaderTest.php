<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\ModifyAuthRequestHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PHPUnit\Framework\TestCase;

class ModifyAuthRequestHeaderTest extends TestCase
{
    /**
     * A basic unit test example.
     * @dataProvider provide_リクエストヘッダのBearerをTokenに変更
     *
     * @return void
     */
    public function test_リクエストヘッダのBearerをTokenに変更(string $expected, string $beforeToken)
    {
        $request = new Request();
        $request->headers->set(ModifyAuthRequestHeader::AUTH_HEADER, $beforeToken);

        $middleware = new ModifyAuthRequestHeader();
        $response = $middleware->handle($request, function ($next) use ($expected) {
            $this->assertEquals($next->headers->get(ModifyAuthRequestHeader::AUTH_HEADER), $expected);
        });
        
        // エラーレスポンスが返却されないこと
        $this->assertNull($response);
    }

    public function provide_リクエストヘッダのBearerをTokenに変更()
    {
        return [
            '通常' => [
                'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwaS5yZWFsLXdvcmxkLmxvY2FsL2FwaS91c2Vycy9sb2dpbiIsImlhdCI6MTY3MjIzMjU2MCwiZXhwIjoxNjcyMjM2MTYwLCJuYmYiOjE2NzIyMzI1NjAsImp0aSI6IldJVFdYQTN1aWptTzNMVXEiLCJzdWIiOiIxMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.Jqi_wNUpgZLYHVisw-TTqJQqdV2q_lopHAeS0Bsvhcc',
                'Token eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwaS5yZWFsLXdvcmxkLmxvY2FsL2FwaS91c2Vycy9sb2dpbiIsImlhdCI6MTY3MjIzMjU2MCwiZXhwIjoxNjcyMjM2MTYwLCJuYmYiOjE2NzIyMzI1NjAsImp0aSI6IldJVFdYQTN1aWptTzNMVXEiLCJzdWIiOiIxMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.Jqi_wNUpgZLYHVisw-TTqJQqdV2q_lopHAeS0Bsvhcc',
            ],
            '途中にもTokenがある' => [
                'Bearer eyJ0eXAiOiTokenLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwaS5yZWFsLXdvcmxkLmxvY2FsL2FwaS91c2Vycy9sb2dpbiIsImlhdCI6MTY3MjIzMjU2MCwiZXhwIjoxNjcyMjM2MTYwLCJuYmYiOjE2NzIyMzI1NjAsImp0aSI6IldJVFdYQTN1aWptTzNMVXEiLCJzdWIiOiIxMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.Jqi_wNUpgZLYHVisw-TTqJQqdV2q_lopHAeS0Bsvhcc',
                'Token eyJ0eXAiOiTokenLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwaS5yZWFsLXdvcmxkLmxvY2FsL2FwaS91c2Vycy9sb2dpbiIsImlhdCI6MTY3MjIzMjU2MCwiZXhwIjoxNjcyMjM2MTYwLCJuYmYiOjE2NzIyMzI1NjAsImp0aSI6IldJVFdYQTN1aWptTzNMVXEiLCJzdWIiOiIxMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.Jqi_wNUpgZLYHVisw-TTqJQqdV2q_lopHAeS0Bsvhcc',
            ],
            '変更なし1' => [
                'Tokn eyJ0eXAiOiBearerLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwaS5yZWFsLXdvcmxkLmxvY2FsL2FwaS91c2Vycy9sb2dpbiIsImlhdCI6MTY3MjIzMjU2MCwiZXhwIjoxNjcyMjM2MTYwLCJuYmYiOjE2NzIyMzI1NjAsImp0aSI6IldJVFdYQTN1aWptTzNMVXEiLCJzdWIiOiIxMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.Jqi_wNUpgZLYHVisw-TTqJQqdV2q_lopHAeS0Bsvhcc',
                'Tokn eyJ0eXAiOiBearerLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwaS5yZWFsLXdvcmxkLmxvY2FsL2FwaS91c2Vycy9sb2dpbiIsImlhdCI6MTY3MjIzMjU2MCwiZXhwIjoxNjcyMjM2MTYwLCJuYmYiOjE2NzIyMzI1NjAsImp0aSI6IldJVFdYQTN1aWptTzNMVXEiLCJzdWIiOiIxMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.Jqi_wNUpgZLYHVisw-TTqJQqdV2q_lopHAeS0Bsvhcc',
            ],
            '変更なし2' => [
                'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwaS5yZWFsLXdvcmxkLmxvY2FsL2FwaS91c2Vycy9sb2dpbiIsImlhdCI6MTY3MjIzMjU2MCwiZXhwIjoxNjcyMjM2MTYwLCJuYmYiOjE2NzIyMzI1NjAsImp0aSI6IldJVFdYQTN1aWptTzNMVXEiLCJzdWIiOiIxMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.Jqi_wNUpgZLYHVisw-TTqJQqdV2q_lopHAeS0Bsvhcc',
                'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwaS5yZWFsLXdvcmxkLmxvY2FsL2FwaS91c2Vycy9sb2dpbiIsImlhdCI6MTY3MjIzMjU2MCwiZXhwIjoxNjcyMjM2MTYwLCJuYmYiOjE2NzIyMzI1NjAsImp0aSI6IldJVFdYQTN1aWptTzNMVXEiLCJzdWIiOiIxMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.Jqi_wNUpgZLYHVisw-TTqJQqdV2q_lopHAeS0Bsvhcc',
            ],
        ];
    }
}
