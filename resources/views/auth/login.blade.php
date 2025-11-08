{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Blog Portfolio</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        dark: {
                            100: '#1e293b',
                            200: '#0f172a',
                            300: '#020617'
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .glass {
            backdrop-filter: blur(10px);
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(59, 130, 246, 0.1);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-dark-300 text-gray-100 min-h-screen flex items-center justify-center">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary/10 via-purple-500/5 to-transparent"></div>
    <div class="absolute top-20 left-10 w-20 h-20 bg-primary/20 rounded-full blur-xl animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-32 h-32 bg-purple-500/20 rounded-full blur-xl animate-pulse"></div>
    
    <div class="relative z-10 w-full max-w-md px-4">
        <!-- Login Card -->
        <div class="glass rounded-2xl p-8 shadow-2xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-primary to-purple-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-2xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold gradient-text mb-2">Admin Login</h1>
                <p class="text-gray-400">Masuk untuk mengelola blog</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-400 mr-2"></i>
                        <span class="text-red-400 text-sm">
                            {{ $errors->first() }}
                        </span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-400 mr-2"></i>
                        <span class="text-red-400 text-sm">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-500/20 border border-green-500/50 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-400 mr-2"></i>
                        <span class="text-green-400 text-sm">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                
                <!-- Email Field -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">
                        <i class="fas fa-envelope mr-2 text-primary"></i>Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 bg-dark-200 border border-gray-700 rounded-lg focus:border-primary focus:outline-none transition-colors text-white"
                           placeholder="admin@blog.com">
                </div>

                <!-- Password Field -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">
                        <i class="fas fa-lock mr-2 text-primary"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                               class="w-full px-4 py-3 bg-dark-200 border border-gray-700 rounded-lg focus:border-primary focus:outline-none transition-colors text-white pr-12"
                               placeholder="••••••••">
                        <button type="button" onclick="togglePassword()" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-primary bg-dark-200 border-gray-600 rounded focus:ring-primary">
                        <span class="ml-2 text-sm text-gray-300">Ingat saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-primary to-purple-600 hover:from-primary/80 hover:to-purple-600/80 text-white py-3 rounded-lg font-semibold transition-all transform hover:scale-105 shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-gray-700 text-center">
                <a href="{{ route('blog.index') }}" class="text-gray-400 hover:text-primary transition-colors text-sm">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali ke Blog
                </a>
            </div>
        </div>

        <!-- Quick Info -->
        <!-- <div class="mt-6 text-center">
            <div class="glass rounded-lg p-4">
                <h3 class="text-sm font-semibold text-primary mb-2">Demo Account</h3>
                <p class="text-xs text-gray-400 mb-1">Email: admin@blog.com</p>
                <p class="text-xs text-gray-400">Password: password123</p>
            </div>
        </div>
    </div> -->

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Auto focus pada email field
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('input[name="email"]').focus();
        });
    </script>
</body>
</html>
