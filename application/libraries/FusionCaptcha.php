<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FusionCaptcha
{
    protected $CI;

    protected string $secret_key;
    protected array $settings = [];

    public function __construct()
    {
        $this->CI =& get_instance();

        $this->CI->load->driver('cache', [
            'adapter' => 'file',
            'backup'  => 'file'
        ]);

        $configKey = (string) $this->CI->config->item('fusion_captcha_secret_key');
        if (!empty($configKey)) {
            $this->secret_key = $configKey;
        } else {
            $this->secret_key = $this->get_or_generate_secret_key();
        }

        $this->settings = array_merge([
            'challenge_count'         => 4,
            'difficulty'              => 5,
            'challenge_ttl'          => 300,
            'token_ttl'              => 600,
            'bind_ip'                => true,
            'bind_ua'                => true,
            'max_challenges_per_minute' => 20,
            'max_redeems_per_minute'    => 20,
        ], (array) $this->CI->config->item('fusion_captcha'));
    }

    public function set_cors_headers(): void
    {
        $origin = $this->settings['allowed_origin'] ?? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];

        header('Access-Control-Allow-Origin: ' . $origin);
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Max-Age: 86400');
            exit(0);
        }
    }

    public function generate_challenge(): array
    {
        $this->garbage_collect();

        $ip = $this->get_user_ip();
        $data = $this->read_ip_data($ip);

        // Rate limit check (stored inside the same IP file)
        if (!$this->rate_limit_in_data($data, 'challenge', $this->settings['max_challenges_per_minute'])) {
            return ['success' => false, 'error' => 'rate_limited'];
        }

        $now = time();
        $challenge = $data['challenge'] ?? null;

        // If a valid, unused challenge already exists, return it
        if ($challenge !== null && empty($challenge['used']) && ($now - $challenge['created']) < $this->settings['challenge_ttl']) {
            return [
                'token'     => $challenge['token'],
                'challenge' => $challenge['challenges']
            ];
        }

        // Otherwise, create a new challenge
        $token      = bin2hex(random_bytes(32));
        $difficulty = $this->get_adaptive_difficulty();
        $count      = (int) $this->settings['challenge_count'];
        $challenges = [];

        for ($i = 0; $i < $count; $i++) {
            $salt   = bin2hex(random_bytes(16));
            $target = str_repeat('0', $difficulty);
            $challenges[] = [$salt, $target];
        }

        $data['challenge'] = [
            'token'      => $token,
            'created'    => $now,
            'difficulty' => $difficulty,
            'used'       => false,
            'challenges' => $challenges
        ];

        $this->save_ip_data($ip, $data, $this->settings['challenge_ttl']);

        return [
            'token'     => $token,
            'challenge' => $challenges
        ];
    }

    public function verify_solutions(string $token, array $solutions): array
    {
        $this->garbage_collect();

        $ip   = $this->get_user_ip();
        $data = $this->read_ip_data($ip);

        // Rate limit for redemption
        if (!$this->rate_limit_in_data($data, 'redeem', $this->settings['max_redeems_per_minute'])) {
            return ['success' => false, 'error' => 'rate_limited'];
        }

        $challenge = $data['challenge'] ?? null;

        if ($challenge === null) {
            return ['success' => false, 'error' => 'expired'];
        }

        if (!empty($challenge['used'])) {
            return ['success' => false, 'error' => 'replay_detected'];
        }

        // Validate that the supplied token matches the active challenge token
        if (!hash_equals($challenge['token'], $token)) {
            return ['success' => false, 'error' => 'invalid_token'];
        }

        // Check IP and User-Agent binding
        if ($this->settings['bind_ip'] && $data['ip'] !== $ip) {
            return ['success' => false, 'error' => 'ip_mismatch'];
        }
        if ($this->settings['bind_ua'] && $data['ua'] !== $this->user_agent_hash()) {
            return ['success' => false, 'error' => 'ua_mismatch'];
        }

        if (count($solutions) !== count($challenge['challenges'])) {
            return ['success' => false, 'error' => 'invalid_count'];
        }

        // Verify each solution against its challenge
        foreach ($challenge['challenges'] as $i => $pair) {
            [$salt, $target] = $pair;
            $nonce = (string) ($solutions[$i] ?? '');
            if (!ctype_digit($nonce)) {
                return ['success' => false, 'error' => 'invalid_nonce'];
            }
            $hash = hash('sha256', $salt . $nonce);
            if (!hash_equals(substr($hash, 0, strlen($target)), $target)) {
                return ['success' => false, 'error' => 'invalid_solution'];
            }
        }

        // Mark challenge as used
        $data['challenge']['used'] = true;

        // Generate final token and store its hash to prevent replay
        $finalToken = $this->generate_final_token();

        $this->save_ip_data($ip, $data, $this->settings['token_ttl']);

        return [
            'success' => true,
            'token'   => $finalToken,
            'expires' => (time() + $this->settings['token_ttl']) * 1000
        ];
    }

    public function verify_final_token(string $token): bool
    {
        $parts = explode('.', $token);
        if (count($parts) !== 2) {
            return false;
        }

        [$payload, $signature] = $parts;
        $expectedSignature = hash_hmac('sha256', $payload, $this->secret_key);
        if (!hash_equals($expectedSignature, $signature)) {
            return false;
        }

        $data = json_decode($this->base64url_decode($payload), true);
        if (!$data) {
            return false;
        }

        if (time() > ($data['exp'] ?? 0)) {
            return false;
        }

        if ($this->settings['bind_ip'] && ($data['ip'] ?? '') !== $this->get_user_ip()) {
            return false;
        }

        if ($this->settings['bind_ua'] && ($data['ua'] ?? '') !== $this->user_agent_hash()) {
            return false;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (($data['session_id'] ?? '') !== session_id()) {
            return false;
        }

        // Replay prevention – check from the IP data file
        $ip   = $this->get_user_ip();
        $ipData = $this->read_ip_data($ip);
        $usedTokens = $ipData['used_tokens'] ?? [];
        $tokenHash = sha1($token);

        if (isset($usedTokens[$tokenHash])) {
            return false; // Token already used
        }

        // Record token usage
        $ipData['used_tokens'][$tokenHash] = time() + $this->settings['token_ttl'];
        $this->save_ip_data($ip, $ipData, $this->settings['token_ttl']);

        return true;
    }

    /**
     * Cache key for a given IP
     */
    protected function ip_cache_key(string $ip): string
    {
        // Prefix 'ip_' results in key: captcha/captcha_ip_<hash>
        return 'ip_' . md5($ip);
    }

    /**
     * Read all data for an IP from cache, with automatic expiry cleanup
     */
    protected function read_ip_data(string $ip): array
    {
        $key  = $this->ip_cache_key($ip);
        $data = $this->cache_get($key);

        if (!is_array($data)) {
            // Default structure
            $data = [
                'ip'          => $ip,
                'ua'          => $this->user_agent_hash(),
                'challenge'   => null,
                'rate'        => [],   // ['challenge' => [window => count], 'redeem' => ...]
                'used_tokens' => [],   // [hash => expire_timestamp]
            ];
        } else {
            // In-memory cleanup of expired data
            $now = time();
            // Remove old rate-limit windows (previous minutes)
            $currentWindow = floor($now / 60);
            foreach (['challenge', 'redeem'] as $action) {
                if (isset($data['rate'][$action])) {
                    foreach ($data['rate'][$action] as $window => $count) {
                        if ((int)$window < $currentWindow) {
                            unset($data['rate'][$action][$window]);
                        }
                    }
                }
            }
            // Remove expired used tokens
            if (!empty($data['used_tokens'])) {
                foreach ($data['used_tokens'] as $hash => $expire) {
                    if ($expire < $now) {
                        unset($data['used_tokens'][$hash]);
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Save IP data with the given TTL
     */
    protected function save_ip_data(string $ip, array $data, int $ttl): void
    {
        $key = $this->ip_cache_key($ip);
        $this->cache_save($key, $data, $ttl);
    }

    protected function rate_limit_in_data(array &$data, string $action, int $limit): bool
    {
        $window = floor(time() / 60);

        if (!isset($data['rate'][$action])) {
            $data['rate'][$action] = [];
        }

        // Increment and check
        $count = ($data['rate'][$action][$window] ?? 0) + 1;
        $data['rate'][$action][$window] = $count;

        return $count <= $limit;
    }

    public function garbage_collect(): void
    {
        // Only run on ~1% of requests to avoid overhead
        if (mt_rand(1, 100) > 1) {
            return;
        }

        $prefix = 'captcha/captcha_';   // prefix used in cache_save
        $files = glob('writable/cache/data/' . $prefix . '*');

        if (!is_array($files)) {
            return;
        }

        $now = time();
        $maxLifetime = max($this->settings['challenge_ttl'], $this->settings['token_ttl']) + 120;

        foreach ($files as $file) {
            if (($now - filemtime($file)) > $maxLifetime) {
                @unlink($file);
            }
        }
    }

    protected function generate_final_token(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $sessionId = session_id();

        $payload = [
            'iat'        => time(),
            'exp'        => time() + $this->settings['token_ttl'],
            'ip'         => $this->get_user_ip(),
            'ua'         => $this->user_agent_hash(),
            'session_id' => $sessionId,
            'rnd'        => bin2hex(random_bytes(16))
        ];

        $payloadEncoded = $this->base64url_encode(json_encode($payload));
        $signature = hash_hmac('sha256', $payloadEncoded, $this->secret_key);

        return $payloadEncoded . '.' . $signature;
    }

    protected function get_adaptive_difficulty(): int
    {
        $ua = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
        $score = 0;
        $botSignatures = ['bot','crawl','spider','curl','wget','python','aiohttp','scrapy','scanner','postman'];
        foreach ($botSignatures as $sig) {
            if (strpos($ua, $sig) !== false) $score++;
        }
        $base = (int) $this->settings['difficulty'];
        if ($score >= 3) return min(6, $base + 2);
        if ($score >= 1) return min(5, $base + 1);
        return max(3, $base);
    }

    protected function user_agent_hash(): string
    {
        return hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? '');
    }

    protected function get_user_ip(): string
    {
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($ips[0]);
        }
        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    protected function cache_save(string $key, $value, int $ttl): void
    {
        $cachePath = WRITEPATH . 'cache/data/captcha';
        if (!is_dir($cachePath)) {
            @mkdir($cachePath, 0775, true);
            @fopen($cachePath . '/index.html', "w");
        }
        @chmod($cachePath, 0775);

        $this->CI->cache->save('captcha/captcha_' . $key, $value, $ttl);
    }

    protected function cache_get(string $key)
    {
        return $this->CI->cache->get('captcha/captcha_' . $key);
    }

    protected function base64url_encode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    protected function base64url_decode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }

    protected function get_or_generate_secret_key(): string
    {
        $existing = $this->cache_get('secret_key');
        if ($existing && is_string($existing)) {
            return $existing;
        }

        $newKey = bin2hex(random_bytes(32));
        $this->cache_save('secret_key', $newKey, 86400 * 365);
        return $newKey;
    }
}