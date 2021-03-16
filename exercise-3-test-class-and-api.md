# Exercice 3 : Tester un appel API

Cet exercice a pour objectif : 
* de tester un appel API (dans le cadre d'un test d'integration ou d'une exposition d'API)

## Envoyer des données à une API locale via un client Guzzle
* Ici nous utilisons Guzzle comme client pour éxécuter des requêtes HTTP 
* Déclarer une nouvelle classe de test APITest dans le dossier tests
* Celle-ci contient : 
<?php
namespace App\tests;

class APITest extends \PHPUnit_Framework_TestCase
{
public function testPOST()
{
    // create our http client (Guzzle)
    $client = new Client('http://localhost:8000', array(
        'request.options' => array(
            'exceptions' => false,
        )
    ));

    $nickname = 'ObjectOrienter'.rand(0, 999);
    $data = array(
        'nickname' => $nickname,
        'avatarNumber' => 5,
        'tagLine' => 'a test dev!'
    );

    $request = $client->post('/api/programmers', null, json_encode($data));
    $response = $request->send();

    $this->assertEquals(201, $response->getStatusCode());
    $this->assertTrue($response->hasHeader('Location'));
    $data = json_decode($response->getBody(true), true);
    $this->assertArrayHasKey('nickname', $data);
}
* Cet exemple nous montre à la fois comment tester l'envoi d'une requête API HTTP au format JSON.
* Mais aussi lorsque l'on récupère la réponse, comment vérifier que les données attendues sont bien présentes.

## Et si on veut simuler la réponse avec un mock ?

* Voici un autre exemple où l'on crée un mock pour simuler une réponse d'API : 
```php
<?php
require __DIR__ . "/../../vendor/autoload.php";

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class DocumentTest extends \PHPUnit\Framework\TestCase
{
    public function setUp() {
        // create the first request to check we can connect, can be added to
        // the mocks for any test that wants it
        $couchdb1 = '{"couchdb":"Welcome","version":"2.0.0","vendor":{"name":"The Apache Software Foundation"}}';
        $this->db_response = new Response(200, [], $couchdb1);

        // offer a use_response for when selecting this database
        $egdb1 = '{"db_name":"egdb","update_seq":"0-g1AAAABXeJzLYWBgYMpgTmEQTM4vTc5ISXLIyU9OzMnILy7JAUklMiTV____PyuRAY-iPBYgydAApP5D1GYBAJmvHGw","sizes":{"file":8488,"external":0,"active":0},"purge_seq":0,"other":{"data_size":0},"doc_del_count":0,"doc_count":0,"disk_size":8488,"disk_format_version":6,"data_size":0,"compact_running":false,"instance_start_time":"0"}';
        $this->use_response = new Response(200, [], $egdb1);

        $create = '{"ok":true,"id":"abcde12345","rev":"1-928ec193918889e122e7ad45cfd88e47"}';
        $this->create_response = new Response(201, [], $create);
        $fetch = '{"_id":"abcde12345","_rev":"1-928ec193918889e122e7ad45cfd88e47","noise":"howl"}';
        $this->fetch_response = new Response(200, [], $fetch);
    }

    /**
     * @expectedException \PHPCouchDB\Exception\DocumentConflictException
     */
    public function testDeleteConflict() {
        $delete = '{"error":"conflict","reason":"Document update conflict."}';
        $delete_response = new Response(409, [], $delete);

        $mock = new MockHandler([ $this->db_response, $this->use_response, $this->create_response, $this->fetch_response, $delete_response ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        // userland code starts
        $server = new \PHPCouchDB\Server(["client" => $client]);
        $database = $server->useDB(["name" => "egdb"]);
        $doc = $database->create(["noise" => "howl", "id" => "abcde12345"]);

        $result = $doc->delete();
    }
}
```

--> Vous savez maintenant tester un appel API et même mocker ses réponses pour ne pas dépendre de l'API distante