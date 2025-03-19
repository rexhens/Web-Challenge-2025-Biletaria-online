<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Show</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-gold-400 flex justify-center items-center min-h-screen">
    <div class="w-full max-w-lg p-6 bg-gray-800 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-4">Add New Show</h2>
        <form id="showForm" action="save_show.php" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" id="id" name="id">

            <label class="block">Title:
                <input type="text" name="title" class="w-full p-2 bg-gray-700 text-white rounded" required>
            </label>

            <label class="block">Hall:
                <input type="text" name="hall" class="w-full p-2 bg-gray-700 text-white rounded" required>
            </label>

            <label class="block">Genre:</label>
            <div id="genresContainer" class="flex space-x-2 overflow-x-auto p-2 bg-gray-700 rounded">
                <!-- Genres will be inserted here dynamically -->
            </div>
            <input type="hidden" name="genre_id" id="selectedGenre">

            <label class="block">Start Date:
                <input type="date" name="start_date" class="w-full p-2 bg-gray-700 text-white rounded" required>
            </label>

            <label class="block">End Date:
                <input type="date" name="end_date" class="w-full p-2 bg-gray-700 text-white rounded" required>
            </label>

            <label class="block">Description:
                <textarea name="description" class="w-full p-2 bg-gray-700 text-white rounded" required></textarea>
            </label>

            <div class="mb-3 text-center">
                <label class="cursor-pointer block" onclick="document.getElementById('posterInput').click()">
                    <img id="posterPreview" class="photo-preview hidden mx-auto w-40 h-40 object-cover rounded-lg"
                        src="#" alt="Preview">
                    <p class="text-sm text-gray-400 mt-2">Click to upload photo</p>
                </label>
                <input type="file" name="poster" id="posterInput" accept="image/*" class="hidden" required
                    onchange="previewImage(event)">
            </div>

            <button type="submit" class="w-full bg-gold-500 text-gray-900 py-2 rounded hover:bg-gold-600">Add
                Show</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('posterPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const genresContainer = document.getElementById("genresContainer");
            const selectedGenreInput = document.getElementById("selectedGenre");

            fetch("../genres/get_genres.php")
                .then(response => response.json())
                .then(genres => {
                    genres.forEach(genre => {
                        const genreDiv = document.createElement("div");
                        genreDiv.textContent = genre.genre_name; // Make sure this matches your DB column
                        genreDiv.classList.add("px-4", "py-2", "rounded", "cursor-pointer", "bg-gray-600", "text-white", "hover:bg-gold-500", "transition", "duration-300");
                        genreDiv.dataset.id = genre.id;

                        genreDiv.addEventListener("click", function () {
                            // Remove selection from all genres
                            document.querySelectorAll("#genresContainer div").forEach(div => {
                                div.classList.remove("bg-gold-500", "border-2", "border-gold-400", "p-3");
                                div.classList.add("px-4", "py-2");
                            });

                            // Highlight the selected genre
                            genreDiv.classList.add("bg-gold-500", "border-2", "border-gold-400", "p-3");
                            selectedGenreInput.value = genre.id;
                        });

                        genresContainer.appendChild(genreDiv);
                    });
                })
                .catch(error => console.error("Error loading genres:", error));
        });

    </script>
</body>

</html>