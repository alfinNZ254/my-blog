{{-- Update resources/views/blog/show.blade.php untuk menampilkan steps --}}

@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->excerpt)

@section('content')
<!-- Article Header - sama seperti sebelumnya -->
<section class="py-12 bg-dark-200/50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm text-gray-400">
                    <li><a href="{{ route('blog.index') }}" class="hover:text-primary transition-colors">Home</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('blog.category', $article->category) }}" class="hover:text-primary transition-colors">{{ $article->category }}</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-gray-300">{{ $article->title }}</li>
                </ol>
            </nav>
            
            <!-- Article Meta -->
            <div class="mb-6">
                <span class="bg-primary/20 text-primary px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $article->category }}
                </span>
            </div>
            
            <!-- Title -->
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                {{ $article->title }}
            </h1>
            
            <!-- Article Info -->
            <div class="flex flex-wrap items-center gap-6 text-gray-400 mb-8">
                <div class="flex items-center">
                    <i class="far fa-calendar mr-2"></i>
                    <span>{{ $article->published_at->format('d M Y') }}</span>
                </div>
                <div class="flex items-center">
                    <i class="far fa-clock mr-2"></i>
                    <span>{{ $article->reading_time }} menit baca</span>
                </div>
                @if($article->steps_count > 0)
                <div class="flex items-center">
                    <i class="fas fa-list-ol mr-2"></i>
                    <span>{{ $article->steps_count }} langkah</span>
                </div>
                @endif
                <div class="flex items-center">
                    <i class="far fa-eye mr-2"></i>
                    <span>1.2k views</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Image -->
@if($article->featured_image)
<section class="mb-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="aspect-video rounded-xl overflow-hidden bg-gradient-to-br from-primary/20 to-purple-500/20">
                <img src="{{ asset('storage/' . $article->featured_image) }}" 
                     alt="{{ $article->title }}"
                     class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>
@endif

<!-- Article Content -->
<article class="pb-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Excerpt/Summary -->
                    <div class="bg-gradient-to-r from-primary/10 to-purple-500/10 rounded-xl p-6 mb-8 border border-primary/20">
                        <h3 class="text-xl font-semibold mb-3 text-primary">
                            <i class="fas fa-info-circle mr-2"></i>Ringkasan Tutorial
                        </h3>
                        <p class="text-gray-300 leading-relaxed">{{ $article->excerpt }}</p>
                    </div>

                    @php
                        $steps = $article->getArticleStepsArray();
                    @endphp
                    @if(!empty($steps))
                        <!-- Step-based Content -->
                        <div class="space-y-8">
                            @foreach($steps as $index => $step)
                                <div class="step-container bg-dark-100/50 rounded-xl p-8 border border-gray-800 relative">
                                    <!-- Step Number -->
                                    <div class="flex items-start mb-6">
                                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-primary to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4 shadow-lg">
                                            {{ $step['step_number'] ?? ($index + 1) }}
                                        </div>
                                        <div class="flex-1">
                                            <h2 class="text-2xl font-semibold text-white mb-4">{{ $step['title'] ?? 'Step ' . ($index + 1) }}</h2>
                                        </div>
                                    </div>
                                    
                                    <!-- Step Content -->
                                    <div class="ml-16 space-y-6">
                                        <!-- Explanation -->
                                        @if(!empty($step['explanation']))
                                            <div class="prose prose-invert max-w-none">
                                                <div class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $step['explanation'] }}</div>
                                            </div>
                                        @endif
                                        
                                        <!-- Code Block -->
                                        @if(!empty($step['code']))
                                            <div class="code-block">
                                                <div class="bg-dark-200 rounded-t-lg px-4 py-2 flex justify-between items-center border-b border-gray-700">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-code mr-2 text-green-400"></i>
                                                        <span class="text-sm font-semibold text-gray-300">{{ strtoupper($step['code_language'] ?? 'php') }}</span>
                                                    </div>
                                                    <button class="copy-code text-gray-400 hover:text-white transition-colors" data-code="{{ base64_encode($step['code']) }}">
                                                        <i class="fas fa-copy mr-1"></i>
                                                        <span class="text-sm">Copy</span>
                                                    </button>
                                                </div>
                                                <pre class="bg-dark-300 rounded-b-lg p-4 overflow-x-auto border border-gray-700"><code class="language-{{ $step['code_language'] ?? 'php' }} text-sm">{{ $step['code'] }}</code></pre>
                                            </div>
                                        @endif
                                        
                                        <!-- Image -->
                                        @if(!empty($step['image_path']))
                                            <figure class="my-6">
                                                <img src="{{ asset('storage/' . $step['image_path']) }}" alt="{{ $step['image_alt'] ?? '' }}" class="w-full rounded-lg shadow-md">
                                                @if(!empty($step['image_alt']))
                                                    <figcaption class="text-center text-sm text-gray-400 mt-2">{{ $step['image_alt'] }}</figcaption>
                                                @endif
                                            </figure>
                                        @endif
                                    </div>
                                    
                                    <!-- Step Indicator -->
                                    <div class="absolute left-4 top-20 bottom-4 w-0.5 bg-gradient-to-b from-primary to-purple-600 opacity-30"></div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Fallback to regular content -->
                        <div class="prose prose-invert prose-lg max-w-none">
                            <div class="article-content">
                                {!! nl2br(e($article->content)) !!}
                            </div>
                        </div>
                    @endif
                    
                    <!-- Conclusion -->
                    <div class="mt-12 bg-gradient-to-r from-green-500/10 to-blue-500/10 rounded-xl p-6 border border-green-500/20">
                        <h3 class="text-xl font-semibold mb-3 text-green-400">
                            <i class="fas fa-check-circle mr-2"></i>Selesai!
                        </h3>
                        <p class="text-gray-300">
                            Selamat! Anda telah menyelesaikan tutorial <strong>{{ $article->title }}</strong>. 
                            Jika ada pertanyaan atau kendala, jangan ragu untuk bertanya di kolom komentar.
                        </p>
                    </div>
                    
                    <!-- Tags -->
                    @if($article->tags)
                    <div class="mt-12 pt-8 border-t border-gray-800">
                        <h3 class="text-xl font-semibold mb-4">
                            <i class="fas fa-tags mr-2 text-primary"></i>Tags
                        </h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($article->tags as $tag)
                            <span class="bg-dark-100 border border-gray-800 hover:border-primary px-4 py-2 rounded-full transition-colors cursor-pointer">
                                #{{ $tag }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Navigation -->
                    <div class="mt-12 pt-8 border-t border-gray-800">
                        <div class="flex flex-col sm:flex-row justify-between gap-4">
                            <a href="{{ route('blog.index') }}" class="flex items-center text-gray-400 hover:text-primary transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke Home
                            </a>
                            <a href="#" class="flex items-center text-gray-400 hover:text-primary transition-colors">
                                Artikel Selanjutnya
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">
                        <!-- Progress Tracker -->
                        @if(!empty($steps))
                        <div class="bg-dark-100 rounded-xl p-6 border border-gray-800">
                            <h3 class="text-lg font-semibold mb-4">
                                <i class="fas fa-tasks mr-2 text-primary"></i>Progress
                            </h3>
                            <div class="space-y-3">
                                @foreach($steps as $index => $step)
                                <div class="flex items-center text-sm">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-600 flex items-center justify-center mr-3 step-checkbox" data-step="{{ $index + 1 }}">
                                        <i class="fas fa-check hidden text-green-400 text-xs"></i>
                                    </div>
                                    <a href="#step-{{ $index + 1 }}" class="text-gray-400 hover:text-primary transition-colors">
                                        {{ $step['title'] ?? 'Step ' . ($index + 1) }}
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-4 bg-gray-800 rounded-full h-2">
                                <div class="progress-bar bg-gradient-to-r from-primary to-purple-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-2">
                                <span class="completed-steps">0</span> dari {{ count($steps) }} langkah selesai
                            </p>
                        </div>
                        @endif
                        
                        <!-- Author Info - sama seperti sebelumnya -->
                        <div class="bg-dark-100 rounded-xl p-6 border border-gray-800">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-primary to-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-user text-2xl text-white"></i>
                                </div>
                                <h3 class="text-lg font-semibold mb-2">Developer</h3>
                                <p class="text-gray-400 text-sm mb-4">Full Stack Developer & Technical Writer</p>
                                <div class="flex justify-center space-x-3">
                                    <a href="#" class="w-8 h-8 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
                                        <i class="fab fa-github text-sm"></i>
                                    </a>
                                    <a href="#" class="w-8 h-8 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
                                        <i class="fab fa-twitter text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

