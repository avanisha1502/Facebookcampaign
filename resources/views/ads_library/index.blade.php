@extends('admin.home')

@section('contents')
    <div class="d-flex align-items-center mb-3">
        <div>
            <h1 class="page-header mb-0">{{ __('Ads library') }}</h1>
        </div>
    </div>

    <form id="adsForm" class="mb-5">


        <div class="card">
            <div class="card-body d-flex gap-2 flex-wrap align-items-end ">
                <div class="d-flex flex-column">
                    <label for="ad_active_status" class="block mt-4 mb-2 text-lg font-medium text-muted">Select
                        Country:</label>
                    <select id="ad_reached_countries" name="ad_reached_countries" class="block w-full p-2 border rounded">
                        @foreach ($countries as $country)
                            <option value="{{ $country->short_code }}">
                                {{ $country->name }} ({{ $country->short_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex flex-column">
                    <label for="ad_active_status" class="block mt-4 mb-2 text-lg font-medium text-muted">Ad Active
                        Status:</label>
                    <select id="ad_active_status" name="ad_active_status" class="block w-full p-2 border rounded">
                        <option value="ALL">All</option>
                        <option value="ACTIVE">Active</option>
                        <option value="INACTIVE">Inactive</option>
                    </select>
                </div>
                <div class="d-flex flex-column">
                    <label for="ad_type" class="block mt-4 mb-2 text-lg font-medium text-muted">Ad Type:</label>
                    <select id="ad_type" name="ad_type" class="block w-full p-2 border rounded">
                        <option value="ALL">All</option>
                        <option value="CREDIT_ADS">Credit Ads</option>
                        <option value="EMPLOYMENT_ADS">Employment Ads</option>
                        <option value="HOUSING_ADS">Housing Ads</option>
                        <option value="POLITICAL_AND_ISSUE_ADS">Political and Issue Ads</option>
                    </select>
                </div>
                <div class="d-flex flex-column">
                    <label for="media_type" class="block mt-4 mb-2 text-lg font-medium text-muted">Media Type:</label>
                    <select id="media_type" name="media_type" class="block w-full p-2 border rounded">
                        <option value="ALL">All</option>
                        <option value="IMAGE">Image</option>
                        <option value="MEME">Meme</option>
                        <option value="VIDEO">Video</option>
                        <option value="NONE">None</option>
                    </select>
                </div>
                <div class="d-flex flex-column">
                    <label for="publisher_platforms" class="block mt-4 mb-2 text-lg font-medium text-muted">Publisher
                        Platforms:</label>
                    <select id="publisher_platforms" name="publisher_platforms" class="block w-full p-2 border rounded">
                        <option value="FACEBOOK">Facebook</option>
                        <option value="INSTAGRAM">Instagram</option>
                        <option value="AUDIENCE_NETWORK">Audience Network</option>
                        <option value="MESSENGER">Messenger</option>
                        <option value="WHATSAPP">WhatsApp</option>
                        <option value="OCULUS">Oculus</option>
                        <option value="THREADS">Threads</option>
                    </select>
                </div>
                <div class="d-flex flex-column">
                    <label for="publisher_platforms" class="block mt-4 mb-2 text-lg font-medium text-muted">Search
                        Terms:</label>
                    <input type="text" id="search_terms" class="block w-full p-2 border rounded" required>
                </div>
                <button type="button" id="fetchButton" onclick="fetchAds()" class="btn btn-primary mt-4 h-100 mb-1">Fetch
                    Ads</button>
            </div>
        </div>
    </form>

    <div id="adsResult" class="d-flex flex-column gap-2">

    </div> <!-- Ads grid -->
    <div class="d-flex justify-content-center mt-5">
        <button type="button" id="loadMoreButton" onclick="loadMoreAds()" class="d-none btn btn-primary">Load More
            Ads</button>
    </div>
@endsection

@push('scripts')
    <script>
        // Function to fetch ads based on selected country
        function fetchAds() {

            const searchTermsInput = document.getElementById('search_terms');
            const searchTerms = searchTermsInput.value.trim();

            if (searchTerms === '') {
                alert('Search terms are required.');
                return; // Stop the function if search terms are empty
            }

            const selectedCountry = document.getElementById('ad_reached_countries').value;
            const selectedActiveStatus = document.getElementById('ad_active_status').value;
            const selectedAdType = document.getElementById('ad_type').value;
            const selectedMediaType = document.getElementById('media_type').value;
            const selectedPublisherPlatforms = document.getElementById('publisher_platforms').value;
            const search_terms = document.getElementById('search_terms').value;
            const baseUrl = @json(route('fetchAds'));

            // Show loader
            document.getElementById('fetchButton').innerHTML = 'Loading...';
            document.getElementById('loadMoreButton').classList.add('d-none');

            // Make an AJAX request to the server
            fetch(
                    `${baseUrl}?ad_reached_countries=${selectedCountry}&ad_active_status=${selectedActiveStatus}&ad_type=${selectedAdType}&media_type=${selectedMediaType}&publisher_platforms=${selectedPublisherPlatforms}&search_terms=${search_terms}`
                )
                .then(response => response.json())
                .then(data => {
                    // Hide loader
                    document.getElementById('adsResult').innerHTML = '';
                    // Store fetched ads and the 'after' cursor for pagination
                    adsData = data.ads;
                    afterCursor = data.paging?.cursors?.after || null;
                    displayAds(); // Display ads
                    document.getElementById('fetchButton').innerHTML = 'Fetch Ads';
                })
                .catch(error => {
                    console.error('Error fetching ads:', error);
                    // Hide loader and show error message
                    document.getElementById('adsResult').innerHTML =
                        '<p class="text-center text-danger">Error fetching ads. Please try again.</p>';
                });
        }

        function displayAds() {
            const adsResultDiv = document.getElementById('adsResult');
            adsResultDiv.innerHTML = ''; // Clear the existing ads

            // Ensure adsData is an array and has elements
            if (Array.isArray(adsData) && adsData.length > 0) {
                adsData.forEach(ad => {
                    const {
                        page_name = '',
                            id = '',
                            ad_creative_bodies = [''],
                            extracted_images = {
                                resized_image_urls: [],
                                video_sd_urls: []
                            },
                            ad_creative_link_titles = ['']
                    } = ad;

                    // Create the card layout
                    let adHtml = `
            <div class="card">
                <div class="card-body">
                <div class="d-flex gap-2">
                    <div>
                        ${buildMediaCarousel(id, extracted_images)}
                    </div>
                <div>
                    <div class="d-flex gap-3 align-items-center"> 
                        <h5 class="card-title mt-1">${page_name}</h5>
                        <small class="text-muted"><b>Library ID:</b> ${id}</small>
                    </div>
                    <!-- Ad Creative Body with 'More' button if needed -->
                    ${buildCreativeBody(ad_creative_bodies[0])}
                </div>
                </div> 
                </div>  
            </div>`;

                    adsResultDiv.innerHTML += adHtml;
                });

                // After ads are rendered, initialize the carousels
                initializeCarousel();
            } else {
                adsResultDiv.innerHTML = '<p class="text-center text-muted">No ads found for the selected country.</p>';
            }

            // Show or hide the 'Load More' button depending on the after cursor
            const loadMoreButton = document.getElementById('loadMoreButton');

            if (afterCursor) {
                loadMoreButton.classList.remove('d-none');
            } else {
                loadMoreButton.classList.add('d-none');
            }
        }

        function buildMediaCarousel(id, extracted_images) {
            let mediaHtml = '';

            if (extracted_images.resized_image_urls.length > 1 || extracted_images.video_sd_urls.length > 1) {
                // Multiple media items (images or videos): create a carousel
                mediaHtml += `
            <div id="carousel${id}" class="carousel slide" data-bs-ride="carousel" style="width: 100px; height: 100px;">
                <div class="carousel-inner">`;

                // Add images to the carousel
                extracted_images.resized_image_urls.forEach((imageUrl, index) => {
                    mediaHtml += `
                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                    <img src="${imageUrl}" style="width: 100px; height: 100px; object-fit: cover;" alt="Ad Image">
                </div>`;
                });

                // Add videos to the carousel
                extracted_images.video_sd_urls.forEach((videoUrl, index) => {
                    mediaHtml += `
                <div class="carousel-item ${extracted_images.resized_image_urls.length === 0 && index === 0 ? 'active' : ''}">
                    <video style="width: 100px; height: 100px; object-fit: cover;" controls>
                        <source src="${videoUrl}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>`;
                });

                mediaHtml += `
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel${id}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel${id}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>`;
            } else if (extracted_images.resized_image_urls.length === 1) {
                // Single image: display image
                mediaHtml +=
                    `<img style="width: 100px; height: 100px; object-fit: cover;" src="${extracted_images.resized_image_urls[0]}"  alt="Ad Image">`;
            } else if (extracted_images.video_sd_urls.length === 1) {
                // Single video: display video
                mediaHtml += `
            <video style="width: 100px; height: 100px; object-fit: cover;" controls>
                <source src="${extracted_images.video_sd_urls[0]}" type="video/mp4">
                Your browser does not support the video tag.
            </video>`;
            }

            return mediaHtml;
        }


        function buildCreativeBody(adCreativeBody) {
            const wordLimit = 600;
            let creativeBodyHtml = '';
            if (adCreativeBody.length > wordLimit) {
                // If the ad creative body is longer than the limit, truncate it and add a 'More' button
                const truncatedBody = adCreativeBody.substring(0, wordLimit);
                creativeBodyHtml +=
                    `
            <div class="card-text truncated-text">${truncatedBody}... <button class="btn btn-link" onclick="showFullText(this)">More</button></div>
            <div class="full-text d-none">${adCreativeBody} <button class="btn btn-link" onclick="hideFullText(this)">Less</button></div>`;
            } else {
                // If the ad creative body is within the limit, show it fully
                creativeBodyHtml += `<p class="card-text">${adCreativeBody}</p>`;
            }
            return creativeBodyHtml;
        }

        function showFullText(button) {
            const cardText = button.closest('.truncated-text');
            const fullText = cardText.nextElementSibling;
            if (fullText && fullText.classList.contains('full-text')) {
                fullText.classList.remove('d-none');
                cardText.classList.add('d-none');
            }
        }

        function hideFullText(button) {
            const fullText = button.closest('.full-text');
            const truncatedText = fullText.previousElementSibling;
            if (truncatedText && truncatedText.classList.contains('truncated-text')) {
                fullText.classList.add('d-none');
                truncatedText.classList.remove('d-none');
            }
        }

        // Function to initialize carousel
        function initializeCarousel() {
            const carousels = document.querySelectorAll('.carousel');
            carousels.forEach(carousel => {
                if (carousel instanceof HTMLElement) { // Ensure it's a valid DOM element
                    // Initialize Bootstrap carousel
                    // Bootstrap carousel initialization might be automatic, so this might be optional
                } else {
                    console.warn('Invalid carousel element:', carousel);
                }
            });
        }

        // Function to load more ads when the user clicks 'Load More'
        function loadMoreAds() {
            const selectedCountry = document.getElementById('ad_reached_countries').value;
            const selectedActiveStatus = document.getElementById('ad_active_status').value;
            const selectedAdType = document.getElementById('ad_type').value;
            const selectedMediaType = document.getElementById('media_type').value;
            const selectedPublisherPlatforms = document.getElementById('publisher_platforms').value;
            const search_terms = document.getElementById('search_terms').value;
            const baseUrl = @json(route('fetchAds'));

            // Show loader
            document.getElementById('loadMoreButton').innerHTML = 'Loading...';

            // Make a request with the 'after' cursor to fetch the next set of ads
            fetch(
                    `${baseUrl}?ad_reached_countries=${selectedCountry}&ad_active_status=${selectedActiveStatus}&ad_type=${selectedAdType}&media_type=${selectedMediaType}&publisher_platforms=${selectedPublisherPlatforms}&search_terms=${search_terms}&after=${afterCursor}`)
                .then(response => response.json())
                .then(data => {
                    // Append the new ads to the existing ones
                    adsData = [...adsData, ...data.ads];
                    afterCursor = data.paging?.cursors?.after || null;
                    displayAds(); // Re-render ads and update the UI
                    document.getElementById('loadMoreButton').innerHTML = 'Load More Ads';
                })
                .catch(error => {
                    console.error('Error loading more ads:', error);
                    // Hide loader and show error message
                    document.getElementById('loadMoreButton').innerHTML = 'Error loading more ads. Please try again.';
                });
        }
    </script>
@endpush
