{{-- resources/views/blog/category.blade.php --}}
@extends('layouts.app')

@section('title', 'Kategori: ' . $category)
@section('description', 'Artikel tutorial dalam kategori ' . $category)

@section('content')
<section class="py-16 bg-gradient-to-br from-primary/10 via-purple-500/5 to-transparent relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/20 via-purple-500/10 to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <nav class="mb-8">
                <ol class="flex items-center justify-center space-x-2 text-sm text-gray-400">
                    <li><a href="{{ route('blog.index') }}" class="hover:text-primary transition-colors">Home</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><span class="text-gray-300">Kategori</span></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-primary">{{ $category }}</li>
                </ol>
            </nav>

            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-primary to-purple-600 rounded-full flex items-center justify-center shadow-lg hover-lift transition-transform">
                <i class="fas fa-code text-3xl"></i>
            </div>

            <h1 class="text-4xl md:text-5xl font-extrabold gradient-text leading-tight mb-4">{{ $category }}</h1>
            <p class="text-lg md:text-xl text-gray-400 mb-8">
                Temukan berbagai artikel menarik seputar **{{ $category }}**
            </p>
        </div>
    </div>
</section>

<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($articles as $article)
                <div class="article-card bg-dark-100 rounded-xl overflow-hidden border border-gray-800 p-6 shadow-xl hover-lift">
                    @if ($article->featured_image)
                    <a href="{{ route('blog.show', $article->slug) }}">
                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover rounded-lg mb-6 shadow-md">
                    </a>
                    @endif

                    <div class="flex items-center text-sm text-gray-400 mb-2">
                        <span class="bg-primary/20 text-primary px-3 py-1 rounded-full text-sm font-semibold mr-2">{{ $article->category }}</span>
                        <span class="flex items-center mr-4">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $article->reading_time }} menit
                        </span>
                        @php
                            $articleSteps = $article->getArticleStepsArray();
                        @endphp
                        @if (!empty($articleSteps))
                        <span class="flex items-center text-primary">
                            <i class="fas fa-list-ol mr-1"></i>
                            {{ count($articleSteps) }} Langkah
                        </span>
                        @endif
                    </div>
                    
                    <a href="{{ route('blog.show', $article->slug) }}" class="block">
                        <h2 class="text-xl md:text-2xl font-bold mb-2 leading-tight hover:text-primary transition-colors line-clamp-2">
                            {{ $article->title }}
                        </h2>
                    </a>
                    <p class="text-gray-400 mb-4 line-clamp-3">{{ $article->excerpt }}</p>
                    
                    <div class="flex items-center text-sm text-gray-400">
                        @if ($article->author->profile_photo_path ?? false)
                        <img src="{{ asset('storage/' . $article->author->profile_photo_path) }}" alt="{{ $article->author->name }}" class="w-8 h-8 rounded-full mr-2">
                        @else
                        <img src="{{ asset('images/profile-placeholder.jpg') }}" alt="Penulis" class="w-8 h-8 rounded-full mr-2">
                        @endif
                        <span class="font-semibold">{{ $article->author->name ?? 'Admin' }}</span>
                        <span class="ml-auto text-xs">{{ $article->published_at->format('d M Y') }}</span>
                    </div>
                </div>
                @empty
                <div class="lg:col-span-3 text-center py-16 text-gray-400">
                    <i class="fas fa-search-minus text-5xl mb-4"></i>
                    <h2 class="text-2xl font-semibold mb-2">Artikel Tidak Ditemukan</h2>
                    <p>Tidak ada artikel yang diterbitkan dalam kategori ini.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-12 flex justify-center">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// JavaScript untuk animasi fade-in
const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1 // Pemicu animasi saat 10% elemen terlihat
};

const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.querySelectorAll('.article-card').forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(card);
});
</script>
@endpush

<style>
.gradient-text {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hover-lift:hover {
    transform: translateY(-4px);
}

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

.view-btn.active {
    background: #3b82f6;
    color: white;
}

.view-btn:not(.active) {
    color: #9ca3af;
}

.view-btn:not(.active):hover {
    color: #3b82f6;
}

/* Custom pagination styles */
.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
}

.page-item {
    margin: 0 4px;
}

.page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 12px;
    border-radius: 9999px;
    background-color: #1e293b;
    border: 1px solid #334155;
    color: #9ca3af;
    font-weight: 600;
    transition: all 0.2s;
}

.page-link:hover {
    background-color: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.page-item.active .page-link {
    background-color: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.page-link[rel="prev"],
.page-link[rel="next"] {
    background-color: transparent;
    border-color: transparent;
}

.page-link[rel="prev"]:hover,
.page-link[rel="next"]:hover {
    background-color: #334155;
    color: #3b82f6;
}
</style>
