<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required',
            'category' => 'required',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'nullable|boolean',
            'article_steps' => 'nullable|string'
        ]);

        // Handle is_published checkbox
        $validated['is_published'] = $request->has('is_published');

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        // Proses data langkah-langkah
        $steps = null;
        if (!empty($validated['article_steps'])) {
            $steps = json_decode($validated['article_steps'], true);
        }
        
        // Simpan setiap gambar langkah
        if (is_array($steps) && count($steps) > 0) {
            $newSteps = [];
            foreach ($steps as $step) {
                if (isset($step['image_file']) && !empty($step['image_file'])) {
                    try {
                        $base64Image = $step['image_file'];
                        // Handle base64 image data
                        if (strpos($base64Image, 'data:image') === 0) {
                            list($type, $base64Image) = explode(';', $base64Image);
                            list(, $base64Image) = explode(',', $base64Image);
                            $image = base64_decode($base64Image);
                            
                            // Determine file extension from mime type
                            $mime = str_replace('data:image/', '', $type);
                            $extension = $mime;
                            if ($mime === 'jpeg') $extension = 'jpg';
                            
                            $imageName = 'articles/steps/' . Str::random(40) . '.' . $extension;
                            Storage::disk('public')->put($imageName, $image);
                            $step['image_path'] = $imageName;
                        }
                    } catch (\Exception $e) {
                        // If image processing fails, continue without image
                        \Log::warning('Failed to process step image: ' . $e->getMessage());
                    }
                }
                unset($step['image_file']); // Hapus data file agar tidak tersimpan di DB
                $newSteps[] = $step;
            }
            $validated['article_steps'] = json_encode($newSteps);
            $validated['content'] = $this->generateContentFromSteps($newSteps);
        } else {
            $validated['article_steps'] = null;
            // If no steps, use excerpt as content
            if (empty($validated['content'])) {
                $validated['content'] = $validated['excerpt'];
            }
        }

        // Handle tags - convert string to array
        if (!empty($validated['tags']) && is_string($validated['tags'])) {
            $tags = array_map('trim', explode(',', $validated['tags']));
            $validated['tags'] = array_filter($tags); // Remove empty tags
        }

        // Set published_at if publishing
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Buat dan simpan artikel
        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required',
            'category' => 'required',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'nullable|boolean',
            'article_steps' => 'nullable|string'
        ]);

        // Handle is_published checkbox
        $validated['is_published'] = $request->has('is_published');
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Hapus gambar lama jika ada
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        // Proses data langkah-langkah
        $steps = null;
        if (!empty($validated['article_steps'])) {
            $steps = json_decode($validated['article_steps'], true);
        }
        
        // Simpan setiap gambar langkah
        if (is_array($steps) && count($steps) > 0) {
            $newSteps = [];
            foreach ($steps as $step) {
                // If step has existing image_path, keep it unless new image is uploaded
                if (isset($step['image_file']) && !empty($step['image_file'])) {
                    try {
                        $base64Image = $step['image_file'];
                        // Handle base64 image data
                        if (strpos($base64Image, 'data:image') === 0) {
                            // Delete old image if exists
                            if (isset($step['image_path']) && $step['image_path']) {
                                Storage::disk('public')->delete($step['image_path']);
                            }
                            
                            list($type, $base64Image) = explode(';', $base64Image);
                            list(, $base64Image) = explode(',', $base64Image);
                            $image = base64_decode($base64Image);
                            
                            // Determine file extension from mime type
                            $mime = str_replace('data:image/', '', $type);
                            $extension = $mime;
                            if ($mime === 'jpeg') $extension = 'jpg';
                            
                            $imageName = 'articles/steps/' . Str::random(40) . '.' . $extension;
                            Storage::disk('public')->put($imageName, $image);
                            $step['image_path'] = $imageName;
                        }
                    } catch (\Exception $e) {
                        // If image processing fails, continue without image
                        \Log::warning('Failed to process step image: ' . $e->getMessage());
                    }
                }
                unset($step['image_file']); // Hapus data file agar tidak tersimpan di DB
                $newSteps[] = $step;
            }
            $validated['article_steps'] = json_encode($newSteps);
            $validated['content'] = $this->generateContentFromSteps($newSteps);
        } else {
            $validated['article_steps'] = null;
            // If no steps, use excerpt as content
            if (empty($validated['content'])) {
                $validated['content'] = $validated['excerpt'];
            }
        }

        // Handle tags - convert string to array
        if (!empty($validated['tags']) && is_string($validated['tags'])) {
            $tags = array_map('trim', explode(',', $validated['tags']));
            $validated['tags'] = array_filter($tags); // Remove empty tags
        }

        // Set published_at if publishing
        if ($validated['is_published'] && empty($article->published_at)) {
            $validated['published_at'] = now();
        }

        // Perbarui artikel
        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        // Delete featured image
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();
        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }

    /**
     * Generate readable content from steps array
     */
    private function generateContentFromSteps($steps)
    {
        if (empty($steps)) return '';

        $content = '';
        foreach ($steps as $step) {
            if (empty($step['title']) && empty($step['explanation'])) continue;
            
            // Add step title as heading
            if (!empty($step['title'])) {
                $stepNumber = $step['step_number'] ?? '';
                $content .= "## {$stepNumber}. " . $step['title'] . "\n\n";
            }
            
            // Add explanation
            if (!empty($step['explanation'])) {
                $content .= $step['explanation'] . "\n\n";
            }
            
            // Add code block if exists
            if (!empty($step['code'])) {
                $language = $step['code_language'] ?? 'php';
                $content .= "```{$language}\n" . $step['code'] . "\n```\n\n";
            }
            
            // Add image placeholder if exists
            if (!empty($step['image_alt'])) {
                $content .= "*[Screenshot: " . $step['image_alt'] . "]*\n\n";
            }
            if (!empty($step['image_path'])) {
                $content .= "![" . ($step['image_alt'] ?? '') . "](" . asset('storage/'.$step['image_path']) . ")\n\n";
            }
        }

        return $content;
    }
}
