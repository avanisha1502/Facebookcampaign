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
                    <th>{{ __('Description') }}</th>
                    <th> {{ __('Images') }} </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($headlines as $item)
                    <tr>
                        <td>{{ $item->language }}</td>
                        @php
                             $shortheadline = \Illuminate\Support\Str::limit($item->headline , 150);
                             $shortprimary_text = \Illuminate\Support\Str::limit($item->primary_text , 100);
                             $shortdescription = \Illuminate\Support\Str::limit($item->description , 100);
                             $imageUrls = json_decode($item->images , true);
                        @endphp
                        <td class="hover-tooltip"  data-tooltip-position="bottom" data-tooltip="{{ $item->headline }}">{{ $shortheadline }}</td>
                        <td class="hover-tooltip"  data-tooltip-position="bottom" data-tooltip="{{ $item->primary_text }}">{{ $shortprimary_text }}</td>
                        <td class="hover-tooltip"  data-tooltip-position="bottom" data-tooltip="{{ $item->description }}">{{ $shortdescription }}</td>
                        <td>
                            <div class="image-container">
                                @if($imageUrls && is_array($imageUrls))
                                    @foreach($imageUrls as $imageUrl)
                                        <img src="{{ $imageUrl }}" alt="Image" class="img">
                                    @endforeach
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Close</button>
    </div>
</div>
