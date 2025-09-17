<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class virtue {
    private $token = 'YOUR_TOKEN';
    private $endpoint = 'https://api.tlotl.cyou/get?token=';
    private $url;
    private $data = [];

    public function __construct($qry, $text = '') {
        $virt = false;
        $this->url = $this->endpoint . $this->token . '&q=' . $qry;
        $sess = '';
        $response = '';
        $data = false;

        switch ($qry) {
            case 'week':
                $sess = 'votw';
                $response = $_SESSION[$sess] ?? $this->fetch();
                $data = json_decode($response, true);
                break;

            case 'day':
                $sess = 'votd';
                $response = $_SESSION[$sess] ?? $this->fetch();
                $data = json_decode($response, true);
                break;

            case 'one':
                $this->url .= '&title=' . $text;
                $sess = 'virtue';
                if (isset($_SESSION[$sess])) {
                    $set = json_decode($_SESSION[$sess], true);
                    if (strtoupper($set['title']) === strtoupper($text)) {
                        $response = $_SESSION[$sess];
                    } else {
                        $response = $this->fetch();
                    }
                } else {
                    $response = $this->fetch();
                }
                $data = json_decode($response, true);
                break;

            case 'tone':
                $this->url .= '&title=' . $text;
                $sess = 'vtone';
                if (isset($_SESSION[$sess])) {
                    $set = json_decode($_SESSION[$sess], true);
                    if (strtoupper($set[0]['tone']) === strtoupper($text)) {
                        $response = $_SESSION[$sess];
                    } else {
                        $response = $this->fetch();
                    }
                } else {
                    $response = $this->fetch();
                }
                $data = json_decode($response, true);
                break;

            case 'pairings':
                $sess = 'pairings';
                $response = $this->fetch();
                $data = json_decode($response, true);
                break;
        }

        if ($data !== false) {
            if (isset($data['error'])) {
                $this->data = $data;
            } else {
                $_SESSION[$sess] = $response;
                $virt = $this->setVirt($data);
                $this->data = $virt;
            }
        } else {
            $this->data = json_decode($response, true);
        }
    }

    private function supportsWebP(): bool {
        return isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false;
    }

    private function isWebp(): array {
        $supportsWebP = $this->supportsWebP();
        return [
            'png' => $supportsWebP ? 'webp' : 'png',
            'jpg' => $supportsWebP ? 'webp' : 'jpg'
        ];
    }

    private function setVirt($votw) {
        $wb = $this->isWebp();
        $cdn = "https://im.tlotl.cyou/vw/";
        $votw['ghbtn'] = $cdn . "7/";
        $votw['vlbtn'] = $cdn . "8/" . $wb['png'];
        $votw['logo'] = $cdn . "5/" . $wb['png'];
        $votw['bgimage'] = $cdn . "4/" . $wb['jpg'];
        $votw['character'] = $votw['icon'];
        $ic = $this->setIcon($votw['icon']);
        $votw['icon'] = $cdn . $ic . "/" . $wb['png'];
        return $votw;
    }

    private function setIcon($icon) {
        switch ($icon) {
            case 'lion': return 1;
            case 'lamb': return 2;
            case 'both': return 3;
            default: return 2;
        }
    }

    private function fetch() {
        $response = false;
        $curlError = null;
        $fallbackError = null;

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false || empty($response)) {
            $response = @file_get_contents($this->url);
            if ($response === false || empty($response)) {
                $fallbackError = error_get_last();
                $response = json_encode([
                    'error' => 'Unable to fetch data via cURL and file_get_contents',
                    'curl_error' => $curlError,
                    'fallback_error' => $fallbackError['message'] ?? 'Unknown file_get_contents error'
                ]);
                // $this->logError($response); // Uncomment to enable logging
            }
        }

        return $response;
    }

    // Optional logging method
    private function logError($message) {
        $logfile = __DIR__ . '/virtue_error.log';
        $entry = "[" . date('Y-m-d H:i:s') . "] " . $message . "\n";
        file_put_contents($logfile, $entry, FILE_APPEND);
    }

    public function get() {
        return $this->data;
    }

    public function hasError(): bool {
        return isset($this->data['error']);
    }

    public function debug(): array {
        return $this->data;
    }
}
