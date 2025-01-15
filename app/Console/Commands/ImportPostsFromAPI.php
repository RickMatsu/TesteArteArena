<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Item;

class ImportPostsFromAPI extends Command
{
    protected $signature = 'import:posts';
    protected $description = 'Importa posts da API JSONPlaceholder';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $cachedPosts = cache()->get('posts_data');
    
        if (!$cachedPosts) {
            $response = Http::get('https://jsonplaceholder.typicode.com/posts');
            $cachedPosts = $response->json();
            cache()->put('posts_data', $cachedPosts, 86400); // Cache por 24 horas
        }
    
        foreach ($cachedPosts as $post) {
            Item::updateOrCreate(
                ['id' => $post['id']],
                ['title' => $post['title'], 'body' => $post['body']]
            );
        }
    
        $this->info('Posts importados com sucesso!');
        
    }

}
