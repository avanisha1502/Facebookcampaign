<style>
    .image-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px; /* Adjust spacing between images if needed */
    }

    .image-container .img {
        width: calc(25% - 2px);/* Adjust based on the gap between images */
        height: auto;
        margin-bottom: 10px; /* Adjust bottom margin if needed */
    }

    .image-container img {
        max-width: 100%;
        height: auto;
        object-fit: cover; /* Keeps aspect ratio and covers the area */
        border-radius: 5px;
    }
    </style>

<div class="row gx-4">
    <div class="col-xl-12">
        <table class="table w-100 table-striped">
            <thead>
                <tr>
                    <th>{{ __('Language') }}</th>
                    <th>{{ __('Headline') }}</th>
                    <th>{{ __('Primary Text') }}</th>
                    <th> {{ __('Images') }} </th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($campaignAllDetails as $item) --}}
                    <tr>
                        <td>{{ $campaignAllDetails->language }}</td>
                        @php
                             $shortheadline = \Illuminate\Support\Str::limit($campaignAllDetails->headlines , 150);
                             $shortprimary_text = \Illuminate\Support\Str::limit($campaignAllDetails->primary_text , 100);
                             $imageUrls = json_decode($campaignAllDetails->image , true);
          
                        @endphp
                        <td class="hover-tooltip"  data-tooltip-position="bottom" data-tooltip="{{ $campaignAllDetails->headlines }}">{{ $shortheadline }}</td>
                        <td class="hover-tooltip"  data-tooltip-position="bottom" data-tooltip="{{ $campaignAllDetails->primary_text }}">{{ $shortprimary_text }}</td>
                        <td>
                            <div class="image-container">
                                        {{-- <img src="{{ $campaignAllDetails->image }}" alt="Image" class="img"> --}}
                                {{-- @if($imageUrls && is_array($imageUrls))
                                    @foreach($imageUrls as $imageUrl)
                                        <img src="{{ $imageUrl }}" alt="Image" class="img">
                                    @endforeach
                                @endif --}}
                                   @if ($imageUrls && is_array($imageUrls))
                                @foreach ($imageUrls as $mediaUrl)
                                    @if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $mediaUrl))
                                        <img src="{{ $mediaUrl }}" alt="Image" class="img">
                                    @elseif(preg_match('/\.(mp4|webm|ogg)$/i', $mediaUrl))
                                        <video controls class="video" style="width: 117px; border-radius: 6px;">
                                            <source src="{{ $mediaUrl }}" type="video/mp4">
                                        </video>
                                    @else
                                        <p>Unsupported media type.</p>
                                    @endif
                                @endforeach
                            @endif
                            </div>
                        </td>
                    </tr>
                {{-- @endforeach --}}
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Close</button>
    </div>
</div>
