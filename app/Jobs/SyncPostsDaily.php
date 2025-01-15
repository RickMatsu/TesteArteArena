<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\Item;

class SyncPostsDaily implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Executa o Job.
     */
    public function handle()
    {
        try {
            // Faz a requisição para a API
            $response = Http::get('https://jsonplaceholder.typicode.com/posts');

            if ($response->failed()) {
                throw new \Exception('Erro ao conectar à API');
            }

            $posts = $response->json();

            foreach ($posts as $post) {
                Item::updateOrCreate(
                    ['id' => $post['id']],
                    [
                        'title' => $post['title'],
                        'body' => $post['body'],
                    ]
                );
            }

            // Registrar logs no banco (exemplo)
            \DB::table('sync_logs')->insert([
                'processed_records' => count($posts),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Erro na sincronização diária: ' . $e->getMessage());
        }
    }
}
