{{-- resources/views/admin/articles/create.blade.php - Simple Version --}}
@extends('layouts.app')

@section('title', 'Buat Artikel Baru')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="flex items-center mb-8">
            <a href="{{ route('admin.articles.index') }}" 
               class="w-10 h-10 bg-dark-100 hover:bg-dark-200 rounded-lg flex items-center justify-center mr-4 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold">
                <i class="fas fa-plus mr-2 text-primary"></i>Buat Artikel Baru
            </h1>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-6 bg-green-500/20 border border-green-500/50 rounded-lg p-4 text-green-400">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-500/20 border border-red-500/50 rounded-lg p-4">
            <h3 class="text-red-400 font-semibold mb-2">
                <i class="fas fa-exclamation-circle mr-2"></i>Terjadi kesalahan:
            </h3>
            <ul class="list-disc list-inside text-red-300 text-sm space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" id="article-form">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-3 space-y-6">
                    
                    <!-- Basic Info -->
                    <div class="bg-dark-100 rounded-xl p-6 border border-gray-800">
                        <h3 class="text-xl font-semibold mb-6">
                            <i class="fas fa-info-circle mr-2 text-primary"></i>Informasi Dasar
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-semibold mb-2">
                                    <i class="fas fa-heading mr-2 text-primary"></i>Judul Artikel <span class="text-red-400">*</span>
                                </label>
                                <input type="text" name="title" value="{{ old('title') }}" 
                                       class="w-full px-4 py-3 bg-dark-200 border {{ $errors->has('title') ? 'border-red-500' : 'border-gray-800' }} rounded-lg focus:border-primary focus:outline-none transition-colors text-white"
                                       placeholder="Contoh: Cara Install Laravel 10" required>
                                @error('title')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold mb-2">
                                    <i class="fas fa-folder mr-2 text-primary"></i>Kategori <span class="text-red-400">*</span>
                                </label>
                                <select name="category" 
                                        class="w-full px-4 py-3 bg-dark-200 border {{ $errors->has('category') ? 'border-red-500' : 'border-gray-800' }} rounded-lg focus:border-primary focus:outline-none transition-colors text-white" required>
                                    <option value="">Pilih kategori</option>
                                    <option value="Laravel" {{ old('category') == 'Laravel' ? 'selected' : '' }}>Laravel</option>
                                    <option value="Vue.js" {{ old('category') == 'Vue.js' ? 'selected' : '' }}>Vue.js</option>
                                    <option value="React" {{ old('category') == 'React' ? 'selected' : '' }}>React</option>
                                    <option value="PHP" {{ old('category') == 'PHP' ? 'selected' : '' }}>PHP</option>
                                    <option value="JavaScript" {{ old('category') == 'JavaScript' ? 'selected' : '' }}>JavaScript</option>
                                    <option value="Tutorial" {{ old('category') == 'Tutorial' ? 'selected' : '' }}>Tutorial</option>
                                    <option value="Tips" {{ old('category') == 'Tips' ? 'selected' : '' }}>Tips</option>
                                </select>
                                @error('category')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold mb-2">
                                <i class="fas fa-quote-left mr-2 text-primary"></i>Ringkasan Artikel <span class="text-red-400">*</span>
                            </label>
                            <textarea name="excerpt" rows="3" 
                                      class="w-full px-4 py-3 bg-dark-200 border {{ $errors->has('excerpt') ? 'border-red-500' : 'border-gray-800' }} rounded-lg focus:border-primary focus:outline-none transition-colors text-white"
                                      placeholder="Ringkasan singkat tentang apa yang akan dipelajari pembaca..." required>{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-400">Ringkasan ini akan ditampilkan di halaman utama dan sebagai preview artikel</p>
                        </div>
                    </div>

                    <!-- Article Content -->
                    <div class="bg-dark-100 rounded-xl p-6 border border-gray-800">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-semibold">
                                <i class="fas fa-list-ol mr-2 text-primary"></i>Konten Artikel
                            </h3>
                            <button type="button" id="add-step-btn" 
                                    class="bg-primary hover:bg-primary/80 px-6 py-3 rounded-lg font-semibold transition-all hover:scale-105 shadow-lg">
                                <i class="fas fa-plus mr-2"></i>+ Tambah Step
                            </button>
                        </div>
                        
                        <!-- Steps Container -->
                        <div id="steps-container" class="space-y-6">
                            <!-- Steps akan ditambahkan di sini -->
                        </div>
                        
                        <!-- Empty State -->
                        <div id="empty-state" class="text-center py-12">
                            <div class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-list-ol text-3xl text-primary/60"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-400 mb-2">Belum ada step</h3>
                            <p class="text-gray-500 mb-6">Klik tombol "Tambah Step" untuk mulai menulis artikel</p>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Publish Settings -->
                    <div class="bg-dark-100 rounded-xl p-6 border border-gray-800">
                        <h3 class="text-lg font-semibold mb-4">
                            <i class="fas fa-cog mr-2 text-primary"></i>Pengaturan
                        </h3>
                        
                        <div class="space-y-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_published" value="1" 
                                       class="w-4 h-4 text-primary bg-dark-200 border-gray-600 rounded focus:ring-primary">
                                <span class="ml-2 text-sm">Publish artikel</span>
                            </label>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="bg-dark-100 rounded-xl p-6 border border-gray-800">
                        <label class="block text-sm font-semibold mb-3">
                            <i class="fas fa-tags mr-2 text-primary"></i>Tags
                        </label>
                        <input type="text" name="tags" value="{{ old('tags') }}" 
                               class="w-full px-4 py-3 bg-dark-200 border border-gray-800 rounded-lg focus:border-primary focus:outline-none transition-colors text-white"
                               placeholder="laravel, tutorial, beginner">
                        <div class="mt-2 text-sm text-gray-400">
                            Pisahkan dengan koma (,)
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="bg-dark-100 rounded-xl p-6 border border-gray-800">
                        <label class="block text-sm font-semibold mb-3">
                            <i class="fas fa-image mr-2 text-primary"></i>Gambar Utama
                        </label>
                        <input type="file" name="featured_image" accept="image/*"
                               class="w-full px-4 py-3 bg-dark-200 border border-gray-800 rounded-lg focus:border-primary focus:outline-none transition-colors text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary file:text-white hover:file:bg-primary/80">
                        <div class="mt-2 text-sm text-gray-400">
                            Max: 2MB. Format: JPG, PNG, WebP
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-4">
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-primary to-blue-600 hover:from-primary/80 hover:to-blue-600/80 text-white py-3 rounded-lg font-semibold transition-all transform hover:scale-105 shadow-lg">
                            <i class="fas fa-save mr-2"></i>Simpan Artikel
                        </button>
                        <button type="button" id="preview-btn"
                                class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-500/80 hover:to-emerald-600/80 text-white py-3 rounded-lg font-semibold transition-all">
                            <i class="fas fa-eye mr-2"></i>Preview
                        </button>
                        <a href="{{ route('admin.articles.index') }}" 
                           class="block w-full bg-gray-600 hover:bg-gray-700 py-3 rounded-lg font-semibold text-center transition-all">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                    </div>

                    <!-- Tips -->
                    <div class="bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-xl p-6 border border-purple-500/20">
                        <h3 class="text-sm font-semibold mb-3">
                            <i class="fas fa-lightbulb mr-2 text-yellow-400"></i>Tips Menulis
                        </h3>
                        <ul class="text-xs text-gray-400 space-y-2">
                            <li>• Buat step yang jelas dan mudah diikuti</li>
                            <li>• Tambahkan screenshot untuk setiap step penting</li>
                            <li>• Sertakan code yang bisa di-copy paste</li>
                            <li>• Jelaskan "mengapa" bukan hanya "apa"</li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Preview Modal -->
<div id="preview-modal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
    <div class="bg-dark-100 rounded-xl max-w-5xl w-full max-h-[90vh] overflow-hidden">
        <div class="p-6 border-b border-gray-800 flex justify-between items-center">
            <h3 class="text-xl font-semibold">
                <i class="fas fa-eye mr-2 text-primary"></i>Preview Artikel
            </h3>
            <button id="close-preview" class="text-gray-400 hover:text-white text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="preview-content" class="p-6 max-h-[70vh] overflow-y-auto">
            <!-- Preview content will be loaded here -->
        </div>
    </div>
</div>

<script>
let stepCounter = 0;

// Add Step Button
document.getElementById('add-step-btn').addEventListener('click', function() {
    addNewStep();
});

function addNewStep() {
    stepCounter++;
    const container = document.getElementById('steps-container');
    const emptyState = document.getElementById('empty-state');
    
    // Hide empty state
    emptyState.classList.add('hidden');
    
    const stepDiv = document.createElement('div');
    stepDiv.className = 'step-item bg-dark-200 rounded-xl p-6 border border-gray-700 relative';
    stepDiv.setAttribute('data-step', stepCounter);
    
    stepDiv.innerHTML = `
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm mr-3">
                    ${stepCounter}
                </div>
                <input type="text" class="step-title bg-transparent border-none text-lg font-semibold text-white focus:outline-none focus:border-b focus:border-primary flex-1" 
                       value="Step ${stepCounter}" placeholder="Judul Step">
            </div>
            <div class="flex items-center space-x-2">
                <button type="button" class="move-step-up text-gray-400 hover:text-primary transition-colors" title="Pindah ke atas">
                    <i class="fas fa-arrow-up"></i>
                </button>
                <button type="button" class="move-step-down text-gray-400 hover:text-primary transition-colors" title="Pindah ke bawah">
                    <i class="fas fa-arrow-down"></i>
                </button>
                <button type="button" class="delete-step text-red-400 hover:text-red-300 transition-colors" title="Hapus Step">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column: Text Content -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold mb-2 text-gray-300">
                        <i class="fas fa-align-left mr-2 text-blue-400"></i>Penjelasan
                    </label>
                    <textarea class="step-explanation w-full px-4 py-3 bg-dark-300 border border-gray-600 rounded-lg focus:border-primary focus:outline-none transition-colors text-white resize-none" 
                              rows="6" placeholder="Jelaskan apa yang dilakukan di step ini..."></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold mb-2 text-gray-300">
                        <i class="fas fa-code mr-2 text-green-400"></i>Code (Opsional)
                    </label>
                    <div class="relative">
                        <select class="code-language absolute top-2 right-2 px-3 py-1 bg-dark-100 border border-gray-600 rounded text-white text-xs z-10">
                            <option value="php">PHP</option>
                            <option value="javascript">JavaScript</option>
                            <option value="html">HTML</option>
                            <option value="css">CSS</option>
                            <option value="bash">Bash/Terminal</option>
                            <option value="sql">SQL</option>
                            <option value="json">JSON</option>
                            <option value="yaml">YAML</option>
                        </select>
                        <textarea class="step-code w-full px-4 py-3 pt-10 bg-dark-300 border border-gray-600 rounded-lg focus:border-primary focus:outline-none transition-colors text-white font-mono text-sm resize-none" 
                                  rows="8" placeholder="// Paste your code here..."></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Image -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-300">
                    <i class="fas fa-image mr-2 text-purple-400"></i>Gambar/Screenshot (Opsional)
                </label>
                <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center hover:border-primary transition-colors">
                    <input type="file" class="step-image hidden" accept="image/*">
                    <div class="image-upload-area">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-500 mb-3"></i>
                        <p class="text-gray-400 mb-2">Klik untuk upload gambar</p>
                        <p class="text-xs text-gray-500">PNG, JPG, WebP (Max: 2MB)</p>
                    </div>
                    <div class="image-preview hidden">
                        <img class="preview-img w-full h-40 object-cover rounded-lg mb-3">
                        <button type="button" class="remove-image bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-white text-sm">
                            <i class="fas fa-trash mr-1"></i>Hapus
                        </button>
                    </div>
                </div>
                <input type="text" class="image-alt w-full px-3 py-2 bg-dark-300 border border-gray-600 rounded-lg mt-3 text-white text-sm" 
                       placeholder="Alt text untuk gambar (untuk SEO)">
            </div>
        </div>
    `;
    
    container.appendChild(stepDiv);
    attachStepEvents(stepDiv);
    
    // Auto focus on title
    stepDiv.querySelector('.step-title').focus();
    stepDiv.querySelector('.step-title').select();
}

function attachStepEvents(stepDiv) {
    // Delete step
    stepDiv.querySelector('.delete-step').addEventListener('click', function() {
        if (confirm('Hapus step ini?')) {
            stepDiv.remove();
            updateStepNumbers();
            checkEmptyState();
        }
    });
    
    // Move step up
    stepDiv.querySelector('.move-step-up').addEventListener('click', function() {
        const prevStep = stepDiv.previousElementSibling;
        if (prevStep) {
            stepDiv.parentNode.insertBefore(stepDiv, prevStep);
            updateStepNumbers();
        }
    });
    
    // Move step down
    stepDiv.querySelector('.move-step-down').addEventListener('click', function() {
        const nextStep = stepDiv.nextElementSibling;
        if (nextStep) {
            stepDiv.parentNode.insertBefore(nextStep, stepDiv);
            updateStepNumbers();
        }
    });
    
    // Image upload
    const uploadArea = stepDiv.querySelector('.image-upload-area');
    const fileInput = stepDiv.querySelector('.step-image');
    const imagePreview = stepDiv.querySelector('.image-preview');
    const previewImg = stepDiv.querySelector('.preview-img');
    const removeBtn = stepDiv.querySelector('.remove-image');
    
    uploadArea.addEventListener('click', () => fileInput.click());
    
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                uploadArea.classList.add('hidden');
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
    
    removeBtn.addEventListener('click', function() {
        fileInput.value = '';
        uploadArea.classList.remove('hidden');
        imagePreview.classList.add('hidden');
    });
    
    // Auto-resize textareas
    stepDiv.querySelectorAll('textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
}

function updateStepNumbers() {
    const steps = document.querySelectorAll('.step-item');
    steps.forEach((step, index) => {
        const number = step.querySelector('.w-8.h-8');
        const title = step.querySelector('.step-title');
        number.textContent = index + 1;
        
        if (title.value === `Step ${step.getAttribute('data-step')}`) {
            title.value = `Step ${index + 1}`;
        }
        step.setAttribute('data-step', index + 1);
    });
}

function checkEmptyState() {
    const steps = document.querySelectorAll('.step-item');
    const emptyState = document.getElementById('empty-state');
    
    if (steps.length === 0) {
        emptyState.classList.remove('hidden');
    }
}

// Preview functionality
document.getElementById('preview-btn').addEventListener('click', function() {
    const modal = document.getElementById('preview-modal');
    const content = document.getElementById('preview-content');
    
    let previewHTML = '<div class="prose prose-invert max-w-none">';
    
    // Title
    const title = document.querySelector('input[name="title"]').value;
    if (title) {
        previewHTML += `<h1 class="text-3xl font-bold text-primary mb-6">${title}</h1>`;
    }
    
    // Excerpt
    const excerpt = document.querySelector('textarea[name="excerpt"]').value;
    if (excerpt) {
        previewHTML += `<div class="bg-primary/10 border-l-4 border-primary p-4 mb-6">
            <p class="text-gray-300"><strong>Ringkasan:</strong> ${excerpt}</p>
        </div>`;
    }
    
    // Steps
    const steps = document.querySelectorAll('.step-item');
    steps.forEach((step, index) => {
        const stepTitle = step.querySelector('.step-title').value;
        const explanation = step.querySelector('.step-explanation').value;
        const code = step.querySelector('.step-code').value;
        const language = step.querySelector('.code-language').value;
        
        previewHTML += `<div class="mb-8 pb-8 border-b border-gray-700">`;
        previewHTML += `<h2 class="text-2xl font-semibold text-primary mb-4">
            <span class="inline-flex items-center justify-center w-8 h-8 bg-primary text-white rounded-full text-sm mr-3">${index + 1}</span>
            ${stepTitle}
        </h2>`;
        
        if (explanation) {
            previewHTML += `<p class="text-gray-300 mb-4 leading-relaxed">${explanation.replace(/\n/g, '<br>')}</p>`;
        }
        
        if (code) {
            previewHTML += `<div class="mb-4">
                <div class="bg-dark-300 rounded-t-lg px-4 py-2 text-sm text-gray-400 border-b border-gray-600">
                    <i class="fas fa-code mr-2"></i>${language.toUpperCase()}
                </div>
                <pre class="bg-dark-200 p-4 rounded-b-lg border border-gray-600 overflow-x-auto"><code class="language-${language} text-sm">${code}</code></pre>
            </div>`;
        }
        
        previewHTML += `</div>`;
    });
    
    previewHTML += '</div>';
    content.innerHTML = previewHTML;
    modal.classList.remove('hidden');
});

document.getElementById('close-preview').addEventListener('click', function() {
    document.getElementById('preview-modal').classList.add('hidden');
});

// Form submission
document.getElementById('article-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Stop the default form submission

    const steps = [];
    const formData = new FormData(this); // Use FormData to handle files

    // Process all steps and convert images to base64
    const stepPromises = [];
    document.querySelectorAll('.step-item').forEach((step, index) => {
        const stepData = {
            step_number: index + 1,
            title: step.querySelector('.step-title').value || `Step ${index + 1}`,
            explanation: step.querySelector('.step-explanation').value || '',
            code: step.querySelector('.step-code').value || '',
            code_language: step.querySelector('.code-language').value || 'php',
            image_alt: step.querySelector('.image-alt').value || ''
        };
        
        // Handle image file - convert to base64
        const imageFile = step.querySelector('.step-image').files[0];
        if (imageFile) {
            const imagePromise = new Promise((resolve) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    stepData.image_file = e.target.result; // Base64 string
                    resolve();
                };
                reader.onerror = function() {
                    resolve(); // Continue even if image read fails
                };
                reader.readAsDataURL(imageFile);
            });
            stepPromises.push(imagePromise);
        }
        
        steps.push(stepData);
    });
    
    // Wait for all images to be converted to base64
    Promise.all(stepPromises).then(() => {
        // Remove article_steps if it was added before
        formData.delete('article_steps');
        
        // Add steps as JSON string
        formData.append('article_steps', JSON.stringify(steps));
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
        
        // Submit form using fetch API
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
                return;
            }
            return response.json().then(data => {
                if (data.success || response.ok) {
                    window.location.href = data.redirect_url || '{{ route("admin.articles.index") }}';
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan saat menyimpan artikel');
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
});
// Initialize with one step
document.addEventListener('DOMContentLoaded', function() {
    // Optional: start with one empty step
    // addNewStep();
});
</script>

<style>
.step-item {
    animation: fadeInUp 0.3s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.step-item::before {
    content: '';
    position: absolute;
    left: -4px;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, #3b82f6, #8b5cf6);
    border-radius: 2px;
}

.image-upload-area:hover {
    background: rgba(59, 130, 246, 0.05);
}

.prose code {
    background: #374151;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.prose pre {
    background: #1f2937 !important;
    border: 1px solid #374151;
}
</style>
@endsection
