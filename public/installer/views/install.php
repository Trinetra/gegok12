<div class="bg-white rounded-2xl card-shadow p-8">
    <div class="text-center mb-8">
        <div class="w-16 h-16 mx-auto bg-indigo-100 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Ready to Install</h2>
        <p class="text-gray-600">We're ready to set up your Gego K12 school management system</p>
    </div>

    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Installation Summary</h3>
        
        <div class="bg-gray-50 rounded-xl p-6 space-y-4">
            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                <span class="text-gray-600">Application</span>
                <span class="font-medium text-gray-800"><?php echo isset($_SESSION['admin_config']['app_name']) ? htmlspecialchars($_SESSION['admin_config']['app_name']) : 'Not Set'; ?></span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                <span class="text-gray-600">URL</span>
                <span class="font-medium text-gray-800"><?php echo isset($_SESSION['admin_config']['app_url']) ? htmlspecialchars($_SESSION['admin_config']['app_url']) : 'Not Set'; ?></span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                <span class="text-gray-600">Database Host</span>
                <span class="font-medium text-gray-800"><?php echo isset($_SESSION['db_config']['host']) ? htmlspecialchars($_SESSION['db_config']['host']) : 'Not Set'; ?></span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                <span class="text-gray-600">Database Name</span>
                <span class="font-medium text-gray-800"><?php echo isset($_SESSION['db_config']['database']) ? htmlspecialchars($_SESSION['db_config']['database']) : 'Not Set'; ?></span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                <span class="text-gray-600">Admin Email</span>
                <span class="font-medium text-gray-800"><?php echo isset($_SESSION['admin_config']['admin_email']) ? htmlspecialchars($_SESSION['admin_config']['admin_email']) : 'Not Set'; ?></span>
            </div>
            <div class="flex items-center justify-between py-2">
                <span class="text-gray-600">Timezone</span>
                <span class="font-medium text-gray-800"><?php echo isset($_SESSION['admin_config']['timezone']) ? htmlspecialchars($_SESSION['admin_config']['timezone']) : 'UTC'; ?></span>
            </div>
        </div>
    </div>

    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Installation will:</h3>
        <ul class="space-y-3">
            <li class="flex items-center text-gray-700">
                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Create the .env configuration file
            </li>
            <li class="flex items-center text-gray-700">
                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Generate application encryption key
            </li>
            <li class="flex items-center text-gray-700">
                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Set up required directories
            </li>
            <li class="flex items-center text-gray-700">
                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Mark installation as complete
            </li>
        </ul>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-8">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-semibold text-blue-800 mb-1">After Installation</h4>
                <p class="text-sm text-blue-700">
                    You'll need to run <code class="bg-blue-100 px-1 rounded">composer install</code> and <code class="bg-blue-100 px-1 rounded">php artisan migrate --seed</code> to complete the setup.
                </p>
            </div>
        </div>
    </div>

    <form method="POST">
        <div class="flex justify-between">
            <a href="?step=4" class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                </svg>
                Back
            </a>
            
            <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-emerald-700 transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Install Now
            </button>
        </div>
    </form>
</div>
