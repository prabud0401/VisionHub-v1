<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VisionHub AI Image Generation Studio</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for Open Sans font and general body styling */
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f3f4f6; /* Light gray background for the overall page, main content area will be dark */
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ensure body takes full viewport height */
        }
        /* Hide scrollbar for a cleaner look */
        ::-webkit-scrollbar {
            display: none;
        }
        /* Message box styling */
        .message-box {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #333;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: none; /* Hidden by default */
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .message-box.show {
            display: block;
            opacity: 1;
        }

        /* Modal specific styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8); /* Dark overlay */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }
        .modal.show {
            opacity: 1;
            visibility: visible;
        }
        .modal-content {
            background-color: #1a1a1a; /* Dark background for modal content */
            color: white;
            padding: 2rem;
            border-radius: 1rem;
            max-width: 90%;
            max-height: 90%;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
            transform: translateY(20px);
            transition: transform 0.3s ease-in-out;
        }
        .modal.show .modal-content {
            transform: translateY(0);
        }
        .close-button {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.8rem;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }
        .close-button:hover {
            color: #fff;
        }
    </style>
</head>
<body class="flex flex-col">

    <header class="bg-black text-white py-4 shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
            <a href="#" class="text-3xl font-extrabold text-red-600 mb-4 md:mb-0">VisionHub</a>

            <nav class="w-full md:w-auto">
                <ul class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8 text-lg font-medium">
                    <li><a href="#home" class="text-white hover:text-yellow-500 transition duration-300">Home</a></li>
                    <li><a href="#gallery" class="text-white hover:text-yellow-500 transition duration-300">Gallery</a></li>
                    <li><a href="#features" class="text-white hover:text-yellow-500 transition duration-300">Features</a></li>
                    <li><a href="#pricing" class="text-white hover:text-yellow-500 transition duration-300">Pricing</a></li>
                    <li><a href="#faq" class="text-white hover:text-yellow-500 transition duration-300">FAQ</a></li>
                    <li><a href="#feedback" class="text-white hover:text-yellow-500 transition duration-300">Feedback</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="flex-grow flex flex-col items-center justify-center p-4 bg-gray-900 text-white">
        <div class="bg-gray-800 p-6 md:p-8 rounded-xl shadow-lg w-full max-w-4xl border-t-4 border-blue-400">
            <h1 class="text-3xl md:text-4xl font-bold text-center text-white mb-6">AI Image Generation Studio</h1>

            <div class="mb-6">
                <label for="prompt-input" class="block text-gray-200 text-lg font-medium mb-2">Enter your prompt:</label>
                <textarea id="prompt-input" class="w-full p-4 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200 resize-y min-h-[120px] bg-gray-700 text-white placeholder-gray-400" placeholder="e.g., A vibrant cyberpunk street scene with a lone samurai, neon reflections on wet pavement, cinematic lighting"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-200 text-lg font-medium mb-3">Select Platforms:</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                    <label class="flex items-center p-3 bg-gray-700 rounded-lg cursor-pointer hover:bg-blue-900 transition duration-200 border border-gray-600">
                        <input type="checkbox" name="platform" value="DALL-E" class="form-checkbox h-5 w-5 text-red-600 rounded focus:ring-red-500">
                        <span class="ml-2 text-gray-200 font-medium">DALL-E</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-700 rounded-lg cursor-pointer hover:bg-blue-900 transition duration-200 border border-gray-600">
                        <input type="checkbox" name="platform" value="MidJourney" class="form-checkbox h-5 w-5 text-red-600 rounded focus:ring-red-500">
                        <span class="ml-2 text-gray-200 font-medium">MidJourney</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-700 rounded-lg cursor-pointer hover:bg-blue-900 transition duration-200 border border-gray-600">
                        <input type="checkbox" name="platform" value="Stable Diffusion" class="form-checkbox h-5 w-5 text-red-600 rounded focus:ring-red-500">
                        <span class="ml-2 text-gray-200 font-medium">Stable Diffusion</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-700 rounded-lg cursor-pointer hover:bg-blue-900 transition duration-200 border border-gray-600">
                        <input type="checkbox" name="platform" value="DeepAI" class="form-checkbox h-5 w-5 text-red-600 rounded focus:ring-red-500">
                        <span class="ml-2 text-gray-200 font-medium">DeepAI</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-700 rounded-lg cursor-pointer hover:bg-blue-900 transition duration-200 border border-gray-600">
                        <input type="checkbox" name="platform" value="Leonardo" class="form-checkbox h-5 w-5 text-red-600 rounded focus:ring-red-500">
                        <span class="ml-2 text-gray-200 font-medium">Leonardo</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-700 rounded-lg cursor-pointer hover:bg-blue-900 transition duration-200 border border-gray-600">
                        <input type="checkbox" name="platform" value="Gemini Image Generator" class="form-checkbox h-5 w-5 text-red-600 rounded focus:ring-red-500">
                        <span class="ml-2 text-gray-200 font-medium">Gemini Image Generator</span>
                    </label>
                </div>
            </div>

            <div class="mb-6">
                <label for="resolution-select" class="block text-gray-200 text-lg font-medium mb-2">Select Resolution:</label>
                <select id="resolution-select" class="w-full p-3 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200 bg-gray-700 text-white">
                    <option value="512x512">512x512</option>
                    <option value="1024x1024" selected>1024x1024 (Recommended)</option>
                    <option value="1920x1080">1920x1080 (HD)</option>
                    <option value="3840x2160">3840x2160 (4K)</option>
                </select>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <button id="enhance-prompt-btn" class="w-full sm:w-1/2 bg-yellow-500 text-black py-3 rounded-lg font-semibold text-lg hover:bg-yellow-600 transition duration-200 shadow-lg transform hover:scale-105">
                    ✨ Enhance Prompt
                </button>
                <button id="generate-btn" class="w-full sm:w-1/2 bg-red-600 text-white py-3 rounded-lg font-semibold text-lg hover:bg-red-700 transition duration-200 shadow-lg transform hover:scale-105">
                    Generate Images
                </button>
            </div>

            <div id="loading-indicator-generate" class="hidden flex items-center justify-center mt-6 text-red-600">
                <svg class="animate-spin h-8 w-8 mr-3" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Generating text description... Please wait.</span>
            </div>

            <div id="loading-indicator-enhance" class="hidden flex items-center justify-center mt-6 text-yellow-500">
                <svg class="animate-spin h-8 w-8 mr-3" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Enhancing prompt...</span>
            </div>

            <div id="generated-text-container" class="mt-8 grid grid-cols-1 gap-6">
                </div>
        </div>
    </main>

    <footer class="bg-black text-gray-400 py-6 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 VisionHub. All rights reserved. VisionHub is located in Sri Lanka.</p>
            <div class="flex justify-center space-x-6 mt-4">
                <a href="#" class="hover:text-yellow-500 transition duration-300">Privacy Policy</a>
                <a href="#" class="hover:text-yellow-500 transition duration-300">Terms of Service</a>
                <a href="#" class="hover:text-yellow-500 transition duration-300">Support</a>
            </div>
        </div>
    </footer>

    <div id="message-box" class="message-box"></div>

    <div id="image-modal" class="modal">
        <div class="modal-content">
            <button class="close-button" id="close-modal-btn">&times;</button>
            <h3 class="text-2xl font-bold text-white mb-4 text-center">Gemini Generated Image</h3>

            <div id="loading-indicator-modal" class="flex flex-col items-center justify-center text-red-600 py-8">
                <svg class="animate-spin h-12 w-12 mr-3" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="mt-4 text-lg">Generating image with Gemini...</span>
            </div>

            <div id="modal-image-display" class="text-center hidden">
                <img id="modal-generated-image" src="" alt="Generated AI Image" class="max-w-full h-auto rounded-lg shadow-md mx-auto border border-gray-600 mb-4" style="max-height: 70vh;">
                <div class="mt-4 text-sm text-gray-300">
                    <p><strong>Prompt:</strong> <span id="modal-display-prompt"></span></p>
                    <p><strong>Resolution:</strong> <span id="modal-display-resolution"></span></p>
                </div>
                <button id="download-image-btn" class="mt-6 bg-blue-400 text-black py-2 px-6 rounded-lg font-semibold hover:bg-blue-500 transition duration-200">Download Image</button>
            </div>
        </div>
    </div>

    <script>
        // API Key - IMPORTANT: For Canvas environment, leave this empty (""). 
        // Canvas will inject the necessary key at runtime.
        const GEMINI_API_KEY = "AIzaSyDB4QMPn1sTKegSxv7FeeQ5JAvPRPjDEkk"; 

        // Function to show custom messages
        function showMessage(message, duration = 3000) {
            const msgBox = document.getElementById('message-box');
            msgBox.textContent = message;
            msgBox.classList.add('show');
            setTimeout(() => {
                msgBox.classList.remove('show');
            }, duration);
        }

        // Get modal elements
        const imageModal = document.getElementById('image-modal');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const loadingIndicatorModal = document.getElementById('loading-indicator-modal');
        const modalImageDisplay = document.getElementById('modal-image-display');
        const modalGeneratedImage = document.getElementById('modal-generated-image');
        const modalDisplayPrompt = document.getElementById('modal-display-prompt');
        const modalDisplayResolution = document.getElementById('modal-display-resolution');
        const downloadImageBtn = document.getElementById('download-image-btn');

        // Function to open the modal
        function openModal() {
            imageModal.classList.add('show');
        }

        // Function to close the modal
        function closeModal() {
            imageModal.classList.remove('show');
            // Reset modal content for next use
            loadingIndicatorModal.classList.remove('hidden'); // Ensure loading is visible for next open
            modalImageDisplay.classList.add('hidden');       // Hide image display
            modalGeneratedImage.src = '';                    // Clear image
            modalDisplayPrompt.textContent = '';             // Clear prompt text
            modalDisplayResolution.textContent = '';         // Clear resolution text
        }

        // Close modal when close button is clicked
        closeModalBtn.addEventListener('click', closeModal);

        // Close modal when clicking outside the content (on the overlay)
        imageModal.addEventListener('click', (e) => {
            if (e.target === imageModal) {
                closeModal();
            }
        });

        // Event listener for Generate Images button
        document.getElementById('generate-btn').addEventListener('click', async () => {
            const promptInput = document.getElementById('prompt-input');
            const selectedPlatforms = Array.from(document.querySelectorAll('input[name="platform"]:checked')).map(cb => cb.value);
            const resolutionSelect = document.getElementById('resolution-select');
            const selectedResolution = resolutionSelect.value;
            const loadingIndicatorGenerate = document.getElementById('loading-indicator-generate'); // For text descriptions
            const generatedTextContainer = document.getElementById('generated-text-container'); // For text descriptions

            const prompt = promptInput.value.trim();

            // Basic validation
            if (!prompt) {
                showMessage('Please enter a prompt.');
                return;
            }
            if (selectedPlatforms.length === 0) {
                showMessage('Please select at least one platform.');
                return;
            }

            // Clear previous text results if any
            generatedTextContainer.innerHTML = '';

            // Determine if Gemini Image Generator is the ONLY selected platform
            const isGeminiOnlySelected = selectedPlatforms.length === 1 && selectedPlatforms[0] === "Gemini Image Generator";

            if (isGeminiOnlySelected) {
                // Handle actual Gemini Image Generation via modal
                openModal(); 
                loadingIndicatorModal.classList.remove('hidden'); 
                modalImageDisplay.classList.add('hidden'); 

                try {
                    // Payload for imagen-3.0-generate-002
                    const payload = {
                        instances: { prompt: prompt },
                        parameters: { "sampleCount": 1 } 
                    };

                    // API URL for imagen-3.0-generate-002
                    const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/imagen-3.0-generate-002:predict?key=${GEMINI_API_KEY}`;

                    const response = await fetch(apiUrl, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(payload)
                    });

                    const result = await response.json();

                    if (result.predictions && result.predictions.length > 0 && result.predictions[0].bytesBase64Encoded) {
                        const imageUrl = `data:image/png;base64,${result.predictions[0].bytesBase64Encoded}`;

                        modalGeneratedImage.src = imageUrl;
                        modalDisplayPrompt.textContent = prompt;
                        modalDisplayResolution.textContent = selectedResolution;
                        
                        // Setup download button functionality
                        downloadImageBtn.onclick = () => {
                            const link = document.createElement('a');
                            link.href = imageUrl;
                            link.download = `visionhub_gemini_image_${Date.now()}.png`;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        };

                        loadingIndicatorModal.classList.add('hidden');
                        modalImageDisplay.classList.remove('hidden');
                        showMessage('Image generated successfully with Gemini!');
                    } else {
                        // Handle cases where API response is not as expected or no image data
                        let errorMessage = 'Failed to generate image with Gemini. ';
                        if (result.error && result.error.message) {
                            errorMessage += `Error: ${result.error.message}`;
                        } else {
                            errorMessage += 'Response structure unexpected or image data missing.';
                        }
                        showMessage(errorMessage, 5000); // Show error for longer
                        console.error('Gemini API Error or Unexpected Response:', result);
                        closeModal(); // Close modal on error
                    }
                } catch (error) {
                    console.error('Error generating image with Gemini:', error);
                    showMessage('An error occurred during Gemini image generation. Please check your network or try again later.', 5000);
                    closeModal(); // Close modal on error
                }
            } else {
                // Handle text description generation for other platforms (or mixed selections)
                loadingIndicatorGenerate.classList.remove('hidden');

                const aiPromptDescription = `Generate a detailed description of an image based on the following criteria:
                Prompt: "${prompt}"
                Platforms: ${selectedPlatforms.join(', ')}
                Resolution: ${selectedResolution}

                Describe the visual style, colors, composition, and any specific elements that would be present in the generated image. Focus on how the image would look if generated by an advanced AI system, considering the platforms chosen.`;

                try {
                    let chatHistory = [];
                    chatHistory.push({ role: "user", parts: [{ text: aiPromptDescription }] });

                    const payload = { contents: chatHistory };
                    // API URL for gemini-2.0-flash (text generation)
                    const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${GEMINI_API_KEY}`;

                    const response = await fetch(apiUrl, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(payload)
                    });

                    const result = await response.json();

                    if (result.candidates && result.candidates.length > 0 &&
                        result.candidates[0].content && result.candidates[0].content.parts &&
                        result.candidates[0].content.parts.length > 0) {
                        const text = result.candidates[0].content.parts[0].text;

                        const resultCard = document.createElement('div');
                        resultCard.className = 'bg-gray-700 p-6 rounded-lg shadow-md border border-gray-600 text-gray-200';
                        resultCard.innerHTML = `
                            <h3 class="text-xl font-semibold text-white mb-3">Generated Image Description:</h3>
                            <p class="text-gray-300 leading-relaxed whitespace-pre-wrap">${text}</p>
                            <div class="mt-4 flex flex-wrap gap-2 text-sm text-gray-400">
                                <span><strong>Prompt:</strong> "${prompt}"</span>
                                <span><strong>Platforms:</strong> ${selectedPlatforms.join(', ')}</span>
                                <span><strong>Resolution:</strong> ${selectedResolution}</span>
                            </div>
                        `;
                        generatedTextContainer.appendChild(resultCard);
                        showMessage('Image description generated successfully!');
                    } else {
                        showMessage('Failed to generate image description. Please try again.');
                        console.error('Text Description API response structure unexpected:', result);
                    }
                } catch (error) {
                    console.error('Error generating image description:', error);
                    showMessage('An error occurred during text description generation. Please check your network or try again later.');
                } finally {
                    loadingIndicatorGenerate.classList.add('hidden');
                }
            }
        });

        // Event listener for Enhance Prompt button
        document.getElementById('enhance-prompt-btn').addEventListener('click', async () => {
            const promptInput = document.getElementById('prompt-input');
            const loadingIndicatorEnhance = document.getElementById('loading-indicator-enhance');
            const originalPrompt = promptInput.value.trim();

            if (!originalPrompt) {
                showMessage('Please enter a prompt to enhance.');
                return;
            }

            loadingIndicatorEnhance.classList.remove('hidden');
            document.getElementById('generated-text-container').innerHTML = ''; // Clear previous results

            const enhancePromptInstruction = `Refine and expand the following image generation prompt to make it more detailed, creative, and effective for an AI image generator. Focus on adding descriptive elements, artistic styles, lighting, mood, and specific details that would lead to a high-quality image. The output should be only the enhanced prompt, without any conversational text or explanations.

            Original Prompt: "${originalPrompt}"

            Enhanced Prompt:`;

            try {
                let chatHistory = [];
                chatHistory.push({ role: "user", parts: [{ text: enhancePromptInstruction }] });

                const payload = { contents: chatHistory };
                const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${GEMINI_API_KEY}`;

                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (result.candidates && result.candidates.length > 0 &&
                    result.candidates[0].content && result.candidates[0].content.parts &&
                    result.candidates[0].content.parts.length > 0) {
                    const enhancedPrompt = result.candidates[0].content.parts[0].text.trim();
                    promptInput.value = enhancedPrompt; // Update the textarea with the enhanced prompt
                    showMessage('Prompt enhanced successfully! ✨');
                } else {
                    showMessage('Failed to enhance prompt. Please try again.');
                    console.error('Enhance Prompt API response structure unexpected:', result);
                }
            } catch (error) {
                console.error('Error enhancing prompt:', error);
                showMessage('An error occurred during prompt enhancement. Please check your network or try again later.');
            } finally {
                loadingIndicatorEnhance.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
