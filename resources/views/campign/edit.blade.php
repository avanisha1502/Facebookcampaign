@extends('admin.home')
<style>
    .disabled-tagsinput {
        pointer-events: none;
        /* Prevents mouse interaction */
        background-color: #e9ecef;
        /* Gray background to indicate disabled state */
        cursor: not-allowed;
        /* Shows 'not allowed' cursor */
        opacity: 0.6;
        /* Optional: Make it look visually disabled */
    }
</style>
@section('contents')
    <div class="row gx-4">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header bg-none fw-bold">
                    Facebook Campaign
                </div>
                <form action="{{ route('update-campaign', $campaign->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Vertical <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="vertical" placeholder="Enter Vertical"
                                        value="{{ $campaign->vertical }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Topic<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="topic" placeholder="Enter Topic"
                                        value="{{ $campaign->topic }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Keywords') }}<span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="keyword" placeholder="Enter Keyword" rows="7"
                                        value="{{ $campaign->keyword }}">{{ $campaign->keyword }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Tracking Url') }}<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="tracking_url" placeholder="Enter Tracking Url" rows="7">{{ str_replace(',', "\n\n", $campaign->tracking_url) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ads Campaign<span class="text-danger">*</span></label>
                                    <select class="form-control" id="ex-search" name="campaing_id">
                                        @foreach ($adscampaign as $campaigns)
                                            <option value="{{ $campaigns->id }}"
                                                {{ $campaign->campaing_id == $campaigns->id ? 'selected' : '' }}>
                                                {{ $campaigns->name }} - Ad account ID : {{ $campaigns->account_id }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-check-label" for="is_regions">Regions</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" name="is_regions" id="is_regions"
                                            value="1" {{ $campaign->is_region == 1 ? 'checked' : '' }}>

                                    </div>
                                </div>
                            </div>
                        </div>

                        @php
                            $campaignNames = json_decode($campaign->topic_campaign_name, true);
                            $campaigns = implode(', ', $campaignNames);

                            $DomainName = json_decode($campaign->topic_domain_name, true);
                            $domains = implode(', ', $DomainName);

                            $topic_offer_url = json_decode($campaign->topic_offer_url, true);
                            $offer_url = implode(",\n\n", $topic_offer_url);

                        @endphp

                        <div class="mb-3">
                            <label class="form-label">Topic Domain Name<span class="text-danger">*</span></label>
                            <div class="u-tagsinput" readonly>
                                <input class="form-control disabled-tagsinput tags_id" data-role="tagsinput"
                                    id="tags_domain" name="topic_domain_name" value="{{ $domains }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Topic Campaign Name<span class="text-danger">*</span></label>
                            <div class="u-tagsinput">
                                <input class="form-control disabled-tagsinput tags_id" data-role="tagsinput" id="tags_id"
                                    name="topic_campaign_name" value="{{ $campaigns }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Topic Offer URL<span class="text-danger">*</span></label>
                            <div class="">
                                <textarea class="form-control" name="topic_offer_url" readonly rows="20">{!! $offer_url !!}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end ">
                                <button type="submit" class="btn btn-primary">Update Campaign</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Select elements by ID and class
                var tagsDomainInput = document.querySelector('#tags_domain');
                var tagsCampaignInput = document.querySelector('#tags_id');

                // Ensure both elements are correctly selected and apply additional settings
                if (tagsDomainInput) {
                    // Apply styles to make it look disabled
                    tagsDomainInput.classList.add('disabled-tagsinput');
                    tagsDomainInput.setAttribute('readonly', true);
                    tagsDomainInput.setAttribute('disabled', true); // Prevents interaction
                }

                if (tagsCampaignInput) {
                    // Apply styles to make it look disabled
                    tagsCampaignInput.classList.add('disabled-tagsinput');
                    tagsCampaignInput.setAttribute('readonly', true);
                    tagsCampaignInput.setAttribute('disabled', true); // Prevents interaction
                }

                // Optional: Add event listeners to ensure no interaction
                var preventInteraction = function(e) {
                    e.preventDefault();
                };

                if (tagsDomainInput) {
                    tagsDomainInput.addEventListener('keydown', preventInteraction);
                    tagsDomainInput.addEventListener('paste', preventInteraction);
                    tagsDomainInput.addEventListener('drop', preventInteraction);
                }

                if (tagsCampaignInput) {
                    tagsCampaignInput.addEventListener('keydown', preventInteraction);
                    tagsCampaignInput.addEventListener('paste', preventInteraction);
                    tagsCampaignInput.addEventListener('drop', preventInteraction);
                }
            });
        </script>
    @endpush
