<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $articles = Article::published()
            ->orderBy('published_at', 'desc')
            ->paginate(6);
            
        $categories = Article::published()
            ->select('category')
            ->distinct()
            ->pluck('category');
            
        return view('blog.index', compact('articles', 'categories'));
    }

    public function show(Article $article)
    {
        if (!$article->is_published) {
            abort(404);
        }

        $relatedArticles = Article::published()
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->take(3)
            ->get();

        return view('blog.show', compact('article', 'relatedArticles'));
    }

    public function category($category)
    {
        $articles = Article::published()
            ->where('category', $category)
            ->orderBy('published_at', 'desc')
            ->paginate(6);

        return view('blog.category', compact('articles', 'category'));
    }
}
