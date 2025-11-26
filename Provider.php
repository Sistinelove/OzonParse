<?php

declare(strict_types=1);

class Provider
{
    private string $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36';
    // Здесь придется заменить на свои куки с сайта озона, никогда страницы не парсил, можно ли использовать было библиотки
    // не знал, поэтому решил использовать такой метод, хотя конечно есть время жизни у этого способа, но как на голой пыхе
    // релаизовать авторизацию на сайте озона, я не разобрался
    private string $cookie = '__Secure-ab-group=78; __Secure-ext_xcid=cc1cd0b63e8cca71fbfa738cf66ff647; is_cookies_accepted=1; ADDRESSBOOKBAR_WEB_CLARIFICATION=1764003130; __Secure-ETC=722470f6628ac2aa3c9026b83b9b78f8; xcid=a25afdc699847f86554ec278022eee11; is_adult_confirmed=; is_alco_adult_confirmed=; rfuid=LTE5NTAyNjU0NzAsMTI0LjA0MzQ3NTI3NTE2MDc0LDE0NTM3NjMwMDUsLTEsLTEzMzI0NTMwOTYsVzNzaWJtRnRaU0k2SWxCRVJpQldhV1YzWlhJaUxDSmtaWE5qY21sd2RHbHZiaUk2SWxCdmNuUmhZbXhsSUVSdlkzVnRaVzUwSUVadmNtMWhkQ0lzSW0xcGJXVlVlWEJsY3lJNlczc2lkSGx3WlNJNkltRndjR3hwWTJGMGFXOXVMM0JrWmlJc0luTjFabVpwZUdWeklqb2ljR1JtSW4wc2V5SjBlWEJsSWpvaWRHVjRkQzl3WkdZaUxDSnpkV1ptYVhobGN5STZJbkJrWmlKOVhYMHNleUp1WVcxbElqb2lRMmh5YjIxbElGQkVSaUJXYVdWM1pYSWlMQ0prWlhOamNtbHdkR2x2YmlJNklsQnZjblJoWW14bElFUnZZM1Z0Wlc1MElFWnZjbTFoZENJc0ltMXBiV1ZVZVhCbGN5STZXM3NpZEhsd1pTSTZJbUZ3Y0d4cFkyRjBhVzl1TDNCa1ppSXNJbk4xWm1acGVHVnpJam9pY0dSbUluMHNleUowZVhCbElqb2lkR1Y0ZEM5d1pHWWlMQ0p6ZFdabWFYaGxjeUk2SW5Ca1ppSjlYWDBzZXlKdVlXMWxJam9pUTJoeWIyMXBkVzBnVUVSR0lGWnBaWGRsY2lJc0ltUmxjMk55YVhCMGFXOXVJam9pVUc5eWRHRmliR1VnUkc5amRXMWxiblFnUm05eWJXRjBJaXdpYldsdFpWUjVjR1Z6SWpwYmV5SjBlWEJsSWpvaVlYQndiR2xqWVhScGIyNHZjR1JtSWl3aWMzVm1abWw0WlhNaU9pSndaR1lpZlN4N0luUjVjR1VpT2lKMFpYaDBMM0JrWmlJc0luTjFabVpwZUdWeklqb2ljR1JtSW4xZGZTeDdJbTVoYldVaU9pSk5hV055YjNOdlpuUWdSV1JuWlNCUVJFWWdWbWxsZDJWeUlpd2laR1Z6WTNKcGNIUnBiMjRpT2lKUWIzSjBZV0pzWlNCRWIyTjFiV1Z1ZENCR2IzSnRZWFFpTENKdGFXMWxWSGx3WlhNaU9sdDdJblI1Y0dVaU9pSmhjSEJzYVdOaGRHbHZiaTl3WkdZaUxDSnpkV1ptYVhobGN5STZJbkJrWmlKOUxIc2lkSGx3WlNJNkluUmxlSFF2Y0dSbUlpd2ljM1ZtWm1sNFpYTWlPaUp3WkdZaWZWMTlMSHNpYm1GdFpTSTZJbGRsWWt0cGRDQmlkV2xzZEMxcGJpQlFSRVlpTENKa1pYTmpjbWx3ZEdsdmJpSTZJbEJ2Y25SaFlteGxJRVJ2WTNWdFpXNTBJRVp2Y20xaGRDSXNJbTFwYldWVWVYQmxjeUk2VzNzaWRIbHdaU0k2SW1Gd2NHeHBZMkYwYVc5dUwzQmtaaUlzSW5OMVptWnBlR1Z6SWpvaWNHUm1JbjBzZXlKMGVYQmxJam9pZEdWNGRDOXdaR1lpTENKemRXWm1hWGhsY3lJNkluQmtaaUo5WFgxZCxXeUp5ZFNKZCwwLDEsMCwyNCwyMzc0MTU5MzAsOCwyMjcxMjY1MjAsMCwxLDAsLTQ5MTI3NTUyMyxSMjl2WjJ4bElFbHVZeTRnVG1WMGMyTmhjR1VnUjJWamEyOGdWMmx1TXpJZ05TNHdJQ2hYYVc1a2IzZHpJRTVVSURFd0xqQTdJRmRwYmpZME95QjROalFwSUVGd2NHeGxWMlZpUzJsMEx6VXpOeTR6TmlBb1MwaFVUVXdzSUd4cGEyVWdSMlZqYTI4cElFTm9jbTl0WlM4eE5ESXVNQzR3TGpBZ1UyRm1ZWEpwTHpVek55NHpOaUF5TURBek1ERXdOeUJOYjNwcGJHeGgsZXlKamFISnZiV1VpT25zaVlYQndJanA3SW1selNXNXpkR0ZzYkdWa0lqcG1ZV3h6WlN3aVNXNXpkR0ZzYkZOMFlYUmxJanA3SWtSSlUwRkNURVZFSWpvaVpHbHpZV0pzWldRaUxDSkpUbE5VUVV4TVJVUWlPaUpwYm5OMFlXeHNaV1FpTENKT1QxUmZTVTVUVkVGTVRFVkVJam9pYm05MFgybHVjM1JoYkd4bFpDSjlMQ0pTZFc1dWFXNW5VM1JoZEdVaU9uc2lRMEZPVGs5VVgxSlZUaUk2SW1OaGJtNXZkRjl5ZFc0aUxDSlNSVUZFV1Y5VVQxOVNWVTRpT2lKeVpXRmtlVjkwYjE5eWRXNGlMQ0pTVlU1T1NVNUhJam9pY25WdWJtbHVaeUo5ZlgxOSw2NSw1MjEwNTE5MTEsMSwxLC0xLDE2OTk5NTQ4ODcsMTY5OTk1NDg4NywtMTEyNjMwNDc3NCwxMg==; guest=true; __Secure-access-token=9.76458051.azxJfsMzQSuNUL-8u1rSsA.78.AS-VYT7JmunE9JP83OSDaw9j3jXPU9PNk7o8DQbsxEy5nzv2PqGF47alGJAhjjbDnyMtLJjJo9kZwVyfYO7-AQo5_S3forn-8ml6MHvBl1kLHPjueKMOJ5OHDBVldMvaJA.20210921212739.20251126191634.qSEFYzosqiDa97reFCcZK3alAjnAe4oJYuPBWsesoqA.191590d05cc64aa80; __Secure-refresh-token=9.76458051.azxJfsMzQSuNUL-8u1rSsA.78.AS-VYT7JmunE9JP83OSDaw9j3jXPU9PNk7o8DQbsxEy5nzv2PqGF47alGJAhjjbDnyMtLJjJo9kZwVyfYO7-AQo5_S3forn-8ml6MHvBl1kLHPjueKMOJ5OHDBVldMvaJA.20210921212739.20251126191634.E_n5sOq_7AeKlF8XOXw03NAzvVl9lQ6-KrW6S7Crxbw.1b5a2211048a9e082; __Secure-user-id=76458051; abt_data=7.Q2_LXvrbpxj0_XByQRbfoMVo9x4QkTy7I7e3E8MmaO-o3RML3x1j5GadF8y2CZHRTnbQ5PvqhctLrRDk4zQ-CX-BUXe8HXyTyK4zJzFe8viqmRdXutfbI77osDVkWAmWmDBN-pc3iP9ZyjOB1fJEwVQsqYBVYmdCdxXcT3UgiYKYrhyE7WLksLUxf4HVFqkhQCqudvZ-A5cDj3OVnjazsQk8FNTWZ6T7oWyQFy_ez5u2a3SffTFUiMVFlbxVKJxytLU7b7nSCZs7SigIC-d00hMJeOZa8zB0dahXAJNcfoBCW4eB6CpPAxxLQUNigIQZVi_eCfGLAOE69FVkRCuEDruDrMgxoLLnEniG2uGS64adaGaGm7mer1LlsFlCrCuN_4Uw5_0yhanIuqlUXWjqKGJYCGe-UvdKD6_qtdoxGAG5ykDyLgxdH6Zl0J3NmSDOrdD_QCoDzh3T4im_KT9TKXWB16NjlEY02igVh-CreiQACk1MwWmO0YU6fh2mMFeHjndSDUmpXaBHST3B6THdti032f2u4gVG6xKwtlnrqmKGgWWl6xb5XwGRyMJ649GOoX5duQCcVx_zNdNtYQVp0KIWeUvdv5QAvN7vhJjWvM1uToupKVoe5zdrmFUv17chP_JtTQ; ozonIdAuthResponseToken=eyJhbGciOiJIUzI1NiIsIm96b25pZCI6Im5vdHNlbnNpdGl2ZSIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjo3NjQ1ODA1MSwiaXNfcmVnaXN0cmF0aW9uIjpmYWxzZSwicmV0dXJuX3VybCI6Ii8iLCJwYXlsb2FkIjpudWxsLCJleHAiOjE3NjQxNzc0MDQsImlhdCI6MTc2NDE3NzM5NCwiaXNzIjoib3pvbmlkIn0.E8Mido_IGNombfqZMDV4LuAIRb13QwmBaY88k5ySprQ';
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function requests(): string
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
        $headers = [
            'User-Agent: ' . $this->userAgent,
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
            'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
            'Referer: https://www.google.com/',
            'Upgrade-Insecure-Requests: 1',
            'Cache-Control: max-age=0',
            'Connection: keep-alive',
            'Cookie: ' . $this->cookie
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error || $httpCode !== 200) {
            return '';
        }

        return (string)$result;
    }
}