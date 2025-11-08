<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog Tutorial') - Portfolio</title>
    <meta name="description" content="@yield('description', 'Blog tutorial programming dan teknologi')">
    
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
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                        'mono': ['JetBrains Mono', 'monospace']
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Highlight.js untuk syntax highlighting -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/tokyo-night-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    
    <!-- Font Awesome untuk icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }
        
        /* Smooth animations */
        * {
            transition: all 0.2s ease;
        }
        
        /* Code blocks */
        pre {
            border-radius: 8px !important;
            margin: 1rem 0 !important;
        }
        
        /* Glass effect */
        .glass {
            backdrop-filter: blur(10px);
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(59, 130, 246, 0.1);
        }
        
        /* Hover animations */
        .hover-lift:hover {
            transform: translateY(-2px);
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-dark-300 text-gray-100 font-sans">
    <!-- Header -->
    <header class="sticky top-0 z-50 glass border-b border-gray-800">
        <div class="container mx-auto px-4 py-4">
            <nav class="flex justify-between items-center">
                <!-- Logo -->
                <a href="{{ route('blog.index') }}" class="text-2xl font-bold gradient-text">
                    <i class="fas fa-code mr-2"></i>AlfinSys
                </a>
                
                <!-- Navigation -->
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('blog.index') }}" class="hover:text-primary transition-colors">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                    <a href="#" class="hover:text-primary transition-colors">
                        <i class="fas fa-user mr-2"></i>About
                    </a>
                    <a href="#" class="hover:text-primary transition-colors">
                        <i class="fas fa-briefcase mr-2"></i>Portfolio
                    </a>
                    <a href="#" class="hover:text-primary transition-colors">
                        <i class="fas fa-envelope mr-2"></i>Contact
                    </a>
                    @auth
                        @if(Auth::user()->is_admin ?? false)
                        <a href="{{ route('admin.articles.index') }}" class="hover:text-primary transition-colors text-yellow-400">
                            <i class="fas fa-cog mr-2"></i>Admin
                        </a>
                        <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-red-400 transition-colors text-red-500">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                        @endif
                    @endauth
                </div>
                
                <!-- Mobile menu button -->
                <button class="md:hidden text-gray-400 hover:text-white" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </nav>
            
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 py-4 border-t border-gray-800">
                <a href="{{ route('blog.index') }}" class="block py-2 hover:text-primary transition-colors">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="#" class="block py-2 hover:text-primary transition-colors">
                    <i class="fas fa-user mr-2"></i>About
                </a>
                <a href="#" class="block py-2 hover:text-primary transition-colors">
                    <i class="fas fa-briefcase mr-2"></i>Portfolio
                </a>
                <a href="#" class="block py-2 hover:text-primary transition-colors">
                    <i class="fas fa-envelope mr-2"></i>Contact
                </a>
                @auth
                    @if(Auth::user()->is_admin ?? false)
                    <a href="{{ route('admin.articles.index') }}" class="block py-2 hover:text-primary transition-colors text-yellow-400">
                        <i class="fas fa-cog mr-2"></i>Admin
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="block w-full text-left py-2 hover:text-red-400 transition-colors text-red-500">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark-200 border-t border-gray-800 mt-20">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About -->
                <div>
                    <h3 class="text-xl font-semibold mb-4 gradient-text">
                        <i class="fas fa-code mr-2"></i>AlfinSys
                    </h3>
                    <p class="text-gray-400 leading-relaxed">
                        Blog tutorial. 
                        Berbagi pengetahuan.
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Laravel</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Vue.js</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">React</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">PHP</a></li>
                    </ul>
                </div>
                
                <!-- Social -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">Follow Me</h3>
                    <div class="flex space-x-4">
                        <a href="https://github.com/alfinNZ254" class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center hover:bg-primary transition-colors">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center hover:bg-primary transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://linkedin.com/in/alfinzamjaro" class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center hover:bg-primary transition-colors">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center hover:bg-primary transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 AlfinSys. All rights reserved. Made with <i class="fas fa-heart text-red-500"></i> in Indonesia</p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize highlight.js
        hljs.highlightAll();
        
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
        
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
        
        // Back to top button
        window.addEventListener('scroll', function() {
            const backToTop = document.getElementById('back-to-top');
            if (backToTop) {
                if (window.scrollY > 300) {
                    backToTop.classList.remove('hidden');
                } else {
                    backToTop.classList.add('hidden');
                }
            }
        });
    </script>
    
    <!-- Back to top button -->
    <button id="back-to-top" class="hidden fixed bottom-8 right-8 w-12 h-12 bg-primary rounded-full flex items-center justify-center hover:bg-primary/80 transition-all shadow-lg hover-lift z-50" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <i class="fas fa-arrow-up"></i>
    </button>
</body>
</html>
