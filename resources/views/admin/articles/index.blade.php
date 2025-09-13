@extends('layouts.app')

@section('title', 'Kelola Artikel')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">
                <i class="fas fa-cog mr-2 text-primary"></i>Kelola Artikel
            </h1>
            <a href="{{ route('admin.articles.create') }}" 
               class="bg-primary hover:bg-primary/80 px-6 py-3 rounded-lg font-semibold transition-all hover-lift">
                <i class="fas fa-plus mr-2"></i>Artikel Baru
            </a>
        </div>

        <!-- Articles Table -->
        <div class="bg-dark-100 rounded-xl border border-gray-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-dark-200 border-b border-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">Judul</th>
                            <th class="px-6 py-4 text-left font-semibold">Kategori</th>
                            <th class="px-6 py-4 text-left font-semibold">Status</th>
                            <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                            <th class="px-6 py-4 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr class="border-b border-gray-800 hover:bg-dark-200/50 transition-colors">
                            <td class="px-6 py-4">
                                <div>
                                    <h3 class="font-semibold text-white">{{ $article->title }}</h3>
                                    <p class="text-sm text-gray-400 mt-1">{{ Str::limit($article->excerpt, 60) }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-primary/20 text-primary px-3 py-1 rounded-full text-sm">
                                    {{ $article->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($article->is_published)
                                    <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm">
                                        <i class="fas fa-check-circle mr-1"></i>Published
                                    </span>
                                @else
                                    <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-sm">
                                        <i class="fas fa-clock mr-1"></i>Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-400">
                                {{ $article->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    @if($article->is_published)
                                    <a href="{{ route('blog.show', $article) }}" target="_blank"
                                       class="w-8 h-8 bg-blue-600 hover:bg-blue-700 rounded-lg flex items-center justify-center transition-colors" title="Lihat">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    @endif
                                    <a href="{{ route('admin.articles.edit', $article) }}"
                                       class="w-8 h-8 bg-green-600 hover:bg-green-700 rounded-lg flex items-center justify-center transition-colors" title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" 
                                          onsubmit="return confirm('Yakin ingin menghapus artikel ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-8 h-8 bg-red-600 hover:bg-red-700 rounded-lg flex items-center justify-center transition-colors" title="Hapus">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-newspaper text-4xl mb-4"></i>
                                <p>Belum ada artikel</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($articles->hasPages())
            <div class="px-6 py-4 border-t border-gray-800">
                {{ $articles->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
