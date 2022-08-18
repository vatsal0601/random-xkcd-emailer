<?php

declare(strict_types=1);

namespace App;

class Email
{
    public string $name;
    public string $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    private function get_random_comic_number(): string
    {
        $url = 'https://c.xkcd.com/random/comic';
        $headers = get_headers($url, true);
        return basename($headers['Location'][1]);
    }

    public function get_random_comic(): array
    {
        $random = $this->get_random_comic_number();
        $url = "https://xkcd.com/{$random}/info.0.json";

        $ch = curl_init();
        curl_setopt_array($ch, [CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true]);
        $res = curl_exec($ch);
        $res = json_decode($res);
        curl_close($ch);
        return ['title' => $res->safe_title, 'url' => $res->img, 'alt' => $res->alt];
    }

    private function send_email(array $payload): void
    {
        $info = ['to' => $this->email, 'name' => $this->name];
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL => $_ENV['GOOGLE_APP_SCRIPT_URL'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => http_build_query(array_merge($info, $payload))
            ]
        );
        $res = curl_exec($ch);
        $res = json_decode($res);
        curl_close($ch);
    }

    public function send_token(string $token): void
    {
        $this->send_email(['type' => 'token', 'subject' => 'Registration token for Emaaail', 'token' => $token]);
    }

    public function send_comic(string $title, string $alt, string $url): void
    {
        $this->send_email(['type' => 'comic', 'subject' => 'Emaaail Random Comic', 'title' => $title, 'alt' => $alt, 'url' => $url]);
    }
}
