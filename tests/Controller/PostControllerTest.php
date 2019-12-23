<?php

namespace App\tests\Controller;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Doctrine\ORM\Tools\SchemaTool;

Class PostControllerTest extends WebTestCase {
private EntityManagerInterface $em;
private KernelBrowser $client;

public function setUp(): void {
    $this->client = self::createClient();
    $this->em = self::$kernel->getContainer()->get('doctrine')->getManager();   
    //CRIA A FERRAMENTA PARA MANIPULAÇÃO DO BANCO DE DADOS
    $tool = new SchemaTool($this->em);

    //recupera a tabela associada a entidade post
    $metadata = $this->em->getClassMetadata(Post::class);

    //apaga a tabela associada a entidade post
    $tool->dropSchema([$metadata]);

    try {
        //cria a tabela post
        $tool->createSchema([$metadata]);
    } catch (ToolsExceptions $e) {
        $this->fail("Impossivel criar a tabela post". $e->getMessage());
    }
}    

public function test_create_post(): void {
    $this->client->request('POST','/posts', [], [], [], json_encode([
    'title' => 'Minha primeira aplicação com symfony',
    'description' => 'Descrição da minha primeira aplicação'
    ]));
    $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
}

public function test_delete_post(): void {
    $post = new Post("fake", "fake");
    $this->em->persist($post);
    $this->em->flush();
    
    $this->client->request('DELETE','/posts/1');
    $this->assertEquals(Response::HTTP_NO_CONTENT, $this->client->getResponse()->getStatusCode());
}

public function test_create_post_with_invalid_title():void{
    $this->client->request('POST', '/posts',[],[],[], json_encode([
        'title'=> null,
        'description'=>'alguma descrição'
    ]));
    $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
}
public function test_update_post(): void {
    $post = new Post("fake", "fake");
    $this->em->persist($post);
    $this->em->flush();
    
    $this->client->request('PUT','/posts/1', [], [], [], json_encode([
        'title' => 'altera titulo',
        'description' => 'altera descricao'
        ]));    
    $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
}

public function test_list_all_post(): void
{
    $post = new Post("fake", "fake");
    $this->em->persist($post);
    $this->em->flush();

    $this->client->request('GET', '/posts', [], [], [], null);
    $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
}

public function test_list_post(): void
{
    $post = new Post("fake", "fake");
    $this->em->persist($post);
    $this->em->flush();

    $this->client->request('GET', '/posts/1', [], [], [], null);
    $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
}

}