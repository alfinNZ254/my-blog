@extends('layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center mb-8">
            <a href="{{ route('admin.articles.index') }}" 
               class="w-10 h-10 bg-dark-100 hover:bg-dark-200 rounded-lg flex items-center justify-center mr-4 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold">
                <i class="fas fa-edit mr-2 text-primary"></i>Edit Artikel
            </h1>
        </div>

        @if ($errors->any())
        <div class="bg-red-500/20 text-red-400 p-4 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data" id="article-form">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <div class="lg:col-span-3 space-y-6">
                    
                    <div class="bg-dark-100 rounded-xl p-6 border border-gray-800">
                        <h3 class="text-xl font-semibold mb-6">
                            <i class="fas fa-info-circle mr-2 text-primary"></i>Informasi Dasar
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold mb-2">Judul Artikel</label>
                                <input type="text" name="title" value="{{ old('title', $article->title) }}" class="w-full px-4 py-2 bg-dark-200 rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-primary/50 transition-colors" placeholder="Masukkan judul artikel" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Ringkasan (Excerpt)</label>
                                <textarea name="excerpt" rows="3" class="w-full px-4 py-2 bg-dark-200 rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-primary/50 transition-colors" placeholder="Ringkasan singkat artikel" required>{{ old('excerpt', $article->excerpt) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Kategori</label>
                                <input type="text" name="category" value="{{ old('category', $article->category) }}" class="w-full px-4 py-2 bg-dark-200 rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-primary/50 transition-colors" placeholder="Mis: PHP, Laravel, CSS" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Tags</label>
                                <input type="text" name="tags" value="{{ old('tags', implode(',', $article->tags ?? [])) }}" class="w-full px-4 py-2 bg-dark-200 rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-primary/50 transition-colors" placeholder="Pisahkan dengan koma: tag1,tag2">
                            </div>
                        </div>
                    </div>

                    <div id="steps-container" class="space-y-8 bg-dark-100 rounded-xl p-6 border border-gray-800">
                        <h3 class="text-xl font-semibold mb-6">
                            <i class="fas fa-list-ol mr-2 text-primary"></i>Langkah-Langkah Tutorial
                        </h3>
                        </div>

                    <button type="button" id="add-step-btn" 
                            class="w-full bg-primary/20 text-primary hover:bg-primary/30 px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i>Tambah Langkah
                    </button>
                    
                </div>
                
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-dark-100 rounded-xl p-6 border border-gray-800 space-y-4">
                        <div class="flex items-center justify-between">
                            <label for="is_published" class="text-sm font-semibold flex items-center">
                                <i class="fas fa-globe mr-2 text-primary"></i>Publikasikan?
                            </label>
                            <input type="checkbox" id="is_published" name="is_published" class="w-5 h-5 form-checkbox text-primary rounded-full transition-colors" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold mb-2">Gambar Unggulan</label>
                            @if ($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Gambar Unggulan" id="featured-image-preview" class="w-full h-32 object-cover rounded-lg mb-2">
                            @endif
                            <input type="file" name="featured_image" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/80 transition-all">
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-primary hover:bg-primary/80 px-6 py-3 rounded-lg font-semibold transition-all hover-lift">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stepsContainer = document.getElementById('steps-container');
    const addStepBtn = document.getElementById('add-step-btn');
    const form = document.getElementById('article-form');

    // Function to add a new step item
    function addNewStep(stepData = {}) {
        const stepCount = stepsContainer.querySelectorAll('.step-item').length + 1;
        const stepHtml = `
            <div class="step-item relative pl-6 bg-dark-200 rounded-lg p-4 border border-gray-700">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="text-lg font-semibold text-primary">Langkah ${stepCount}</h4>
                    <button type="button" class="remove-step-btn text-gray-400 hover:text-red-500 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-gray-400">Judul Langkah</label>
                        <input type="text" name="step_title[]" value="${stepData.title || ''}" class="w-full px-3 py-1 bg-dark-300 rounded-lg border border-gray-700 text-sm focus:outline-none focus:ring-1 focus:ring-primary/50" placeholder="Judul singkat">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-gray-400">Penjelasan</label>
                        <textarea name="step_explanation[]" rows="3" class="w-full px-3 py-1 bg-dark-300 rounded-lg border border-gray-700 text-sm focus:outline-none focus:ring-1 focus:ring-primary/50" placeholder="Deskripsi detail langkah">${stepData.explanation || ''}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-gray-400">Kode (Opsional)</label>
                        <textarea name="step_code[]" rows="4" class="w-full font-mono px-3 py-1 bg-dark-300 rounded-lg border border-gray-700 text-sm focus:outline-none focus:ring-1 focus:ring-primary/50" placeholder="Masukkan kode atau script">${stepData.code || ''}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-gray-400">Gambar (Opsional)</label>
                        <div class="flex items-center space-x-2">
                            <input type="file" name="step_image_file[]" accept="image/*" class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gray-700 file:text-white hover:file:bg-gray-600 transition-all">
                            <input type="text" name="step_image_path[]" value="${stepData.image_path || ''}" class="w-full px-3 py-1 bg-dark-300 rounded-lg border border-gray-700 text-xs focus:outline-none focus:ring-1 focus:ring-primary/50" placeholder="URL Gambar Lama">
                        </div>
                    </div>
                </div>
            </div>
        `;
        stepsContainer.insertAdjacentHTML('beforeend', stepHtml);
    }

    // Function to update step numbers and titles
    function updateStepNumbers() {
        const stepItems = stepsContainer.querySelectorAll('.step-item');
        stepItems.forEach((item, index) => {
            const h4 = item.querySelector('h4');
            h4.textContent = `Langkah ${index + 1}`;
        });
    }

    // Add new step when button is clicked
    addStepBtn.addEventListener('click', function() {
        addNewStep();
        updateStepNumbers();
    });

    // Remove step when button is clicked (event delegation)
    stepsContainer.addEventListener('click', function(event) {
        if (event.target.closest('.remove-step-btn')) {
            event.target.closest('.step-item').remove();
            updateStepNumbers();
        }
    });

    // Parse existing steps data and populate the form
    const existingSteps = @json($article->article_steps);
    if (existingSteps && Array.isArray(existingSteps) && existingSteps.length > 0) {
        existingSteps.forEach(step => {
            addNewStep(step);
        });
    } else {
        addNewStep(); // Start with one empty step if no steps exist
    }

    // Handle form submission to combine steps into a single JSON string
    form.addEventListener('submit', function(event) {
        event.preventDefault(); 
        
        const steps = [];
        const stepItems = stepsContainer.querySelectorAll('.step-item');
        let filesToProcess = 0;
        let filesProcessed = 0;

        stepItems.forEach(stepItem => {
            const imageFile = stepItem.querySelector('input[name="step_image_file[]"]').files[0];
            if (imageFile) {
                filesToProcess++;
            }
        });

        const finalizeSubmission = () => {
            // Create hidden input for steps data and append to form
            const stepsInput = document.createElement('input');
            stepsInput.type = 'hidden';
            stepsInput.name = 'article_steps';
            stepsInput.value = JSON.stringify(steps);
            form.appendChild(stepsInput);
            
            // Remove old name attributes to prevent sending duplicate data
            form.querySelectorAll('[name$="[]"]').forEach(input => {
                input.removeAttribute('name');
            });

            // Now, submit the form with the new data
            form.submit();
        };

        if (filesToProcess === 0) {
            stepItems.forEach(stepItem => {
                const stepData = {
                    title: stepItem.querySelector('input[name="step_title[]"]').value,
                    explanation: stepItem.querySelector('textarea[name="step_explanation[]"]').value,
                    code: stepItem.querySelector('textarea[name="step_code[]"]').value,
                    image_path: stepItem.querySelector('input[name="step_image_path[]"]').value
                };
                steps.push(stepData);
            });
            finalizeSubmission();
        } else {
            stepItems.forEach(stepItem => {
                const stepData = {
                    title: stepItem.querySelector('input[name="step_title[]"]').value,
                    explanation: stepItem.querySelector('textarea[name="step_explanation[]"]').value,
                    code: stepItem.querySelector('textarea[name="step_code[]"]').value,
                    image_path: stepItem.querySelector('input[name="step_image_path[]"]').value
                };
                
                // Handle new image file upload
                const imageFile = stepItem.querySelector('input[name="step_image_file[]"]').files[0];
                if (imageFile) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        stepData.image_file = e.target.result;
                        steps.push(stepData);
                        filesProcessed++;
                        if (filesProcessed === filesToProcess) {
                            finalizeSubmission();
                        }
                    };
                    reader.readAsDataURL(imageFile);
                } else {
                    steps.push(stepData);
                }
            });
        }
    });
});
</script>
@endsection
