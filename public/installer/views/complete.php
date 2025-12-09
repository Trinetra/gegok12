<div class="bg-white rounded-2xl card-shadow p-8">
    <div class="text-center mb-8">
        <div class="w-20 h-20 mx-auto bg-gradient-to-br from-green-400 to-emerald-600 rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Installation Complete!</h2>
        <p class="text-gray-600 max-w-md mx-auto">
            Congratulations! Gego K12 has been successfully configured on your server.
        </p>
    </div>

    <div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-8">
        <h3 class="font-semibold text-green-800 mb-4">✓ What was done:</h3>
        <ul class="space-y-2 text-green-700">
            <li class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Environment file (.env) created
            </li>
            <li class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Application key generated
            </li>
            <li class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Storage directories configured
            </li>
            <li class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Database connection configured
            </li>
        </ul>
    </div>

    <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-8">
        <h3 class="font-semibold text-amber-800 mb-4">⚠ Next Steps (Required):</h3>
        <p class="text-amber-700 mb-4">Run the following commands in your terminal to complete the setup:</p>
        
        <div class="space-y-4">
            <div class="bg-gray-800 text-gray-100 rounded-lg p-4 font-mono text-sm overflow-x-auto">
                <p class="text-gray-400"># Install PHP dependencies</p>
                <p>composer install --no-dev --optimize-autoloader</p>
            </div>
            
            <div class="bg-gray-800 text-gray-100 rounded-lg p-4 font-mono text-sm overflow-x-auto">
                <p class="text-gray-400"># Run database migrations and seed data</p>
                <p>php artisan migrate --seed</p>
            </div>
            
            <div class="bg-gray-800 text-gray-100 rounded-lg p-4 font-mono text-sm overflow-x-auto">
                <p class="text-gray-400"># Create storage symlink</p>
                <p>php artisan storage:link</p>
            </div>
            
            <div class="bg-gray-800 text-gray-100 rounded-lg p-4 font-mono text-sm overflow-x-auto">
                <p class="text-gray-400"># Clear and cache configuration</p>
                <p>php artisan config:cache && php artisan route:cache && php artisan view:cache</p>
            </div>
        </div>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
        <h3 class="font-semibold text-blue-800 mb-2">🔐 Security Recommendation</h3>
        <p class="text-blue-700 text-sm">
            For security reasons, please delete or rename the <code class="bg-blue-100 px-1 rounded">/installer</code> directory after completing the setup.
        </p>
    </div>

    <div class="text-center">
        <a href="../" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all transform hover:scale-105 shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Go to Application
        </a>
    </div>
</div>
