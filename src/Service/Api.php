<?php
/**
 * Created by PhpStorm.
 * User: syfea
 * Date: 03/05/19
 * Time: 14:26
 */

namespace App\Service;

use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Api
{
    static private $apiSyfea = '';
    static private $apiSyfeaIdBlog ='';
    private $token = NULL;
    private $client;
    private $user;

    public function __construct()
    {
        if(is_null($this->token)) {
            SELF::$apiSyfea = getenv('API_SYFEA');
            SELF::$apiSyfeaIdBlog = getenv('API_SYFEA_ID_BLOG');

            $this->client = new Client(['base_uri' => SELF::$apiSyfea]);
            $response = $this->client->post('/login_check', [
                'form_params' => [
                    '_username' => getenv('USERNAME_API'),
                    '_password' => getenv('PASSWORD_API'),
                ]
            ]);

            if ( $response->getStatusCode() != 200) {
                $this->__destruct();
            } else {
                $obj = json_decode($response->getBody()->getContents());
                $this->token = $obj->token;
                $this->user = $this->getUser(getenv('USERNAME_API'));
            }
        }
    }

    /**
     * @return string
     */
    public function getApiSyfea(): string
    {
        return self::$apiSyfea;
    }

    private function getHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept'        => 'application/json',
        ];
    }

    protected function getUser($username)
    {
        $response = $this->client->get('/users', [
            'headers' => $this->getHeaders(),
            'query' => [
                'username' => $username,
            ],
        ]);
        $users = json_decode($response->getBody()->getContents());

        return  $users[0];
    }

    public function getCategory()
    {
        $response = $this->client->request('GET', '/categories/'.SELF::$apiSyfeaIdBlog, [
            'headers' => $this->getHeaders()
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function postArticle($params)
    {
        $response = $this->client->post('/articles', [
            'headers' => $this->getHeaders(),
            'json' => [
                'title' => $params['title'],
                'content' => $params['content'],
                'priority' => (int)$params['priority'],
                'user' => '/users/'.$this->user->id,
                'category' => '/categories/'.SELF::$apiSyfeaIdBlog,
                'image' => $params['image']
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function getArticle($id = 0)
    {
        $response = $this->client->request('GET', '/articles/'.$id, [
            'headers' => $this->getHeaders()
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function putArticle($params, $id = 0)
    {
        $image = $params['image'];
        if($params['image'] == '') {
            $image = null;
        }
        $this->client->put('/articles/'.$id, [
            'headers' => $this->getHeaders(),
            'json' => [
                'title' => $params['title'],
                'content' => $params['content'],
                'priority' => (int)$params['priority'],
                'image' => $image
            ],
        ]);
    }

    public function deleteArticle($id = 0)
    {
        $this->client->delete('/articles/'.$id, [
            'headers' => $this->getHeaders()
        ]);
    }

    public function getImages()
    {
        $response = $this->client->request('GET', '/media_objects', [
            'headers' => $this->getHeaders()
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function getImageUrl($image)
    {
        if ($image == '') {
            return null;
        }

        $response = $this->client->request('GET', SELF::$apiSyfea . $image, [
            'headers' => $this->getHeaders()
        ]);
        $image = json_decode($response->getBody()->getContents());

        if (!is_object($image)) {
            return null;
        }
//dump($image);
  //      exit();
        return SELF::$apiSyfea.$image->contentUrl;
    }
}