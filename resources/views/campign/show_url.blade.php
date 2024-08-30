@php
     $topic_offer_url = json_decode($campaign->topic_offer_url, true);
     $offer_url = implode(",\n\n", $topic_offer_url);
@endphp
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label>{{ __('Topic Domain URL') }}:</label>
            <textarea class="form-control" name="topic_offer_url" readonly rows="20">{!! $offer_url !!}</textarea>
        </div>
    </div>
</div>