<script>
// Copy code functionality
document.querySelectorAll('.copy-code').forEach(button => {
    button.addEventListener('click', function() {
        const code = atob(this.dataset.code);
        navigator.clipboard.writeText(code).then(function() {
            const icon = button.querySelector('i');
            const text = button.querySelector('span');
            
            icon.className = 'fas fa-check mr-1';
            text.textContent = 'Copied!';
            
            setTimeout(() => {
                icon.className = 'fas fa-copy mr-1';
                text.textContent = 'Copy';
            }, 2000);
        });
    });
});

// Progress tracking
const stepContainers = document.querySelectorAll('.step-container');
const stepCheckboxes = document.querySelectorAll('.step-checkbox');
const progressBar = document.querySelector('.progress-bar');
const completedStepsSpan = document.querySelector('.completed-steps');

let completedSteps = new Set();

// Check if step is in viewport
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Update progress
function updateProgress() {
    stepContainers.forEach((container, index) => {
        if (isInViewport(container) || container.getBoundingClientRect().top < window.innerHeight / 2) {
            completedSteps.add(index + 1);
            const checkbox = document.querySelector(`[data-step="${index + 1}"]`);
            if (checkbox) {
                checkbox.style.borderColor = '#10b981';
                checkbox.style.backgroundColor = 'rgba(16, 185, 129, 0.2)';
                checkbox.querySelector('i').classList.remove('hidden');
            }
        }
    });
    
    const progress = (completedSteps.size / stepContainers.length) * 100;
    if (progressBar) {
        progressBar.style.width = progress + '%';
    }
    if (completedStepsSpan) {
        completedStepsSpan.textContent = completedSteps.size;
    }
}

// Listen for scroll
window.addEventListener('scroll', updateProgress);
window.addEventListener('load', updateProgress);

// Smooth scroll for progress links
document.querySelectorAll('a[href^="#step-"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const stepNumber = this.getAttribute('href').replace('#step-', '');
        const target = document.querySelector(`.step-container:nth-child(${stepNumber})`);
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Initialize syntax highlighting
if (typeof hljs !== 'undefined') {
    hljs.highlightAll();
}
</script>
@endsection
