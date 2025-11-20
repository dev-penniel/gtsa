{{-- resources/views/blogs/static-design.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Blog — Static Design</title>
  <!-- Make sure Tailwind CSS is loaded in your app layout -->
  <link rel="stylesheet" href="/path/to/your/tailwind.css" />
</head>
<body class="bg-gray-50 text-gray-800">
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-extrabold tracking-tight">Blog</h1>
      <p class="text-gray-500 mt-1">Explore posts, filter by category, and find what you need.</p>
    </div>

    <!-- Filters (replace with your dynamic buttons) -->
    <div class="mb-8 flex items-center gap-3 overflow-x-auto pb-2">
      <!-- Replace the below static buttons with your category buttons -->
      <button class="px-4 py-2 rounded-full text-sm font-medium shadow-sm transition bg-blue-600 text-white">All</button>
      <button class="px-4 py-2 rounded-full text-sm font-medium shadow-sm transition bg-white text-gray-700 border">Photography</button>
      <button class="px-4 py-2 rounded-full text-sm font-medium shadow-sm transition bg-white text-gray-700 border">Design</button>
      <button class="px-4 py-2 rounded-full text-sm font-medium shadow-sm transition bg-white text-gray-700 border">Business</button>
      <button class="px-4 py-2 rounded-full text-sm font-medium shadow-sm transition bg-white text-gray-700 border">Tutorials</button>
    </div>

    <!-- === Special two-column layout (show this only for the chosen category) === -->
    <!-- Wrap this block in your condition (e.g., when category === 'photography') -->
    <section class="special-two-col grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
      <!-- Left: large image with fixed height -->
      <div class="relative overflow-hidden rounded-xl shadow-md h-96">
        <!-- Replace src with the featured image URL -->
        <img src="/storage/featured-cover.jpg" alt="Featured title" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>

        <div class="absolute bottom-0 left-0 w-full p-4 text-white">
          <!-- Replace with featured title and excerpt -->
          <h2 class="text-2xl font-bold drop-shadow-md">Featured photography</h2>
          <p class="text-sm drop-shadow-sm">A short description or excerpt that sits over the image.</p>
        </div>
      </div>

      <!-- Right: scrollable list whose height matches left (h-96) -->
      <div class="h-96 overflow-y-auto space-y-4">
        <!-- Repeat this card block for each post in the special list -->
        <a href="#" class="block group">
          <div class="flex items-start gap-4 p-4 rounded-xl border hover:shadow-md transition">
            <div class="flex-shrink-0 w-28 h-20 rounded-md overflow-hidden bg-gray-100">
              <img src="/storage/thumb-1.jpg" alt="Post title" class="w-full h-full object-cover">
            </div>

            <div class="flex-1">
              <h3 class="font-semibold text-lg group-hover:text-blue-600">Post title 1</h3>
              <p class="text-sm text-gray-500 mt-1 line-clamp-2">Short excerpt for the post, one or two lines.</p>
              <div class="mt-2 flex items-center text-xs text-gray-400">
                <span>Mar 12, 2025</span>
                <span class="mx-2">·</span>
                <span>4 min read</span>
              </div>
            </div>
          </div>
        </a>

        <a href="#" class="block group">
          <div class="flex items-start gap-4 p-4 rounded-xl border hover:shadow-md transition">
            <div class="flex-shrink-0 w-28 h-20 rounded-md overflow-hidden bg-gray-100">
              <img src="/storage/thumb-2.jpg" alt="Post title" class="w-full h-full object-cover">
            </div>

            <div class="flex-1">
              <h3 class="font-semibold text-lg group-hover:text-blue-600">Post title 2</h3>
              <p class="text-sm text-gray-500 mt-1 line-clamp-2">Another short excerpt for the post.</p>
              <div class="mt-2 flex items-center text-xs text-gray-400">
                <span>Feb 26, 2025</span>
                <span class="mx-2">·</span>
                <span>6 min read</span>
              </div>
            </div>
          </div>
        </a>

        <a href="#" class="block group">
          <div class="flex items-start gap-4 p-4 rounded-xl border hover:shadow-md transition">
            <div class="flex-shrink-0 w-28 h-20 rounded-md overflow-hidden bg-gray-100">
              <img src="/storage/thumb-2.jpg" alt="Post title" class="w-full h-full object-cover">
            </div>

            <div class="flex-1">
              <h3 class="font-semibold text-lg group-hover:text-blue-600">Post title 2</h3>
              <p class="text-sm text-gray-500 mt-1 line-clamp-2">Another short excerpt for the post.</p>
              <div class="mt-2 flex items-center text-xs text-gray-400">
                <span>Feb 26, 2025</span>
                <span class="mx-2">·</span>
                <span>6 min read</span>
              </div>
            </div>
          </div>
        </a>

        <a href="#" class="block group">
          <div class="flex items-start gap-4 p-4 rounded-xl border hover:shadow-md transition">
            <div class="flex-shrink-0 w-28 h-20 rounded-md overflow-hidden bg-gray-100">
              <img src="/storage/thumb-2.jpg" alt="Post title" class="w-full h-full object-cover">
            </div>

            <div class="flex-1">
              <h3 class="font-semibold text-lg group-hover:text-blue-600">Post title 2</h3>
              <p class="text-sm text-gray-500 mt-1 line-clamp-2">Another short excerpt for the post.</p>
              <div class="mt-2 flex items-center text-xs text-gray-400">
                <span>Feb 26, 2025</span>
                <span class="mx-2">·</span>
                <span>6 min read</span>
              </div>
            </div>
          </div>
        </a>

        <a href="#" class="block group">
          <div class="flex items-start gap-4 p-4 rounded-xl border hover:shadow-md transition">
            <div class="flex-shrink-0 w-28 h-20 rounded-md overflow-hidden bg-gray-100">
              <img src="/storage/thumb-2.jpg" alt="Post title" class="w-full h-full object-cover">
            </div>

            <div class="flex-1">
              <h3 class="font-semibold text-lg group-hover:text-blue-600">Post title 2</h3>
              <p class="text-sm text-gray-500 mt-1 line-clamp-2">Another short excerpt for the post.</p>
              <div class="mt-2 flex items-center text-xs text-gray-400">
                <span>Feb 26, 2025</span>
                <span class="mx-2">·</span>
                <span>6 min read</span>
              </div>
            </div>
          </div>
        </a>

        <!-- Add as many items as needed; the container will scroll to match the left image height -->
      </div>
    </section>

    <!-- === Main Blog Grid (fallback or for other categories) === -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Repeat this card for each post in the main grid -->
      <a href="#" class="group block relative rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
        <div class="relative h-48 w-full">
          <img src="/storage/post-1.jpg" alt="Post title" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">

          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>

          <div class="absolute bottom-0 left-0 w-full p-4 text-white">
            <div class="flex justify-between items-end">
              <div>
                <h3 class="text-xl font-bold drop-shadow-md">Grid post title</h3>
                <p class="text-sm drop-shadow-sm">Category name</p>
              </div>
              <!-- Optional meta/rating area -->
            </div>
          </div>
        </div>
      </a>

      <a href="#" class="group block relative rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
        <div class="relative h-48 w-full">
          <img src="/storage/post-2.jpg" alt="Post title" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">

          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>

          <div class="absolute bottom-0 left-0 w-full p-4 text-white">
            <div class="flex justify-between items-end">
              <div>
                <h3 class="text-xl font-bold drop-shadow-md">Another title</h3>
                <p class="text-sm drop-shadow-sm">Category name</p>
              </div>
            </div>
          </div>
        </div>
      </a>

      <!-- Repeat cards as needed, or render with your loop -->
      <div class="col-span-full p-8 text-center text-gray-500">
        <!-- Optionally show an empty state -->
        <!-- Remove this block when you have posts -->
        No posts found in this category.
      </div>
    </section>

    <!-- Pagination (replace with your pagination links) -->
    <div class="mt-8 flex justify-center">
      <nav class="inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
        <a href="#" class="px-3 py-2 rounded-l-md border bg-white text-gray-700">Prev</a>
        <a href="#" class="px-3 py-2 border bg-white text-gray-700">1</a>
        <a href="#" class="px-3 py-2 border bg-white text-gray-700">2</a>
        <a href="#" class="px-3 py-2 border bg-white text-gray-700">3</a>
        <a href="#" class="px-3 py-2 rounded-r-md border bg-white text-gray-700">Next</a>
      </nav>
    </div>
  </div>

  <!-- Optional: include your JS (Alpine, Livewire, etc.) -->
  <script src="/path/to/your/app.js"></script>
</body>
</html>
