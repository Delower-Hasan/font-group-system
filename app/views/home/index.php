<!-- resources/views/font-manager.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Font Group Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @font-face {
            font-family: 'sans-serif';

        }
        .font-preview {
            font-family:sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Font Group Manager</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Font Upload Section -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">Upload Font</h2>
                <div class="border-2 border-dashed border-gray-300 p-4 rounded-lg">
                    <input type="file" id="fontUpload" accept=".ttf" class="hidden">
                    <label for="fontUpload" class="block text-center cursor-pointer">
                        <div class="flex flex-col items-center justify-center py-4">
                            <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-gray-600">Click to upload TTF font file</p>
                        </div>
                    </label>
                </div>
                
                <h3 class="text-lg font-medium mt-6 mb-3">Uploaded Fonts</h3>
                <div id="fontList" class="space-y-3 max-h-64 overflow-y-auto">
                    <!-- Fonts will be loaded here -->
                </div>
            </div>
            
            <!-- Font Group Section -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">Create Font Group</h2>
                <form id="fontGroupForm">
                    <div class="mb-4">
                        <label for="groupName" class="block text-sm font-medium text-gray-700 mb-1">Group Name</label>
                        <input type="text" id="groupName" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    
                    <div id="fontGroupRows" class="space-y-3 mb-4">
                        <!-- Initial row -->
                        <div class="flex items-center space-x-3 font-row">
                            <select name="fonts[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-md font-select" required>
                                <option value="">Select a font</option>
                                <!-- Options will be populated by JS -->
                            </select>
                            <button type="button" class="remove-row px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 hidden">Remove</button>
                        </div>
                    </div>
                    
                    <div class="flex justify-between">
                        <button type="button" id="addRowBtn" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Add Font</button>
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Create Group</button>
                    </div>
                </form>
                
                <h3 class="text-lg font-medium mt-6 mb-3">Font Groups</h3>
                <div id="fontGroupList" class="space-y-4">
                    <!-- Font groups will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-semibold mb-4">Edit Font Group</h3>
            <form id="editGroupForm">
                <input type="hidden" id="editGroupId">
                <div class="mb-4">
                    <label for="editGroupName" class="block text-sm font-medium text-gray-700 mb-1">Group Name</label>
                    <input type="text" id="editGroupName" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>
                
                <div id="editFontGroupRows" class="space-y-3 mb-4">
                    <!-- Rows will be populated by JS -->
                </div>
                
                <div class="flex justify-between">
                    <button type="button" id="editAddRowBtn" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Add Font</button>
                    <div class="space-x-2">
                        <button type="button" id="cancelEdit" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>