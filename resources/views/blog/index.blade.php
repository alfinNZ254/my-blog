@extends('layouts.app')

@section('title', 'Home')
@section('description', 'Blog tutorial programming dan teknologi terbaru')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/20 via-purple-500/10 to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 gradient-text">
                Learn. Code. Build.
            </h1>
            <p class="text-xl md:text-2xl text-gray-300 mb-8 leading-relaxed">
                Tutorial, tips & tricks teknologi 
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#articles" class="bg-primary hover:bg-primary/80 px-8 py-3 rounded-lg font-semibold transition-all hover-lift">
                    <i class="fas fa-rocket mr-2"></i>Mulai Belajar
                </a>
                <a href="#" class="bg-transparent border border-gray-600 hover:border-primary px-8 py-3 rounded-lg font-semibold transition-all hover-lift">
                    <i class="fab fa-github mr-2"></i>View GitHub
                </a>
                <a href="https://linkedin.com/in/alfinzamjaro" target="_blank" class="bg-primary hover:bg-primary/80 px-8 py-3 rounded-lg font-semibold transition-all hover-lift">
                    <i class="fab fa-linkedin mr-2"></i>LinkedIn
                </a>
            </div>
        </div>
    </div>
    
    <!-- Animated background elements -->
    <div class="absolute top-20 left-10 w-20 h-20 bg-primary/20 rounded-full blur-xl animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-32 h-32 bg-purple-500/20 rounded-full blur-xl animate-pulse"></div>
</section>

<!-- Categories Section -->
<section class="py-12 bg-dark-200/50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8">
            <i class="fas fa-tags mr-2 text-primary"></i>Kategori Tutorial
        </h2>
        <div class="flex flex-wrap justify-center gap-4">
            @foreach($categories as $category)
            <a href="{{ route('blog.category', $category) }}" 
               class="bg-dark-100 hover:bg-primary/20 border border-gray-800 hover:border-primary px-6 py-3 rounded-full transition-all hover-lift">
                <i class="fas fa-folder mr-2"></i>{{ $category }}
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Articles Section -->
<section id="articles" class="py-20">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12">
            <i class="fas fa-newspaper mr-2 text-primary"></i>Latest Articles
        </h2>
        
        @if($articles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $article)
            <article class="bg-dark-100 rounded-xl overflow-hidden border border-gray-800 hover:border-primary/50 transition-all hover-lift">
                @if($article->featured_image)
                <div class="aspect-video bg-gradient-to-br from-primary/20 to-purple-500/20 relative overflow-hidden">
                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                         alt="{{ $article->title }}"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 left-4">
                        <span class="bg-primary/80 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $article->category }}
                        </span>
                    </div>
                </div>
                @else
                <div class="aspect-video bg-gradient-to-br from-primary/20 to-purple-500/20 flex items-center justify-center">
                    <i class="fas fa-code text-6xl text-primary/50"></i>
                </div>
                @endif
                
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-3 line-clamp-2 hover:text-primary transition-colors">
                        <a href="{{ route('blog.show', $article) }}">{{ $article->title }}</a>
                    </h3>
                    <p class="text-gray-400 mb-4 line-clamp-3">{{ $article->excerpt }}</p>
                    
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <div class="flex items-center space-x-4">
                            <span><i class="far fa-calendar mr-1"></i>{{ $article->published_at->format('d M Y') }}</span>
                            <span><i class="far fa-clock mr-1"></i>{{ $article->reading_time }} min read</span>
                        </div>
                    </div>
                    
                    @if($article->tags)
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach(array_slice($article->tags, 0, 3) as $tag)
                        <span class="bg-gray-800 px-2 py-1 rounded text-xs">
                            #{{ $tag }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                    
                    <a href="{{ route('blog.show', $article) }}" 
                       class="inline-flex items-center text-primary hover:text-primary/80 font-semibold transition-colors">
                        Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($articles->hasPages())
        <div class="mt-12 flex justify-center">
            <div class="bg-dark-100 rounded-lg border border-gray-800 p-1">
                {{ $articles->links('pagination::tailwind') }}
            </div>
        </div>
        @endif
        
        @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="w-32 h-32 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-newspaper text-6xl text-primary/50"></i>
            </div>
            <h3 class="text-2xl font-semibold mb-4">Belum Ada Artikel</h3>
            <p class="text-gray-400 mb-8">Artikel tutorial akan segera hadir!</p>
        </div>
        @endif
    </div>
</section>

<!-- Newsletter Section -->
<!-- <section class="py-20 bg-gradient-to-r from-primary/10 to-purple-500/10">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">
                <i class="fas fa-envelope mr-2 text-primary"></i>Stay Updated
            </h2>
            <p class="text-gray-400 mb-8">
                Dapatkan notifikasi untuk tutorial dan artikel terbaru langsung ke email Anda
            </p>
            <form class="flex flex-col sm:flex-row gap-4">
                <input type="email" 
                       placeholder="Masukkan email Anda"
                       class="flex-1 px-4 py-3 bg-dark-100 border border-gray-800 rounded-lg focus:border-primary focus:outline-none transition-colors">
                <button type="submit" 
                        class="bg-primary hover:bg-primary/80 px-8 py-3 rounded-lg font-semibold transition-all hover-lift">
                    <i class="fas fa-paper-plane mr-2"></i>Subscribe
                </button>
            </form>
        </div>
    </div>
</section> -->

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}
</style>
@endsection
