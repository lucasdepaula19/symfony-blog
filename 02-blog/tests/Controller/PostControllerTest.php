<?php

namespace App\Tests\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;
use Doctrine\ORM\EntityManagerInterface;

class PostControllerTest extends WebTestCase{

    private EntityManagerInterface $em;
    private KernelBrowser $client;

    public function setUp(): void{
        $this->client = self::createClient();
        $this->em = self::$kernel->getContainer()->get('doctrine')->getManager();
        $tool = new SchemaTool($this->em);
        $metadata = $this->em->getClassMetadata(Post::class);
        $tool->dropSchema([$metadata]);

        try{
            $tool->createSchema([$metadata]);
        }catch(ToolsException $e){
            $this->fail("Impossivel criar tabela Post: ", $e->getMessage());
        }
    }

    public function test_create_post(): void{
        // $client = static::createClient();
        $this->client->request('POST', '/posts', [], [], [], \json_encode([
            'title' => 'Primeiro teste funcional',
            'description' => 'Alguma descrição'
        ]));
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function test_delete_post(): void{
        // $client = static::createClient();

        // $this->client->request('POST', '/posts', [],[],[],json_encode([
        //     'title' => 'post de teste',
        //     'description' => 'descrição de teste'
        // ]));
        // $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        // $varTeste = $this->client->getResponse();

        $post = new Post('titulo de teste', 'descriçaõ de teste');
     
        $this->em->persist($post);
        $this->em->flush();

        // dump($post->getId());
        $this->client->request('DELETE', '/posts/'.$post->getId());
        $this->assertEquals(Response::HTTP_NO_CONTENT, $this->client->getResponse()->getStatusCode());
    }

    public function test_create_post_with_invalid_title(): void{
        $this->client->request('POST', '/posts',[],[],[], json_encode([
            // 'title' => 1234,
            'description' => null
        ]));
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function test_update_post(): void {
        $post = new Post("teste", "teste");
        $this->em->persist($post);
        $this->em->flush();
        
        $this->client->request('PUT','/posts/1', [], [], [], json_encode([
            'title' => 'novo titulo',
            'description' => 'nova descricao'
            ]));    
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
    
    // public function test_list_all_post(): void {
    //     $post = new Post("teste", "teste");
    //     $this->em->persist($post);
    //     $this->em->flush();
    
    //     $this->client->request('GET', '/posts', [], [], [], null);
    //     $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    // }
    
    // public function test_list_post(): void{
    //     $post = new Post("teste", "teste");
    //     $this->em->persist($post);
    //     $this->em->flush();
    
    //     $this->client->request('GET', '/posts/1', [], [], [], null);
    //     $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    // }

}